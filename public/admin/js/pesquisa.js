function formatarData(data) {
    var dataObj = new Date(data);

    var dia = dataObj.getUTCDate().toString().padStart(2, '0');
    var mes = (dataObj.getUTCMonth() + 1).toString().padStart(2, '0');
    var ano = dataObj.getUTCFullYear().toString();

    return dia + '/' + mes + '/' + ano;
}

function pesquisaCPFCNPJ(){
    let cpfcnpj = $('input[name=cpfcnpj]').val();
    let dataNascimento = $('input[name=dataNascimento]').val();

    if(cpfcnpj.length > 13){
        $.ajax({
            url: "http://ws.hubdodesenvolvedor.com.br/v2/cnpj/?cnpj="+cpfcnpj+"&token=124678250wDRJmrCEXu225102800",
            method:'GET',
            complete: function(xhr){

              response = xhr.responseJSON;

              if(response.return == 'OK') {
                    response = response.result;
                    $('#pesquisa').addClass('d-none');
                    $('#cadastro').removeClass('d-none');

                    $('#cliente').val(response.fantasia);
                    $('#cpfcnpj').val(response.numero_de_inscricao);
                    $('#situacao').val(response.situacao);
                    $('#dataNascimento').val(response.dt_situacao_cadastral);
              } else {
                alert('Erro ao pesquisar documento!');
              }
            }
        });
    }else{
        $.ajax({
            url: "https://ws.hubdodesenvolvedor.com.br/v2/cpf/?cpf="+cpfcnpj+"&data="+formatarData(dataNascimento)+"&token=124678250wDRJmrCEXu225102800",
            method:'GET',
            complete: function(xhr){

              response = xhr.responseJSON;

              if(response.return == 'OK') {
                    response = response.result;
                    $('#pesquisa').addClass('d-none');
                    $('#cadastro').removeClass('d-none');

                    $('#cliente').val(response.nome_da_pf);
                    $('#cpfcnpj').val(response.numero_de_cpf);
                    $('#situacao').val(response.situacao_cadastral);
                    $('#dataNascimento').val(response.data_nascimento);

              } else {
                alert('Erro ao pesquisar documento!');
              }
            }
        });
    }
}

function geraPagamento(botao){

    Swal.fire({
        title: 'Opções de Pagamento',
        html:
          '<div class="row w-100">' +
          '  <div class="col-6">' +
          '    <select id="opcaoPagamento" class="form-control">' +
          '      <option value="PIX">Pix</option>' +
          '    </select>' +
          '  </div>' +
          '  <div class="col-6">' +
          '    <select id="opcaoParcelas" class="form-control">' +
          '      <option value="1">1x</option>' +
          '    </select>' +
          '  </div>' +
          '</div>',
        showCancelButton: true,
        showConfirmButton: true,
        confirmButtonText: 'Confirmar',
        confirmButtonColor: '#008000',
        cancelButtonText: 'Cancelar',
        cancelButtonColor: '#ff0000',
        allowOutsideClick: false,
        focusConfirm: false,
      }).then((result) => {
        if (result.isConfirmed) {

            var dataAtual = new Date();
            dataAtual.setDate(dataAtual.getDate() + 3);
            var dataFormatada = dataAtual.toISOString().split('T')[0];

            var data = {
                id              : botao.dataset.id,
                name            : botao.dataset.name,
                cpfcnpj         : botao.dataset.cpfcnpj,
                dataFormatada   : dataFormatada,
                opcaoPagamento  : document.getElementById('opcaoPagamento').value,
                opcaoParcelas   : document.getElementById('opcaoParcelas').value
            };

            if(data.opcaoPagamento == 'PIX' && data.opcaoParcelas > 1){
                Swal.fire(
                    'Atenão!',
                    'A opção PIX apenas permite pagamentos em 1x!',
                    'warning'
                )
            }else{
                $.ajax({
                    url: '/api/geraPagamento',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(response) {

                        var params = {
                            LINK_PAY        : response.json['paymentLink'],
                            STATUS          : 'PENDING_PAY',
                            paymentId       : response.json['paymentId']
                        };

                        $.ajax({
                            url: '/api/geraLink/' + data.id,
                            type: 'POST',
                            data: params,
                            dataType: 'json',
                            success: function(response) {
                                Swal.fire({
                                    title: 'Sucesso!',
                                    text: `${response.message}`,
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#008000',
                                    confirmButtonText: 'OK'
                                  }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                  })
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Problemas!',
                                    'Não foi possível gerar essa cobrança, contate o suporte!',
                                    'error'
                                )
                            }
                        });

                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Problemas!',
                            'Não foi possível gerar essa cobrança, contate o suporte!',
                            'error'
                        )
                    }
                });
            }
        }else{
            Swal.fire(
                'Cancelado!',
                'Operação cancelada pelo usuário!',
                'error'
            )
        }
    });
}

function consultarEndereco() {
    const cep = document.getElementById('cep').value;
    fetch(`https://viacep.com.br/ws/${cep}/json/`)
      .then(response => response.json())
      .then(data => {
        if (data.erro) {
          console.log('CEP não encontrado');
        } else {
          const cidade = data.localidade + '/' + data.uf;
          const endereco = `${data.bairro}, ${data.logradouro} - `;

          // Preencher campos de cidade e endereço
          document.getElementById('cidade').value = cidade;
          document.getElementById('endereco').value = endereco;
        }
      })
      .catch(error => console.log(error));
}

function copiaLink(botao){
    var link = botao.getAttribute('data-link');
    var tempInput = document.createElement('input');
    tempInput.value = link;
    document.body.appendChild(tempInput);
    tempInput.select();
    tempInput.setSelectionRange(0, 99999);
    document.execCommand('copy');
    document.body.removeChild(tempInput);

    Swal.fire(
        'Sucesso!',
        'Link de pagamento copiado!',
        'success'
    )
}

function geraExcel(botao){

    var data = {
        id_lista : botao.dataset.id,
        id_user  : botao.dataset.user,
    };

    $.ajax({
        url: '/api/listaExcel',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function(response) {
            console.log(response);
            const workbook = XLSX.utils.book_new();
            const worksheet = XLSX.utils.json_to_sheet(response);
            XLSX.utils.book_append_sheet(workbook, worksheet, 'Planilha');
            const excelBuffer = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });
            saveAsExcelFile(excelBuffer, 'arquivo.xlsx');
        },
        error: function(xhr) {
            Swal.fire(
                'Problemas!',
                'Não foi possível gerar operação, contate o suporte!',
                'error'
            )
        }
    });

}

function saveAsExcelFile(buffer, fileName) {
    const data = new Blob([buffer], { type: 'application/octet-stream' });
    const url = window.URL.createObjectURL(data);
    const link = document.createElement('a');
    link.href = url;
    link.download = fileName;
    link.click();
  }


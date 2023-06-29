function formatarData(data) {
    var dataObj = new Date(data);

    var dia = dataObj.getUTCDate().toString().padStart(2, '0');
    var mes = (dataObj.getUTCMonth() + 1).toString().padStart(2, '0');
    var ano = dataObj.getUTCFullYear().toString();

    return dia + '/' + mes + '/' + ano;
}

function pesquisaCPFCNPJ() {
    let cpfcnpj = $('input[name=cpfcnpj]').val();
    let dataNascimento = $('input[name=dataNascimento]').val();
    console.log(dataNascimento);
    if (cpfcnpj.length > 13) {
        $.ajax({
            url: "http://ws.hubdodesenvolvedor.com.br/v2/cnpj/?cnpj=" + cpfcnpj + "&token=124678250wDRJmrCEXu225102800",
            method: 'GET',
            complete: function (xhr) {

                response = xhr.responseJSON;

                if (response.return == 'OK') {
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
    } else {
        $.ajax({
            url: "https://ws.hubdodesenvolvedor.com.br/v2/cpf/?cpf=" + cpfcnpj + "&data=" + formatarData(dataNascimento) + "&token=124678250wDRJmrCEXu225102800",
            method: 'GET',
            complete: function (xhr) {

                response = xhr.responseJSON;

                if (response.return == 'OK') {
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

function geraPagamento(botao) {
    var id = botao.dataset.id;
    var name = botao.dataset.name;
    var cpfcnpj = botao.dataset.cpfcnpj;

    var dataAtual = new Date();
    dataAtual.setDate(dataAtual.getDate() + 3);
    var dataFormatada = dataAtual.toISOString().split('T')[0];

    var data = {
        id: id,
        name: name,
        cpfcnpj: cpfcnpj,
        dataFormatada: dataFormatada
    };

    $.ajax({
        url: '/api/geraPagamento',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function (response) {

            var data = {
                LINK_PAY: response.json['paymentLink'],
                STATUS: 'PENDING_PAY',
                paymentId: response.json['paymentId']
            };

            $.ajax({
                url: '/api/geraLink/' + id,
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function (response) {
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
                error: function (xhr) {
                    Swal.fire(
                        'Problemas!',
                        'Não foi possível gerar essa cobrança, contate o suporte!',
                        'error'
                    )
                }
            });

        },
        error: function (xhr) {
            Swal.fire(
                'Problemas!',
                'Não foi possível gerar essa cobrança, contate o suporte!',
                'error'
            )
        }
    });
}

function copiaLink(botao) {
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

function pesquisaOneClube() {
    let cpf = $('input[name=cpf_busca]').val();
    if (cpf != '' || cpf != null || cpf != undefined) {
        const url = 'https://oneclube.com.br/api/buscar.php?token=Lk45v87CxO97bHg7h&modo=leitura&cpf=' + cpf;

        const xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                const responseHTML = xhr.responseText;
                const lines = responseHTML.split('<br>');
                const data = {};

                lines.forEach(line => {
                    const regex = /\[(.*?)\]=>\[(.*?)\]/g;
                    let match;
                    while ((match = regex.exec(line)) !== null) {
                        if (match.length === 3) {
                            const key = match[1].trim();
                            const value = match[2].trim();
                            data[key] = value;
                        }
                    }
                });

                if (data.Status == "Ativo") {
                    $('#registrer').removeClass('d-none');
                    $('#busca').addClass('d-none');
                    $('input[name=name]').val(data.Nome);
                    $('input[name=cpf]').val(cpf);
                } else {
                    Swal.fire(
                        'Problemas!',
                        'Seu usuário não está ativo na One Clube!',
                        'warning'
                    )
                }
            } else {
                Swal.fire(
                    'Problemas!',
                    'Não foi possivel realizar essa operação!',
                    'warning'
                )
            }
        };

        xhr.send();
    } else {
        Swal.fire(
            'Atenção!',
            'Preencha corretamente o formulário!',
            'warning'
        )
    }

}

function consultaGratis() {
    var data = {
        cpfcnpj: $('input[name=cpfcnpj]').val(),
        cliente: $('input[name=cliente]').val(),
        situacao: $('input[name=situacao]').val(),
        dataNascimento: $('#dataNascimento').val(),
        email: $('input[name=email]').val(),
        telefone: $('input[name=telefone]').val(),
        id_user: $('input[name=id_user]').val(),
    }

    $.ajax({
        url: '/api/consultaGratis',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function (response) {
            Swal.fire({
                title: 'Sucesso!',
                text: `${response.message}`,
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#008000',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/dashboard";
                }
            })
        },
        error: function (xhr) {
            Swal.fire(
                'Problemas!',
                'Não foi possível gerar essa operação, contate o suporte!',
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
                const endereco = `${data.logradouro}, ${data.bairro}`;
                const bairro = `${data.bairro}`;
                const estado = `${data.uf}`;

                // Preencher campos de cidade e endereço
                document.getElementById('cidade').value = cidade;
                document.getElementById('endereco').value = endereco;
                document.getElementById('bairro').value = bairro;
                document.getElementById('estado').value = estado;
            }
        })
        .catch(error => console.log(error));
}

function geraPagamentoConsulta(botao) {
    var id = botao.dataset.id;
    var name = botao.dataset.name;
    var cpfcnpj = botao.dataset.cpfcnpj;

    var dataAtual = new Date();
    dataAtual.setDate(dataAtual.getDate() + 3);
    var dataFormatada = dataAtual.toISOString().split('T')[0];

    var data = {
        id: id,
        name: name,
        cpfcnpj: cpfcnpj,
        dataFormatada: dataFormatada
    };

    $.ajax({
        url: '/api/geraPagamentoConsulta',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function (response) {

            var data = {
                link_pay_consulta: response.json['paymentLink'],
                status_consulta: 'PENDING_PAY',
                id_pay_consulta: response.json['paymentId']
            };

            $.ajax({
                url: '/api/crm-sales/' + id,
                type: 'PUT',
                data: data,
                dataType: 'json',
                success: function (response) {
                    Swal.fire({
                        title: 'Sucesso!',
                        text: `Cobrança gerada com sucesso!`,
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
                error: function (xhr) {
                    Swal.fire(
                        'Problemas!',
                        'Não foi possível gerar essa cobrança, contate o suporte!',
                        'error'
                    )
                }
            });

        },
        error: function (xhr) {
            Swal.fire(
                'Problemas!',
                'Não foi possível gerar essa cobrança, contate o suporte!',
                'error'
            )
        }
    });
}

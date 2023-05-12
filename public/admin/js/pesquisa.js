function pesquisaCPFCNPJ(){
    let cpfcnpj = $('input[name=cpfcnpj]').val();

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
            url: "https://ws.hubdodesenvolvedor.com.br/v2/cpf/?cpf="+cpfcnpj+"&data=&token=124678250wDRJmrCEXu225102800",
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

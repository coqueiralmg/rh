$(function () {
    $('#nome_funcionario').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: '/rh/funcionarios/listar.json',
                dataType: 'json',
                data: {
                    nome: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            $('#nome_funcionario').val(ui.item.nome.trim());
            $('#id_funcionario').val(ui.item.id);

            return false;
        }
    }).autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
            .append('<span>' + item.nome.trim() + '</span>')
            .appendTo(ul);
    };

    $('#nome_funcionario').blur(function(e){
        if(this.value == ""){
            $('#id_funcionario').val("");
        }
    });
});

function exibirAlerta(cid, quantidade) {
    var mensagem = "Existem atestados informados com CIDs inválidos ou inexistentes";
    
    var detalhes = "CID: " + cid + " \n";
    detalhes = detalhes + "Quantidade: " + quantidade + " \n";

    swal({
        html: mensagem,
        type: 'warning',
        input: "textarea",
        inputValue: detalhes,
        inputAttributes: {
            rows: 3
        }
    });
}

function exibirInformacaoCID(o, cid)
{
    var carregando = $("#relatorio tbody#pivot tr#caregando");
    var detalhe = $("#relatorio tbody#pivot tr#detalhe");
    var linha = $("#relatorio tbody#content tr#" + cid);

    linha.after(carregando);

    $.ajax({
        url: '/rh/cid/listar',
        dataType: 'json',
        data: {
            codigo: cid,
            nome: ""
        },
        beforeSend: function() {
            $(".category").empty();
            $(".category").html("Efetuando busca. Aguarde!");
        },
        success: function (data) {
            detalhe.find("#titulo")
        }
    });
}
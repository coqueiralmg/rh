$(function () {
    $('#data_emissao').datepicker({
        language: 'pt-BR'
    });

    $('#data_afastamento').datepicker({
        language: 'pt-BR'
    });

    $('#data_retorno').datepicker({
        language: 'pt-BR'
    });

    $('#data_emissao').mask('00/00/0000');
    $('#data_afastamento').mask('00/00/0000');
    $('#data_retorno').mask('00/00/0000');
    $('#crm').mask('00000000000');

    $('#nome_funcionario').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: '/rh/funcionarios/listar',
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
            $('#nome_funcionario').val(ui.item.nome);
            $('#id_funcionario').val(ui.item.id);

            return false;
        }
    }).autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
            .append(item.nome)
            .appendTo(ul);
    };
});

function salvarMedico(){
    if(!validarPopup()) return false;

    
}

function validarPopup() {
    var mensagem = "";

    if ($("#nome").val() === "") {
        mensagem += "<li> É obrigatório informar o nome do médico.</li>";
        $("label[for='nome']").css("color", "red");
    } else {
        $("label[for='nome']").css("color", "#aaa");
    }

    if (mensagem == "") {
        return true;
    } else {
        $("#cadastro_erro_popup").show('shake');
        $("#cadastro_erro_popup #details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}
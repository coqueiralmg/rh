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

    $('#cid').blur(function (e) {
        this.value = this.value.toUpperCase();
    });

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
            .append('<span>' + item.nome + '</span>')
            .appendTo(ul);
    };

    $('#nome_medico').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: '/rh/medicos/listar',
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
            $('#nome_medico').val(ui.item.nome);
            $('#id_medico').val(ui.item.id);

            return false;
        }
    }).autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
            .append('<span><b>' + item.nome + '</b><span><br/><small>' + item.especialidade + ' CRM:' + item.crm + '</small>')
            .appendTo(ul);
    };;
});

function salvarMedico() {
    if (!validarPopup()) return false;

    var nome = $("#nome").val();
    var crm = $("#crm").val();
    var especialidade = $("#especialidade").val();

    $.ajax({
        url: '/rh/medicos/append',
        dataType: 'json',
        data: {
            nome: nome,
            crm: crm,
            especialidade: especialidade
        },
        success: function (data) {
            $("#cadastro_sucesso_popup").show('fade');
            $("#btnSalvaMedico").hide();
        }
    });
}

function fecharModalMedico() {
    $("#btnSalvaMedico").show();
    $("#nome").val('');
    $("#crm").val('');
    $("#especialidade").val('');
    $("#cadastro_sucesso_popup").hide();
    $("#cadastro_erro_popup").hide();
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

function validar() {
    var mensagem = "";

    if ($("#id_funcionario").val() === "") {
        mensagem += "<li> É obrigatório informar o nome do funcionário cadastrado no sistema.</li>";
        $("label[for='funcionario']").css("color", "red");
    } else {
        $("label[for='funcionario']").css("color", "#aaa");
    }

    if ($("#data_emissao").val() === "") {
        mensagem += "<li> É obrigatório informar a data de emissão do atestado.</li>";
        $("label[for='emissao']").css("color", "red");
    } else {
        $("label[for='emissao']").css("color", "#aaa");
    }

    if ($("#data_afastamento").val() === "") {
        mensagem += "<li> É obrigatório informar a data de afastamento do funcionário.</li>";
        $("label[for='afastamento']").css("color", "red");
    } else {
        $("label[for='afastamento']").css("color", "#aaa");
    }

    if ($("#data_retorno").val() === "") {
        mensagem += "<li> É obrigatório informar a data de retorno do funcionário.</li>";
        $("label[for='retorno']").css("color", "red");
    } else {
        $("label[for='retorno']").css("color", "#aaa");
    }

    if ($("#data_afastamento").val() !== "" && $("#data_retorno").val() !== "") {
        var afastamento = new Date($("#data_afastamento").val());
        var retorno = new Date($("#data_retorno").val());

        if (afastamento > retorno) {
            mensagem += "<li> A data de afastamento é maior do que a data de retorno.</li>";
            $("label[for='afastamento']").css("color", "red");
            $("label[for='retorno']").css("color", "red");
        } else {
            $("label[for='afastamento']").css("color", "#aaa");
            $("label[for='retorno']").css("color", "#aaa");
        }
    }

    if ($("#quantidade_dias").val() === "") {
        mensagem += "<li> É obrigatório informar a quantidade de dias de afastamento, determinado pelo atestado.</li>";
        $("label[for='quantidade-dias']").css("color", "red");
    } else {
        $("label[for='quantidade-dias']").css("color", "#aaa");
    }

    if ($("#id_medico").val() === "") {
        mensagem += "<li> É obrigatório informar o nome do médico cadastrado no sistema. Você pode adicionar o novo médico, clicando em 'Adicionar médico'</li>";
        $("label[for='medico']").css("color", "red");
    } else {
        $("label[for='medico']").css("color", "#aaa");
    }

    if ($("#cid").val() === "") {
        mensagem += "<li> É obrigatório informar o CID do atestado.</li>";
        $("label[for='cid']").css("color", "red");
    } else {
        $("label[for='cid']").css("color", "#aaa");
    }

    if ($("#motivo").val() === "") {
        mensagem += "<li> É obrigatório informar o motivo do afastamento.</li>";
        $("label[for='motivo']").css("color", "red");
    } else {
        $("label[for='motivo']").css("color", "#aaa");
    }

    if (mensagem == "") {
        return true;
    } else {
        $("#cadastro_erro").show('shake');
        $("#cadastro_erro #details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}
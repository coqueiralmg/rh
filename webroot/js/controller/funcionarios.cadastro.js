$(function () {
    $('#data_admissao').datepicker({
        language: 'pt-BR'
    });

    $('#matricula').mask('000000');
    $('#data_admissao').mask('00/00/0000');
    $('#cpf').mask('000.000.000-00');
    $('#pis').mask('00000000000');
});

function validar() {
    
    var mensagem = "";

    if ($("#matricula").val() === "") {
        mensagem += "<li> É obrigatório informar a matrícula do funcionário.</li>";
        $("label[for='matricula']").css("color", "red");
    } else {
        $("label[for='matricula']").css("color", "#aaa");
    }

    if ($("#nome").val() === "") {
        mensagem += "<li> É obrigatório informar o nome do funcionário.</li>";
        $("label[for='nome']").css("color", "red");
    } else {
        $("label[for='nome']").css("color", "#aaa");
    }

    if ($("#cpf").val() === "") {
        mensagem += "<li> É obrigatório informar o CPF do funcionário.</li>";
        $("label[for='cpf']").css("color", "red");
    } else {
        $("label[for='cpf']").css("color", "#aaa");
    }

    if ($("#tipo").val() === "") {
        mensagem += "<li> É obrigatório informar o tipo do funcionário.</li>";
        $("label[for='tipo']").css("color", "red");
    } else {
        $("label[for='tipo']").css("color", "#aaa");
    }

    if (mensagem == "") {
        return true;
    } else {
        $("#cadastro_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}
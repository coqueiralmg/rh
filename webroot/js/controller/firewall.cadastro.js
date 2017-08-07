$(function () {

});

function validar() {
    var mensagem = "";

    if ($("#ip").val() === "") {
        mensagem += "<li> O endereço de IP é obrigatório.</li>";
        $("label[for='ip']").css("color", "red");
    } else {
        $("label[for='ip']").css("color", "#aaa");
    }

    if ($("#motivo").val() === "") {
        mensagem += "<li> O motivo do cadastro é obrigatório.</li>";
        $("label[for='motivo']").css("color", "red");
    } else {
        $("label[for='motivo']").css("color", "#aaa");
    }

    if (mensagem == "") {
        return true;
    } else {
        $("#cadastro_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}
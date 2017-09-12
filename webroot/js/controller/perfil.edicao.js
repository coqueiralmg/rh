function validar() {
    var mensagem = "";

    if ($("#nome").val() === "") {
        mensagem += "<li> É obrigatório informar seu nome.</li>";
        $("label[for='nome']").css("color", "red");
    } else {
        $("label[for='nome']").css("color", "#aaa");
    }

    if ($("#email").val() === "") {
        mensagem += "<li> É obrigatório informar seu e-mail.</li>";
        $("label[for='email']").css("color", "red");
    } else {
        $("label[for='email']").css("color", "#aaa");
    }

    if ($("#usuario").val() === "") {
        mensagem += "<li> É obrigatório informar o seu login do usuário.</li>";
        $("label[for='usuario']").css("color", "red");
    } else {
        $("label[for='usuario']").css("color", "#aaa");
    }

    if ($("#grupo").val() === "") {
        mensagem += "<li> É obrigatório informar o seu grupo de usuário.</li>";
        $("label[for='grupo']").css("color", "red");
    } else {
        $("label[for='grupo']").css("color", "red");
    }

    if (mensagem == "") {
        return true;
    } else {
        $("#cadastro_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}
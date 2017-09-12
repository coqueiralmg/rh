function validar() {
    var mensagem = "";

    if ($("#antiga").val() === "") {
        mensagem += "<li> É obrigatório informar a senha atual usado no sistema.</li>";
        $("label[for='antiga']").css("color", "red");
    } else {
        $("label[for='antiga']").css("color", "#aaa");
    }

    if ($("#nova").val() === "") {
        mensagem += "<li> É obrigatório informar a  nova senha a ser usada no sistema.</li>";
        $("label[for='nova']").css("color", "red");
    } else {
        $("label[for='nova']").css("color", "#aaa");
    }

    if ($("#confirma").val() === "") {
        mensagem += "<li> É obrigatório confirmar a  nova senha a ser usada no sistema.</li>";
        $("label[for='confirma']").css("color", "red");
    } else {
        $("label[for='confirma']").css("color", "#aaa");
    }
    
    if (sha1($("#antiga").val()) != $("#senha").val()) {
        mensagem += "<li> A senha atual informada é inválida.</li>";
        $("label[for='antiga']").css("color", "red");
    } else {
        $("label[for='antiga']").css("color", "#aaa");
    }

    if (sha1($("#nova").val()) == $("#senha").val()) {
        mensagem += "<li> A  nova senha deve ser diferente da senha atual.</li>";
        $("label[for='antiga']").css("color", "red");
        $("label[for='nova']").css("color", "red");
    } else {
        $("label[for='antiga']").css("color", "#aaa");
        $("label[for='nova']").css("color", "#aaa");
    }

    if (sha1($("#nova").val()) == $("#confirma").val()) {
        mensagem += "<li> A nova senha e a confirmação não se coincidem.</li>";
        $("label[for='antiga']").css("color", "red");
        $("label[for='confirma']").css("color", "red");
    } else {
        $("label[for='antiga']").css("color", "#aaa");
        $("label[for='confirma']").css("color", "#aaa");
    }

    
    if (mensagem == "") {
        return true;
    } else {
        $("#cadastro_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}
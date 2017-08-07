function validar() {
    if ($("#usuario").val() == "") {
        $("#erro").html("É obrigatório informar nome do usuário ou e-mail.");
        return false;
    }

    if ($("#senha").val() == "") {
        $("#erro").html("É obrigatório informar a senha de acesso ao sistema.");
        return false;
    }

    return true;
}
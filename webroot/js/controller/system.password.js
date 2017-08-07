function validar() {
    if ($("#senha").val() == "") {
        $("#erro").html("É obrigatório informar a nova senha.");
        return false;
    }

    if ($("#confirma").val() == "") {
        $("#erro").html("É necessário confirmar a nova senha.");
        return false;
    }

    if ($("#senha").val() != $("#confirma").val()) {
        $("#erro").html("A senha e a confirmação estão diferentes.");
        return false;
    }

    return true;
}
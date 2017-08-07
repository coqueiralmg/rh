function marcarTodos() {
    $("#funcoes input").each(function () {
        $(this).prop("checked", true);
    });
}

function desmarcarTodos() {
    $("#funcoes input").each(function () {
        $(this).prop("checked", false);
    });
}

function validar() {
    var mensagem = "";

    if ($("#nome").val() === "") {
        mensagem += "<li> O nome do grupo usuário é obrigatório.</li>";
        $("label[for='nome']").css("color", "red");
    } else {
        $("label[for='nome']").css("color", "#aaa");
    }

    if (mensagem == "") {
        return true;
    } else {
        $("#cadastro_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}
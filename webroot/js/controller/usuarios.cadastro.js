$(function () {
    $('#data_nascimento').datepicker({
        language: 'pt-BR'
    });

    $('#data_nascimento').mask('00/00/0000');

    $("#senha").val("");
    $("#confirma_senha").val("");

    $("input[type='password']").change(function () {
        $("#mudasenha").val("true");
    });
});

function validar() {
    var mensagem = "";

    if ($("#nome").val() === "") {
        mensagem += "<li> O nome do usuário é obrigatório.</li>";
        $("label[for='nome']").css("color", "red");
    } else {
        $("label[for='nome']").css("color", "#aaa");
    }

    if ($("#email").val() === "") {
        mensagem += "<li> O e-mail do usuário é obrigatório.</li>";
        $("label[for='email']").css("color", "red");
    } else {
        $("label[for='email']").css("color", "#aaa");
    }

    if ($("#usuario").val() === "") {
        mensagem += "<li> É obrigatório informar o login do usuário.</li>";
        $("label[for='usuario']").css("color", "red");
    } else {
        $("label[for='usuario']").css("color", "#aaa");
    }

    if ($("#mudasenha").val() == "true") {
        if ($("#senha").val() === "") {
            mensagem += "<li> É obrigatório informar a senha do usuário.</li>";
            $("label[for='senha']").css("color", "red");
        } else {
            $("label[for='senha']").css("color", "#aaa");
        }

        if ($("#confirma_senha").val() === "") {
            mensagem += "<li> É obrigatório informar a confirmação da senha.</li>";
            $("label[for='confirma-senha']").css("color", "red");
        } else {
            $("label[for='confirma-senha']").css("color", "#aaa");
        }
    }

    if ($("#grupo").val() === "") {
        mensagem += "<li> É obrigatório informar o grupo de usuário.</li>";
        $("label[for='grupo']").css("color", "red");
    } else {
        $("label[for='grupo']").css("color", "red");
    }

    if ($("#mudasenha").val() == "true") {
        if ($("#senha").val() != "" && $("#confirma_senha").val() != "") {
            if ($("#senha").val() !== $("#confirma_senha").val()) {
                mensagem += "<li>A senha e a confirmação estão diferentes.</li>";
                $("label[for='senha']").css("color", "red");
                $("label[for='confirma-senha']").css("color", "red");
            } else {
                $("label[for='senha']").css("color", "#aaa");
                $("label[for='confirma-senha']").css("color", "#aaa");
            }
        }
    }

    if (mensagem == "") {
        return true;
    } else {
        $("#cadastro_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}
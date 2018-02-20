$(function () {
    $('#codigo').blur(function (e) {
        this.value = this.value.toUpperCase();
    });

    $('#detalhamento').blur(function (e) {
        if(this.value === "") {
            $('#subitem').prop("checked", false);
        } else {
            $('#subitem').prop("checked", true);
        }
    });

    $('#subitem').change(function (e) {
        if(this.checked){
            $('#detalhamento').val(0);
        } else {
            $('#detalhamento').val('');
        }
    });
});

function validar() {
    var mensagem = "";

    if ($("#codigo").val() === "") {
        mensagem += "<li>É obrigatório informar o código do CID.</li>";
        $("label[for='codigo']").css("color", "red");
    } else {
        $("label[for='codigo']").css("color", "#aaa");
    }

    if ($("#nome").val() === "") {
        mensagem += "<li>É obrigatório informar o nome da doença ou problema relacionado ao CID.</li>";
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
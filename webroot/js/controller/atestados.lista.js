$(function () {
    $('#emissao_inicial').datepicker({
        language: 'pt-BR'
    });

    $('#emissao_final').datepicker({
        language: 'pt-BR'
    });

    $('#afastamento_inicial').datepicker({
        language: 'pt-BR'
    });

    $('#afastamento_final').datepicker({
        language: 'pt-BR'
    });

    $('#emissao_inicial').mask('00/00/0000');
    $('#emissao_final').mask('00/00/0000');
    $('#afastamento_inicial').mask('00/00/0000');
    $('#afastamento_final').mask('00/00/0000');

    $('#cid').blur(function (e) {
        this.value = this.value.toUpperCase();
    });
});

function validar() {
    var mensagem = "";
    var emissaoInicial = $('#emissao_inicial').val();
    var emissaoFinal = $('#emissao_final').val();
    var afastamentoInicial = $('#afastamento_inicial').val();
    var afastamentoFinal = $('#afastamento_final').val();

    if (emissaoInicial != "" || emissaoFinal != "") {
        if (emissaoInicial == "") {
            mensagem += "<li>Favor, informe a data de emissão inicial para efetuar a busca por data de emissão.</li>";
            $("label[for='data-inicial']").css("color", "red");
        } else {
            $("label[for='data-inicial']").css("color", "#aaa");
        }

        if (emissaoFinal == "") {
            mensagem += "<li>Favor, informe a data de emissão final para efetuar a busca por data de emissão.</li>";
            $("label[for='data-final']").css("color", "red");
        } else {
            $("label[for='data-final']").css("color", "#aaa");
        }

        if (emissaoInicial != "" && emissaoFinal != "") {
            var inicial = new Date(emissaoInicial);
            var final = new Date(emissaoFinal);

            if (inicial > final) {
                mensagem += "<li>A data de emissão inicial é maior do que a data de emissão final.</li>";
                $("label[for='data-inicial']").css("color", "red");
                $("label[for='data-final']").css("color", "red");
            } else {
                $("label[for='data-inicial']").css("color", "#aaa");
                $("label[for='data-final']").css("color", "#aaa");
            }
        }
    }

    if (afastamentoInicial != "" || afastamentoFinal != "") {
        if (afastamentoInicial == "") {
            mensagem += "<li>Favor, informe a data de afastamento inicial para efetuar a busca por data de afastamento.</li>";
            $("label[for='data-inicial']").css("color", "red");
        } else {
            $("label[for='data-inicial']").css("color", "#aaa");
        }

        if (afastamentoFinal == "") {
            mensagem += "<li>Favor, informe a data de afastamento final para efetuar a busca por data de afastamento.</li>";
            $("label[for='data-final']").css("color", "red");
        } else {
            $("label[for='data-final']").css("color", "#aaa");
        }

        if (afastamentoInicial != "" && afastamentoFinal != "") {
            var inicial = new Date(afastamentoInicial);
            var final = new Date(afastamentoFinal);

            if (inicial > final) {
                mensagem += "<li>A data de afastamento inicial é maior do que a data de afastamento final.</li>";
                $("label[for='data-inicial']").css("color", "red");
                $("label[for='data-final']").css("color", "red");
            } else {
                $("label[for='data-inicial']").css("color", "#aaa");
                $("label[for='data-final']").css("color", "#aaa");
            }
        }
    }

    if (mensagem == "") {
        return true;
    } else {
        $("#lista_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}
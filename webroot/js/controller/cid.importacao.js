var reset = '';
var ordem = Array();

$(function () {
    $("#junto").change(function(e) {
        if(this.checked) {
            juntarOrdemDetalhamento();
        } else {
            separarOrdemDetalhamento();

            if($("#separado").prop("checked")){
                $('#separado').prop("checked", false);
            }
        }
    });

    $("#separado").change(function(e) {
        if(this.checked) {
            if(!$("#junto").prop("checked")){
                $('#junto').prop("checked", true);
                juntarOrdemDetalhamento();
            }
        }
    });
    
    $("#sortable").sortable({
        placeholder: "sort-placeholder",
        stop: function(event, ui) {
            salvarOrdemCampos();
        }
    });
    
    $("#sortable").disableSelection();

    iniciarOrdemCampos();

    reset = $("#sortable").html();
});

function zerarPosicoes() {
    $("#sortable").html('');
    $("#sortable").html(reset);

    salvarOrdemCampos();
}

function iniciarOrdemCampos(){
    $("#sortable li:visible").each(function(i) {
        var campo = $(this).attr('name');
        ordem.push(campo);
    });

    $('#campos').val(JSON.stringify(ordem));
}

function salvarOrdemCampos() {
    ordem = [];
    
    $("#sortable li:visible").each(function(i) {
        var campo = $(this).attr('name');
        ordem.push(campo);
    });

    $('#campos').val('');
    $('#campos').val(JSON.stringify(ordem));
}

function juntarOrdemDetalhamento(){
    zerarPosicoes();
    
    $("#bdgCodigo").hide();
    $("#bdgDetalhamento").hide();
    $("#bdgCodDet").show();

    reset = $("#sortable").html();
    salvarOrdemCampos();
}

function separarOrdemDetalhamento(){
    zerarPosicoes();

    $("#bdgCodigo").show();
    $("#bdgDetalhamento").show();
    $("#bdgCodDet").hide();

    reset = $("#sortable").html();
    salvarOrdemCampos();
}
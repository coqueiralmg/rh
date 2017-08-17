$(function () {
    $('#data_emissao').datepicker({
        language: 'pt-BR'
    });

    $('#data_afastamento').datepicker({
        language: 'pt-BR'
    });

    $('#data_retorno').datepicker({
        language: 'pt-BR'
    });

    $('#data_emissao').mask('00/00/0000');
    $('#data_afastamento').mask('00/00/0000');
    $('#data_retorno').mask('00/00/0000');
});
$(function () {
    $('#data_inicial').datepicker({
        language: 'pt-BR'
    });

     $('#data_final').datepicker({
        language: 'pt-BR'
    });

    $('#data_inicial').mask('00/00/0000');
    $('#data_final').mask('00/00/0000');
});
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
    
}
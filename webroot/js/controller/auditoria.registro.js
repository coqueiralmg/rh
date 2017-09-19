function excluirRegistro(id) {
    swal({
        title: "Deseja excluir este registro?",
        html: "A exclusão deste registro irá tornar a operação irreversível.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then(function () {
        window.location = '/rh/auditoria/delete/' + id;
    });
}
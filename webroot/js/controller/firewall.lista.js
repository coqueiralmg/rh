function excluirRegistro(id, ip) {
    swal({
        title: "Deseja excluir este registro?",
        html: "A exclusão do registro para endereço de IP <b> " + ip + "</b> irá tornar a operação irreversível.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then(function () {
        window.location = '/rh/firewall/delete/' + id;
    });
}
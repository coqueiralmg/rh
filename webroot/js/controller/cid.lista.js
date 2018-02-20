function excluirCID(id, codigo, nome) {
    swal({
        title: "Deseja excluir este CID?",
        html: "A exclusão do CID <b> " + codigo + "</b>, relacionado a <b> " + nome + "</b> irá tornar a operação irreversível.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then(function () {
        window.location = '/rh/cid/delete/' + id;
    });

}
function excluirRegistro(id, nome) {
    swal({
        title: "Deseja excluir este médico?",
        html: "A exclusão do médico <b> " + nome + "</b> irá tornar a operação irreversível.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then(function () {
        window.location = '/rh/medicos/delete/' + id;
    });
}
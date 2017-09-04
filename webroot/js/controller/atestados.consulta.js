function excluirAtestado(id, dataEmissao, funcionário) {
    swal({
        title: "Deseja excluir este atestado?",
        html: "A exclusão emitida no dia " + dataEmissao + " para o funcionário " + funcionário + ", tornará a operação irreversível.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then(function (result) {
        window.location = '/rh/atestados/delete/' + id;
    });
}
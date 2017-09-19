function excluirFuncionario(id, nome) {
    swal({
        title: "Deseja excluir este funcionario?",
        html: "A exclusão do funcionário <b> " + nome + "</b> irá tornar a operação irreversível.",
        input: 'checkbox',
        inputValue: 0,
        inputPlaceholder: ' Excluir também seus atestados.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then(function (result) {
        window.location = '/rh/funcionarios/delete/' + id + '?atestados=' + result;
    });
}
function excluirUsuario(id, nome) {
    if (id == usuario) {
        swal('Erro na exclusão', 'Você não pode excluir a si mesmo no sistema!', 'error');
    } else {
        swal({
            title: "Deseja excluir este usuário?",
            html: "A exclusão do usuário <b> " + nome + "</b> irá tornar a operação irreversível.",
            input: 'checkbox',
            inputValue: 0,
            inputPlaceholder: ' Exclua também a trilha de auditoria.',
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não'
        }).then(function (result) {
            window.location = '/rh/usuarios/delete/' + id + '?auditoria=' + result;
        });
    }
}
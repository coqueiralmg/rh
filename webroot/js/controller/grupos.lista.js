function excluirGrupoUsuario(id, nome) {
    if (id == grupoUsuario) {
        swal('Erro na exclusão', 'Você não pode excluir grupo de usuários, na qual você faz parte!', 'error');
    } else {
        swal({
            title: "Deseja excluir este grupo de usuário?",
            html: "A exclusão do grupo de usuário <b> " + nome + "</b> irá tornar a operação irreversível.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não'
        }).then(function () {
            window.location = '/rh/grupos/delete/' + id;
        });
    }
}
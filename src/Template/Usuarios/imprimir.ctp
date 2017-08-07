<?php if ($qtd_total > 0) :?>
    <h4 class="card-title">Lista de Usuários</h4>
    <table class="table table-striped">
        <thead class="text-primary">
            <tr>
                <th style="width: 25%">Nome</th>
                <th>Usuário</th>
                <th>E-mail</th>
                <th>Ativo</th>
                <th>Grupo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario) : ?>
                <tr>
                    <td style="width: 30%"><?=$usuario->nome?></td>
                    <td style="width: 15%"><?=$usuario->usuario?></td>
                    <td style="width: 20%"><?=$usuario->email?></td>
                    <td><?=$usuario->ativado?></td>
                    <td><?=$usuario->grupoUsuario->nome?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="material-datatables">
        <div class="row">
            <div class="col-sm-5">
                <div class="dataTables_paginate paging_full_numbers text-left" id="datatables_info"><?= $qtd_total ?> usuários</div>
            </div>
        </div>
    </div>
<?php else : ?>
    <h3>Nenhum usuário encontrado.</h3>
<?php endif; ?>

    

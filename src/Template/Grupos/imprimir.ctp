<h4 class="card-title">Lista de Grupos de Usuários</h4>
<table class="table  table-striped">
    <thead class="text-primary">
        <tr>
            <th>Nome</th>
            <th>Ativo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($grupos as $grupo): ?>
            <tr>
                <td><?= $grupo->nome ?></td>
                <td><?= $grupo->ativado ?></td>
            </tr>   
        <?php endforeach; ?>
    </tbody>
</table>

</div>
<div class="material-datatables">
    <div class="row">
        <div class="col-sm-5">
            <div class="dataTables_paginate paging_full_numbers text-left" id="datatables_info"><?= $qtd_total ?> itens</div>
        </div>
    </div>
</div>
</div>

    
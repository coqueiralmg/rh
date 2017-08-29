<?php if($qtd_total > 0):?>
    <h4 class="card-title">Lista de Usuários</h4>
    <table class="table table-striped">
        <thead class="text-primary">
            <tr>
                <th>Endereço de IP</th>
                <th>Data do Cadastro</th>
                <th>Lista Branca</th>
                <th>Ativo</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($firewall as $item): ?>
                <tr>
                    <td><?= $item->ip ?></td>
                    <td><?= $this->Format->date($item->data) ?></td>
                    <td><?= $item->whitelist ?></td>
                    <td><?= $item->ativado ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="material-datatables">
        <div class="row">
            <div class="col-sm-5">
                <div class="dataTables_paginate paging_full_numbers text-left" id="datatables_info"><?= $qtd_total ?> itens</div>
            </div>
        </div>
    </div>
<?php else: ?>
    <h3>Nenhum item encontrado.</h3>
<?php endif; ?>

    
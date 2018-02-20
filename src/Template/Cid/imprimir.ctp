<?php if ($qtd_total > 0) :?>
    <h4 class="card-title">Tabela de CID</h4>
    <table class="table  table-striped">
        <thead class="text-primary">
            <tr>
                <th>Código</th>
                <th>Nome</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($itens as $item) : ?>
                <tr>
                    <td><?=$item->cid?></td>
                    <td><?=$item->nome?></td>
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
<?php else : ?>
    <h3>Nenhum item encontrado.</h3>
<?php endif; ?>
    
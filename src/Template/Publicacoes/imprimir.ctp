<?php if($qtd_total > 0):?>
    <h4 class="card-title">Lista de publicações</h4>
    <table class="table table-striped">
        <thead class="text-primary">
            <tr>
                <th>Número</th>
                <th>Título</th>
                <th>Data</th>
                <th>Ativo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($publicacoes as $publicacao): ?>
                <tr>
                    <td><?=$publicacao->numero?></td>
                    <td><?=$publicacao->titulo?></td>
                    <td><?= $this->Format->date($publicacao->data) ?></td>
                    <td><?= $publicacao->ativado ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="material-datatables">
        <div class="row">
            <div class="col-sm-5">
                <div class="dataTables_paginate paging_full_numbers text-left" id="datatables_info"><?= $qtd_total ?> publicações</div>
            </div>
        </div>
    </div>
<?php else: ?>
    <h3>Nenhuma publicação encontrada.</h3>
<?php endif; ?>

    
<?php if ($qtd_total > 0) :?>
    <h4 class="card-title">Lista de Funcionários</h4>
    <table class="table  table-striped">
        <thead class="text-primary">
            <tr>
                <th>Código</th>
                <th>Data</th>
                <th>Ocorrência</th>
                <th>Responsável</th>
                <th>IP</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($auditoria as $registro) : ?>
                <tr>
                    <td><?=$this->Format->zeroPad($registro->id, 5)?></td>
                    <td><?=$this->Format->date($registro->data, true)?></td>
                    <td><?=$this->Auditoria->buscarNomeOcorrencia($registro->ocorrencia)?></td>
                    <td><?=($registro->usuario == null) ? 'Sem usuário associado' : $registro->usuario->nome?></td>
                    <td><?=$registro->ip?></td>
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
    <h3>Nenhum funcionário encontrado.</h3>
<?php endif; ?>
    
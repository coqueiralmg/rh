<?php if ($qtd_total > 0) :?>
    <h4 class="card-title">Lista de Atestados Emitidos</h4>
    <table class="table  table-striped">
        <thead class="text-primary">
            <tr>
                <th>Funcionário</th>
                <th>Data de Emissão</th>
                <th>Data de Afastamento</th>
                <th>Data de Retorno</th>
                <th>CID</th>
                <th>INSS</th>
                <th>Motivo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($atestados as $atestado) : ?>
                <tr>
                    <td><?=$atestado->funcionario->nome?></td>
                    <td><?=$this->Format->date($atestado->emissao)?></td>
                    <td><?=$this->Format->date($atestado->afastamento)?></td>
                    <td><?=$this->Format->date($atestado->retorno)?></td>
                    <td><?=$atestado->cid?></td>
                    <td><?=$atestado->afastado?></td>
                    <td><?=$atestado->motivo?></td>
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
    <h3>Nenhum atestado encontrado.</h3>
<?php endif; ?>
    
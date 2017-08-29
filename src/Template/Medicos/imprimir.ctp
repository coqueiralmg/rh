<?php if ($qtd_total > 0) :?>
    <h4 class="card-title">Lista de Médicos</h4>
    <table class="table  table-striped">
        <thead class="text-primary">
            <tr>
                <th>Nome</th>
                <th>Especialidade</th>
                <th>CRM</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($medicos as $medico) : ?>
                <tr>
                    <td><?= $medico->nome ?></td>
                    <td><?= $medico->especialidade ?></td>
                    <td><?= $medico->crm ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    </div>
    <div class="material-datatables">
        <div class="row">
            <div class="col-sm-5">
                <div class="dataTables_paginate paging_full_numbers text-left" id="datatables_info"><?= $qtd_total ?> médicos</div>
            </div>
        </div>
    </div>
<?php else : ?>
    <h3>Nenhum médico encontrado.</h3>
<?php endif; ?>
    
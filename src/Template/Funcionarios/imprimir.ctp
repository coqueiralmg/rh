<?php if ($qtd_total > 0) :?>
    <h4 class="card-title">Lista de Funcionários</h4>
    <table class="table  table-striped">
        <thead class="text-primary">
            <tr>
                <th>Matrícula</th>
                <th>Nome</th>
                <th>Cargo</th>
                <th>Área</th>
                <th>CPF</th>
                <th>PIS</th>
                <th>Tipo</th>
                <th>Ativo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($funcionarios as $funcionario) : ?>
                <tr>
                    <td><?=$funcionario->matricula?></td>
                    <td><?=$funcionario->nome?></td>
                    <td><?=$funcionario->cargo?></td>
                    <td><?=$funcionario->area?></td>
                    <td><?=$this->Format->cpf($funcionario->cpf)?></td>
                    <td><?=$funcionario->pis?></td>
                    <td><?=$funcionario->tipo->descricao?></td>
                    <td><?=$funcionario->ativado?></td>
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
    
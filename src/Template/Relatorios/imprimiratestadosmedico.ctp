<h4 class="card-title"><?=$subtitle?></h4>
<table class="table  table-striped">
    <thead class="text-primary">
        <tr>
            <th>Funcionário</th>
            <th>CID</th>
            <th>Motivo</th>
            <th>Data de Emissão</th>
            <th>Data de Afastamento</th>
            <th>Data de Retorno</th>
            <th>INSS</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($atestados as $atestado) : ?>
            <tr>
                <td><?=$atestado->funcionario->nome?></td>
                <td><?=$atestado->cid?></td>
                <td><?=$atestado->motivo?></td>
                <td><?=$this->Format->date($atestado->emissao)?></td>
                <td><?=$this->Format->date($atestado->afastamento)?></td>
                <td><?=$this->Format->date($atestado->retorno)?></td>
                <td><?=$atestado->afastado?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<h4 class="card-title">Dados do Atestado</h4>
<table class="table">
    <tbody>
        <tr>
            <td><b>Funcionário</b></td>
            <td><?= $atestado->funcionario->nome ?></td>
        </tr>
        <tr>
            <td><b>Data de Emissão</b></td>
            <td><?= $this->Format->date($atestado->emissao) ?></td>
        </tr>
        <tr>
            <td><b>Data de Afastamento</b></td>
            <td><?= $this->Format->date($atestado->afastamento) ?></td>
        </tr>
        <tr>
            <td><b>Data de Retorno</b></td>
            <td><?= $this->Format->date($atestado->retorno) ?></td>
        </tr>
        <tr>
            <td><b>Quantidade de Dias</b></td>
            <td><?= $atestado->quantidade_dias ?></td>
        </tr>
        <tr>
            <td><b>Médico</b></td>
            <td><?= $atestado->medico->nome ?> (<?= $atestado->medico->especialidade ?> CRM: <?= $atestado->medico->crm ?>)</td>
        </tr>
        <tr>
            <td><b>CID</b></td>
            <td><?= $atestado->cid ?></td>
        </tr>
        <tr>
            <td><b>Afastado por INSS</b></td>
            <td><?=$atestado->afastado?></td>
        </tr>
    </tbody>
    <tfoot>
        <tr colspan="2">
            <td>
                <b>Observação</b><br/>
                <?=$atestado->observacao?>
            </td>
        </tr>
    </tfoot>
</table>

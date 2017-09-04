<h4 class="card-title">Dados do Funcionário</h4>
<table class="table">
    <tbody>
        <tr>
            <td><b>Matrícula</b></td>
            <td><?=$funcionario->matricula?></td>
        </tr>
        <tr>
            <td><b>Nome</b></td>
            <td><?=$funcionario->nome?></td>
        </tr>
        <tr>
            <td><b>Data de Admissão</b></td>
            <td><?= $this->Format->date($funcionario->data_admissao)?></td>
        </tr>
        <tr>
            <td><b>CPF</b></td>
            <td><?= $this->Format->cpf($funcionario->cpf)?></td>
        </tr>
        <tr>
            <td><b>PIS</b></td>
            <td><?=$funcionario->pis?></td>
        </tr>
        <tr>
            <td><b>Área</b></td>
            <td><?=$funcionario->area?></td>
        </tr>
        <tr>
            <td><b>Cargo</b></td>
            <td><?=$funcionario->cargo?></td>
        </tr>
        <tr>
            <td><b>E-mail</b></td>
            <td><?=$funcionario->email?></td>
        </tr>
        <tr>
            <td><b>Empresa</b></td>
            <td><?=$funcionario->empresa->nome?></td>
        </tr>
        <tr>
            <td><b>Tipo</b></td>
            <td><?=$funcionario->tipo->descricao?></td>
        </tr>
        <tr>
            <td><b>Em estágio probatório</b></td>
            <td><?=$funcionario->estagio?></td>
        </tr>
        <tr>
            <td><b>Ativo</b></td>
            <td><?=$funcionario->ativado?></td>
        </tr>
    </tbody>
    <tfoot>
        <tr colspan="2">
            <td>
                <b>Observação</b><br/>
                <?=$funcionario->observacao?>
            </td>
        </tr>
    </tfoot>
</table>

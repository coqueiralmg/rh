<h4 class="card-title">Relatório de Cadastro em Massa do CID</h4>
<table class="table  table-striped">
    <thead class="text-primary">
        <tr>
            <th>Item</th>
            <th>Código</th>
            <th>Detalhamento</th>
            <th>Nome</th>
            <th>Sucesso</th>
            <th>Mensagem</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($relatorio as $dado) : ?>
            <tr>
                <td><?=$dado['item'] + 1?></td>
                <td><?=$dado['codigo']?></td>
                <td><?=$dado['detalhamento']?></td>
                <td><?=$dado['nome']?></td>
                <td><?=$dado['sucesso'] ? 'Sim' : 'Não'?></td>
                <td><?=$dado['mensagem']?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
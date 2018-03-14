<h4 class="card-title">Relatório</h4>
<table class="table  table-striped">
    <thead class="text-primary">
        <tr>
            <th>Empresa</th>
            <th>Total de Funcionários</th>
            <th>Atestados Emitidos</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($item = $relatorio->fetch(PDO::FETCH_OBJ)) : ?>
            <tr>
                <td><?=$item->nome?></td>
                <td><?=$item->funcionarios?></td>
                <td><?=$item->atestados?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

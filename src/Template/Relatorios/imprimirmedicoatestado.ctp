<h4 class="card-title">Relatório</h4>
<table class="table  table-striped">
    <thead class="text-primary">
        <tr>
            <th>Nome do Médico</th>
            <th>CRM</th>
            <th>Especialidade</th>
            <th>Quantidade</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($item = $relatorio->fetch(PDO::FETCH_OBJ)) : ?>
            <tr>
                <td><?=$item->nome?></td>
                <td><?=$item->crm?></td>
                <td><?=$item->especialidade?></td>
                <td><?=$item->quantidade?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

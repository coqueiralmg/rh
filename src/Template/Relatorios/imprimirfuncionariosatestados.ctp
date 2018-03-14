<h4 class="card-title">Relatório</h4>
<table class="table  table-striped">
    <thead class="text-primary">
        <tr>
            <th>Matricula</th>
            <th>Nome</th>
            <th>Cargo</th>
            <th>Tipo</th>
            <th>Empresa</th>
            <th>Atestados</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($item = $relatorio->fetch(PDO::FETCH_OBJ)) : ?>
            <tr>
                <td><?=$item->matricula?></td>
                <td><?=$item->nome?></td>
                <td><?=$item->cargo?></td>
                <td><?=$item->tipo?></td>
                <td><?=$item->empresa?></td>
                <td><?=$item->quantidade?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

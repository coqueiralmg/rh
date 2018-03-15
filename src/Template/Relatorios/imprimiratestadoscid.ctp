<h4 class="card-title">Relatório</h4>
<table class="table  table-striped">
    <thead class="text-primary">
        <tr>
            <th>CID</th>
            <th>Nome</th>
            <th>Quantidade</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($item = $relatorio->fetch(PDO::FETCH_OBJ)) : ?>
            <tr>
                <td>
                    <?php if($item->nome == null): ?>
                        <i><?=$item->cid?></i>
                    <?php else: ?>
                        <?=$item->cid?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($item->nome == null): ?>
                        <i><?=$item->descricao?></i>
                    <?php else: ?>
                        <?=$item->descricao?>
                    <?php endif; ?>
                </td>
                <td><?=$item->atestados?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

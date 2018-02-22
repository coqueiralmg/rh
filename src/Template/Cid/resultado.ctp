<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <h4 class="card-title">Relatório de Cadastro em Massa do CID</h4>
                        <table class="table">
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
                    </div>
                    <div class="card-content">
                        <div class="material-datatables">
                            <div class="row">
                            <a href="<?= $this->Url->build(['controller' => 'Cid', 'action' => 'relatorio']) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                            <button type="button" onclick="window.location='<?= $this->Url->build('/cid') ?>'" class="btn btn-info pull-right">Voltar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="form-group form-button">
                                <a href="<?= $this->Url->build(['controller' => 'Relatorios', 'action' => 'imprimirfuncionariosempresa', '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                                <button type="button" onclick="window.history.back()" class="btn btn-info pull-right">Voltar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <h4 class="card-title"><?=$subtitle?></h4>
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th>Matricula</th>
                                    <th>Nome</th>
                                    <th>Cargo</th>
                                    <th>Tipo</th>
                                    <th>Atestados</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($item = $relatorio->fetch(PDO::FETCH_OBJ)) : ?>
                                    <tr>
                                        <td><?=$item->matricula?></td>
                                        <td><?=$item->nome?></td>
                                        <td><?=$item->cargo?></td>
                                        <td><?=$item->tipo?></td>
                                        <td><?=$item->quantidade?></td>
                                        <td class="td-actions text-right" style="width: 6%">
                                            <a href="<?= $this->Url->build(['controller' => 'Relatorios', 'action' => 'atestadosfuncionario', '?' => ['idFuncionario' => $item->id, 'periodo' => $data['mostrar']]]) ?>" title="Ver Atestados" class="btn btn-info btn-round">
                                                <i class="material-icons">content_paste</i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

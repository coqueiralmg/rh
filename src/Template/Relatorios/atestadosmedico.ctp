<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <a href="<?= $this->Url->build(['controller' => 'Relatorios', 'action' => 'imprimiratestadosmedico', $medico->id, '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                        <button type="button" onclick="window.history.back()" class="btn btn-info pull-right">Voltar</button>
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
                                    <th>Funcionário</th>
                                    <th>CID</th>
                                    <th>Data de Emissão</th>
                                    <th>Data de Afastamento</th>
                                    <th>Data de Retorno</th>
                                    <th>INSS</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($atestados as $atestado) : ?>
                                    <tr>
                                        <td><?=$atestado->funcionario->nome?></td>
                                        <td><a class="text-primary" rel="tooltip" title="<?= 'MOTIVO: ' . $atestado->motivo?>"><?=$atestado->cid?></a></td>
                                        <td><?=$this->Format->date($atestado->emissao)?></td>
                                        <td><?=$this->Format->date($atestado->afastamento)?></td>
                                        <td><?=$this->Format->date($atestado->retorno)?></td>
                                        <td><?=$atestado->afastado?></td>
                                        <td class="td-actions text-right" style="width: 6%">
                                            <a href="<?= $this->Url->build(['controller' => 'Relatorios', 'action' => 'atestadodetalhe', $atestado->id]) ?>" title="Ver Atestado" class="btn btn-info btn-round">
                                                <i class="material-icons">receipt</i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

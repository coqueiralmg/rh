<?= $this->Html->script('controller/auditoria.general.js', ['block' => 'scriptBottom']) ?>
<?= $this->Html->script('controller/auditoria.lista.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <h4 class="card-title">Buscar</h4>
                        <?= $this->Flash->render() ?>
                        <?=$this->element('message', [
                            'name' => 'lista_erro',
                            'type' => 'error',
                            'message' => 'Ocorreu um erro ao filtrar a auditoria.',
                            'details' => ''
                        ]) ?>
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("responsavel", "Responsável") ?> <br/>
                                        <?=$this->Form->select('responsavel', $usuarios, ['class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("ocorrencia", "Ocorrência") ?> <br/>
                                        <?=$this->Form->select('ocorrencia', $ocorrencias, ['empty' => 'Todos', 'class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("data_inicial", "Data Inicial") ?> <br/>
                                        <?= $this->Form->text("data_inicial", ["id" => "data_inicial", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("data_final", "Data Final") ?> <br/>
                                        <?= $this->Form->text("data_final", ["id" => "data_final", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("ip", "IP") ?> <br/>
                                        <?= $this->Form->text("ip", ["id" => "ip", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-button">
                                <button type="submit" onclick="return validar()" class="btn btn-fill btn-success pull-right">Buscar<div class="ripple-container"></div></button>
                                <?php if ($this->Membership->handleRole("imprimir_ips_firewall")) : ?>
                                    <a href="<?= $this->Url->build(['controller' => 'Auditoria', 'action' => 'imprimir', '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                                <?php endif; ?>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                   
                    <div class="card-content table-responsive">
                        <?php if (count($auditoria) > 0) :?>
                            <h4 class="card-title">Trilha de Auditoria</h4>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Código</th>
                                        <th>Data</th>
                                        <th>Ocorrência</th>
                                        <th>Responsável</th>
                                        <th>IP</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($auditoria as $registro) : ?>
                                        <tr>
                                            <td><?=$this->Format->zeroPad($registro->id, 5)?></td>
                                            <td><?=$this->Format->date($registro->data, true)?></td>
                                            <td><?=$this->Auditoria->buscarNomeOcorrencia($registro->ocorrencia)?></td>
                                            <td><?=($registro->usuario == null) ? 'Sem usuário associado' : $registro->usuario->nome?></td>
                                            <td><?=$registro->ip?></td>
                                            <td class="td-actions text-right" style="width: 10%">
                                            <?php if ($this->Membership->handleRole("detalhes_registro_auditoria")) : ?>
                                                <a href="<?= $this->Url->build(['controller' => 'Auditoria', 'action' => 'registro', $registro->id]) ?>" class="btn btn-info btn-round">
                                                    <i class="material-icons">pageview</i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($this->Membership->handleRole("excluir_registro_auditoria")) : ?>
                                                <button type="button" onclick="excluirRegistro('<?= $registro->id ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                            <?php endif; ?>
                                        </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <h3>Nenhum registro encontrado.</h3>
                        <?php endif; ?>
                    </div>
                     <div class="card-content">
                        <div class="material-datatables">
                            <div class="row">
                                <?=$this->element('pagination') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
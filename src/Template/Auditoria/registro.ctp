<?= $this->Html->script('controller/auditoria.registro.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                            <?= $this->Flash->render() ?>
                            <legend>Dados da Ocorrência</legend>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("registro", "Registro") ?><br/>
                                        <b><?=$this->Format->zeroPad($registro->id)?></b>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("data", "Data") ?><br/>
                                        <?=$this->Format->date($registro->data, true)?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("ocorrencia", "Ocorrência") ?><br/>
                                        <?= $this->Auditoria->buscarNomeOcorrencia($registro->ocorrencia)?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= $this->Form->label("descricao", "Descrição") ?><br/>
                                        <?=$registro->descricao?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <?php if ($this->Membership->handleRole("imprimir_funcionarios")) : ?>
                                <a href="<?= $this->Url->build(['controller' => 'Funcionarios', 'action' => 'documento', $id]) ?>" class="btn btn-default btn-default pull-right" target="_blank">Imprimir<div class="ripple-container"></div></a>
                            <?php endif; ?>
                            <?php if ($this->Membership->handleRole("excluir_funcionarios")) : ?>
                                <button type="button" onclick="" class="btn btn-danger pull-right">Excluir</button>
                            <?php endif; ?>
                            <?php if ($this->Membership->handleRole("editar_funcionarios")) : ?>
                                <a href="<?= $this->Url->build(['controller' => 'Funcionarios', 'action' => 'edit', $id]) ?>" class="btn btn-primary btn-default pull-right">Editar<div class="ripple-container"></div></a>
                            <?php endif; ?>
                            <button type="button" onclick="window.location='<?= $this->Url->build('/auditoria') ?>'" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

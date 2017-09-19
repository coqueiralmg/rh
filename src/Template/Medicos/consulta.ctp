<?= $this->Html->script('controller/medicos.general.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                            <?= $this->Flash->render() ?>
                            <legend>Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("nome", "Nome") ?><br/>
                                        <?= $medico->nome ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("crm", "CRM") ?><br/>
                                        <?= $medico->crm ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("especialidade", "Especialidade") ?><br/>
                                        <?= $medico->especialidade ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>

                            <?php if ($this->Membership->handleRole("imprimir_medicos")) : ?>
                                <a href="<?= $this->Url->build(['controller' => 'Medicos', 'action' => 'documento', $id]) ?>" class="btn btn-default btn-default pull-right" target="_blank">Imprimir<div class="ripple-container"></div></a>
                            <?php endif; ?>
                            <?php if ($this->Membership->handleRole("excluir_medicos")) : ?>
                                <button type="button" onclick="excluirRegistro(<?= $medico->id ?>, '<?= $medico->nome ?>')" class="btn btn-danger pull-right">Excluir</button>
                            <?php endif; ?>
                            <?php if ($this->Membership->handleRole("editar_medicos")) : ?>
                                <a href="<?= $this->Url->build(['controller' => 'Medicos', 'action' => 'edit', $id]) ?>" class="btn btn-primary btn-default pull-right">Editar<div class="ripple-container"></div></a>
                            <?php endif; ?>
                            <button type="button" onclick="window.location='<?= $this->Url->build('/medicos') ?>'" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

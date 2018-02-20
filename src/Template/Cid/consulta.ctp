<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                            <?= $this->Flash->render() ?>
                            <legend>Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("codigo", "Código") ?><br/>
                                        <?= $cid->cid ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("nome", "Nome") ?><br/>
                                        <?= $cid->nome ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("descricao", "Descrição") ?><br/>
                                        <?= $cid->descricao ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>

                            
                            <?php if ($this->Membership->handleRole("editar_cid")) : ?>
                                <a href="<?= $this->Url->build(['controller' => 'Cid', 'action' => 'edit', $id]) ?>" class="btn btn-primary btn-default pull-right">Editar<div class="ripple-container"></div></a>
                            <?php endif; ?>
                            <button type="button" onclick="window.location='<?= $this->Url->build('/cid') ?>'" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

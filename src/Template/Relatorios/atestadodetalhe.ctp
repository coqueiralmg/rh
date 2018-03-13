<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                            <?= $this->Flash->render() ?>
                            <legend>Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("funcionario", "Funcionário") ?><br/>
                                        <?= $atestado->funcionario->nome ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("emissao", "Data de Emissão") ?><br/>
                                        <?= $this->Format->date($atestado->emissao) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("afastamento", "Data de Afastamento") ?><br/>
                                        <?= $this->Format->date($atestado->afastamento) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("retorno", "Data de Retorno") ?>
                                        <?= $this->Format->date($atestado->retorno) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("quantidade_dias", "Quantidade de Dias") ?><br/>
                                        <?= $atestado->quantidade_dias ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>  
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= $this->Form->label("medico", "Médico") ?><br/>
                                        <?= $atestado->medico->nome ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <?= $this->Form->label("cid", "CID") ?><br/>
                                        <?= $atestado->cid ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?= $this->Form->label("motivo", "Motivo") ?><br/>
                                        <?= $atestado->motivo ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">                            
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= $this->Form->label("observacao", "Observação") ?> <br/>
                                        <?= $atestado->observacao ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Outras Opções</label> <br/>
                                        <div class="togglebutton">
                                            Afastado por INSS: <?=$atestado->afastado?>
                                        </div>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <a href="<?= $this->Url->build(['controller' => 'Atestados', 'action' => 'documento', $id]) ?>" class="btn btn-default btn-default pull-right" target="_blank">Imprimir<div class="ripple-container"></div></a>
                            <button type="button" onclick="window.history.back()" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                            <?= $this->Flash->render() ?>
                            <legend>Seus Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("nome", "Nome") ?><br/>
                                        <?=$usuario->nome?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("email", "E-mail") ?><br/>
                                        <?=$usuario->email?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("usuario", "Usuário") ?><br/>
                                        <?=$usuario->usuario?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">                            
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= $this->Form->label("grupo", "Grupo") ?> <br/>
                                        <?=$usuario->grupoUsuario->nome?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <a href="<?= $this->Url->build(['controller' => 'perfil', 'action' => 'senha']) ?>" class="btn btn-danger btn-default pull-right">Trocar Senha<div class="ripple-container"></div></a>
                            <a href="<?= $this->Url->build(['controller' => 'perfil', 'action' => 'edicao']) ?>" class="btn btn-primary btn-default pull-right">Editar Perfil<div class="ripple-container"></div></a>
                            <div class="clearfix"></div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

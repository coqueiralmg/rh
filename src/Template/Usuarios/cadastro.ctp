<?= $this->Html->script('controller/usuarios.cadastro.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?php
                            echo $this->Form->create($usuario, [
                                "url" => [
                                    "controller" => "usuarios",
                                    "action" => "save",
                                    $id
                                ],
                                "role" => "form"]);
                            ?>
                                <?=$this->element('message', [
                                'name' => 'cadastro_erro',
                                'type' => 'error',
                                'message' => 'Ocorreu um erro ao salvar o usuário',
                                'details' => ''
                            ]) ?>
                            <?= $this->Flash->render() ?>
                            <?= $this->Form->hidden('mudasenha', ["id" => "mudasenha", "value" => ($id == 0) ? "true" : "false"]) ?>
                            <legend>Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("nome", "Nome") ?>
                                        <?= $this->Form->text("nome", ["id" => "nome", "class" => "form-control", "maxlength" => 60]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("email", "E-mail") ?>
                                        <?= $this->Form->email("email", ["id" => "email", "class" => "form-control", "maxlength" => 50]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                               
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?= $this->Form->label("usuario", "Usuário") ?>
                                        <?= $this->Form->text("usuario", ["id" => "usuario", "class" => "form-control", "maxlength" => 30]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?= $this->Form->label("senha", "Senha") ?>
                                        <?= $this->Form->password("senha", ["id" => "senha", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?= $this->Form->label("confirma_senha", "Confirme a Senha") ?>
                                        <?= $this->Form->password("confirma_senha", ["id" => "confirma_senha", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?= $this->Form->label("grupo", "Grupo") ?> <br/>
                                        <?=$this->Form->select('grupo', $grupos, ['id' => 'grupo', 'empty' => true, 'class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Outras Opções</label> <br/>
                                        <div class="togglebutton">
                                            <label>
                                                <?= $this->Form->checkbox("ativo") ?> Ativo
                                            </label>
                                        </div>
                                        <div class="togglebutton">
                                            <label>
                                                <?= $this->Form->checkbox("verificar") ?> Obrigar o usuário a trocar de senha
                                            </label>
                                        </div>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" onclick="return validar()" class="btn btn-success pull-right">Salvar</button>
                            <?php if ($id > 0) :?>
                                <button type="button" onclick="window.location='<?= $this->Url->build('/usuarios/add') ?>'" class="btn btn-warning pull-right">Novo</button>
                            <?php endif; ?>
                            <?php if ($usuario != null && $usuario->suspenso) : ?>
                                <a href="<?= $this->Url->build(['controller' => 'Usuarios', 'action' => 'liberar', $id]) ?>" class="btn btn-default pull-right">Liberar<div class="ripple-container"></div></a>
                            <?php endif; ?>
                            <button type="reset" class="btn btn-default pull-right">Limpar</button>
                            <button type="button" onclick="window.location='<?= $this->Url->build('/usuarios') ?>'" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

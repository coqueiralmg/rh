<?= $this->Html->script('sha1.js', ['block' => 'scriptBottom']) ?>
<?= $this->Html->script('controller/perfil.senha.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?php
                            echo $this->Form->create($usuario, [
                                "url" => [
                                    "controller" => "perfil",
                                    "action" => "senha"
                                ],
                                "role" => "form"]);
                            ?>
                            <?=$this->element('message', [
                                'name' => 'cadastro_erro',
                                'type' => 'error',
                                'message' => 'Ocorreu um erro ao modificar sua senha',
                                'details' => ''
                            ]) ?>
                            <?= $this->Flash->render() ?>
                            <legend>Altere sua senha</legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("antiga", "Senha Atual") ?><br/>
                                        <?= $this->Form->hidden("senha", ["id" => "senha"]) ?>
                                        <?= $this->Form->password("antiga", ["id" => "antiga", "class" => "form-control", "maxlength" => 60]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("nova", "Nova Senha") ?><br/>
                                        <?= $this->Form->password("nova", ["id" => "nova", "class" => "form-control", "maxlength" => 60]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("confirma", "Confirme sua senha") ?><br/>
                                        <?= $this->Form->password("confirma", ["id" => "confirma", "class" => "form-control", "maxlength" => 60]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>  
                            
                            <button type="submit" onclick="return validar()" class="btn btn-success pull-right">Salvar</button>
                            <button type="button" onclick="window.location='<?= $this->Url->build('/perfil') ?>'" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

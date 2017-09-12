<?= $this->Html->script('controller/perfil.edicao.js', ['block' => 'scriptBottom']) ?>
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
                                    "action" => "save",
                                    $id
                                ],
                                "role" => "form"]);
                            ?>
                            <?=$this->element('message', [
                                'name' => 'cadastro_erro',
                                'type' => 'error',
                                'message' => 'Ocorreu um erro ao salvar o seus dados cadastrais',
                                'details' => ''
                            ]) ?>
                            <?= $this->Flash->render() ?>
                            <legend>Seus Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("nome", "Nome") ?><br/>
                                        <?= $this->Form->text("nome", ["id" => "nome", "class" => "form-control", "maxlength" => 60]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("email", "E-mail") ?><br/>
                                        <?= $this->Form->email("email", ["id" => "email", "class" => "form-control", "maxlength" => 50]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("usuario", "Usuário") ?><br/>
                                        <?= $this->Form->text("usuario", ["id" => "usuario", "class" => "form-control", "disabled" => true, "maxlength" => 30]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">                            
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= $this->Form->label("grupo", "Grupo") ?> <br/>
                                        <?=$this->Form->select('grupo', $grupos, ['id' => 'grupo', 'empty' => true, "disabled" => true,  'class' => 'form-control'])?>
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

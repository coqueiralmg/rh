<?= $this->Html->script('controller/system.password.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                <?php
                    echo $this->Form->create("usuario", [
                        'id' => 'form_login',
                        'url' => [
                            'controller' => 'system',
                            'action' => 'password'
                        ]]);
                    ?>
                    
                    <?= $this->Form->hidden('idUsuario', ['value' => $idUsuario]) ?>
                    <div class="card card-login card-hidden">
                        <div class="card-header text-center" data-background-color="blue">
                            <h4 class="card-title">Recursos Humanos</h4>
                            <p>Prefeitura Municipal de Coqueiral - Minas Gerais</p>
                        </div>
                        <p class="category text-center">
                        </p>
                        <center>
                            <?= $this->Flash->render() ?>
                             <span id="erro" class="text-danger"></span>
                        </center>
                        <div class="card-content">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">lock_outline</i>
                                </span>
                                <div class="form-group label-floating">
                                    <?= $this->Form->label('senha', 'Nova Senha', ['class' => 'control-label']) ?>
                                    <?= $this->Form->password('senha', ['id' => 'senha', 'class' => 'form-control']) ?>
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">lock</i>
                                </span>
                                <div class="form-group label-floating">
                                    <?= $this->Form->label('confirma', 'Confirme a Senha', ['class' => 'control-label']) ?>
                                    <?= $this->Form->password('confirma', ['id' => 'confirma', 'class' => 'form-control']) ?>
                                </div>
                            </div>
                        </div>
                        <div class="footer text-center">
                            <?= $this->Html->link('Cancelar', ['controller' => 'System', 'action' => 'login'], ['class' => 'btn btn-danger btn-simple btn-wd btn-lg']) ?> 
                            <button onclick="return validar()" type="submit" class="btn btn-success btn-simple btn-wd btn-lg">Salvar</button>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
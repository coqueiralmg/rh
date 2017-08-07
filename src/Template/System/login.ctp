<?= $this->Html->script('controller/system.login.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                <?php
                    echo $this->Form->create("usuario", [
                        'id' => 'form_login',
                        'url' => [
                            'controller' => 'system',
                            'action' => 'logon'
                        ]]);
                    ?>
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
                                    <i class="material-icons">face</i>
                                </span>
                                <div class="form-group label-floating">
                                    <?= $this->Form->label('usuario', 'Login ou e-mail', ['class' => 'control-label']) ?>
                                    <?= $this->Form->text('usuario', ['id' => 'usuario', 'class' => 'form-control', 'value' => $login]) ?>
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">lock_outline</i>
                                </span>
                                <div class="form-group label-floating">
                                    <?= $this->Form->label('senha', 'Senha', ['class' => 'control-label']) ?>
                                    <?= $this->Form->password('senha', ['id' => 'senha', 'class' => 'form-control']) ?>
                                </div>
                            </div>
                        </div>
                        <div class="footer text-center">
                            <button type="submit" onclick="return validar()" class="btn btn-success btn-simple btn-wd btn-lg">Entrar</button>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

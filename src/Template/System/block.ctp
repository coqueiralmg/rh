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
                        <div class="card-header text-center" data-background-color="green">
                            <h4 class="card-title">Painel de Controle</h4>
                            <p>Prefeitura Municipal de Coqueiral - Minas Gerais</p>
                        </div>
                        <p class="category text-center">
                        </p>
                        <center>
                             <?php if($usuario == null):?>
                                <span id="erro" class="text-info">O sistema bloqueou o IP <?=$ip?>. Portanto, não foi encontrado no sistema, a conta com o login <?=$login?>. Pode ficar sossegado agora. </span>
                             <?php else: ?>
                                <span id="erro" class="text-info">O sistema bloqueou o IP <?=$ip?>. Deseja suspenser a conta <?=$login?>? </span>

                                <div class="footer text-center">
                                    <?= $this->Html->link('Sim', ['controller' => 'System', 'action' => 'suspend', $usuario->id], ['class' => 'btn btn-success btn-simple btn-wd btn-lg']) ?> 
                                    <?= $this->Html->link('Não', ['controller' => 'System', 'action' => 'login'], ['class' => 'btn btn-danger btn-simple btn-wd btn-lg']) ?> 
                                </div>
                             <?php endif;?>
                        </center>
                        
                    </div>
                    <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
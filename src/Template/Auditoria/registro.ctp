<?= $this->Html->script('controller/auditoria.general.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                            <?= $this->Flash->render() ?>
                            <legend>Dados da Ocorrência</legend>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("registro", "Registro") ?><br/>
                                        <b><?=$this->Format->zeroPad($registro->id)?></b>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("data", "Data") ?><br/>
                                        <?=$this->Format->date($registro->data, true)?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("ocorrencia", "Ocorrência") ?><br/>
                                        <?= $this->Auditoria->buscarNomeOcorrencia($registro->ocorrencia)?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("responsavel", "Responsável") ?><br/>
                                        <?=($registro->usuario == null) ? 'Sem usuário associado' : $registro->usuario->nome?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("navegador", "Navegador") ?><br/>
                                        <?= $this->Agent->getBrowser($registro->agent)?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("so", "Sistema Operacional") ?><br/>
                                        <?= $this->Agent->getOperationSystem($registro->agent)?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("ip", "Endereço de IP") ?><br/>
                                        <?= $registro->ip?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= $this->Form->label("descricao", "Descrição") ?><br/>
                                        <?=$registro->descricao?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                    </div>
                    <?php
                    if($registro->dado_adicional != null):
                        $dados = json_decode($registro->dado_adicional);
                    ?>
                    <div class="card-content">
                        <legend>Dados Adicionais</legend>
                        <?php foreach($dados as $key => $value): ?>
                            <?php if(is_object($value)): ?>
                                <h6><?=$this->Inflector->humanize($key)?></h6>
                                <?php foreach($value as $k => $s): ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?=$this->Inflector->humanize($k)?>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <?php if(is_object($s)): ?>
                                                    <?php if(count($s) > 0): ?>
                                                        <ul style="list-style-type: none">
                                                            <?php foreach($s as $a => $b): ?>
                                                                <li><?=$this->Inflector->humanize($a)?>: <?=$b?></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php else: ?>
                                                        Nenhum
                                                    <?php endif; ?>
                                                <?php elseif(is_array($s)): ?>
                                                    <?php if(count($s) > 0): ?>
                                                        <ul>
                                                            <?php foreach($s as $b): ?>
                                                                <li><?=$b?></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php else: ?>
                                                        Nenhum
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <?=$s?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            <?php elseif(is_array($value)): ?>
                                <h6><?=$this->Inflector->humanize($key)?></h6>
                                <div class="row">
                                    <div class="col-md-8">
                                        <ul>
                                            <?php foreach($value as $v): ?>
                                                <li><?=$v?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><?=$this->Inflector->humanize($key)?></label><br/>
                                            <?=$value?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach;?>      
                        <div class="clearfix"></div>
                    </div>
                    <?php endif; ?>
                    <?php if($registro->usuario != null):?>
                        <div class="card-content">
                            <legend>Informações Sobre Usuário Responsável</legend>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("id", "ID") ?><br/>
                                        <b><?=$this->Format->zeroPad($registro->usuario->id)?></b>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("nome", "Nome") ?><br/>
                                        <?= $registro->usuario->nome?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("email", "E-mail") ?><br/>
                                        <?=$registro->usuario->email?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("usuario", "Usuario") ?><br/>
                                        <?=$registro->usuario->usuario?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("grupo", "Grupo") ?><br/>
                                        <?= $registro->usuario->grupoUsuario->nome?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("ativo", "Ativo") ?><br/>
                                        <?=$registro->usuario->ativado?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="card-content">
                        <?php if ($this->Membership->handleRole("imprimir_auditoria")) : ?>
                            <a href="<?= $this->Url->build(['controller' => 'Auditoria', 'action' => 'documento', $id]) ?>" class="btn btn-default btn-default pull-right" target="_blank">Imprimir<div class="ripple-container"></div></a>
                        <?php endif; ?>
                        <?php if ($this->Membership->handleRole("excluir_registro_auditoria")) : ?>
                            <button type="button" onclick="excluirRegistro('<?= $registro->id ?>')" class="btn btn-danger pull-right">Excluir</button>
                        <?php endif; ?>
                        <button type="button" onclick="window.location='<?= $this->Url->build('/auditoria') ?>'" class="btn btn-info pull-right">Voltar</button>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

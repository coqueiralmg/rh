<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-md-6">
                <div class="card card-user">
                    <div class="image">
                    </div>
                    <div class="content">
                        <div class="author">
                            <i class="ti-file" style="font-size: xx-large"></i>
                            <h5>Item</h5>
                            <h4 class="title"><?=$this->Format->zeroPad($auditoria->id)?></h4>
                        </div>
                        <p class="description text-center">
                            <?=$auditoria->ocorrencia?>
                        </p>
                        <p class="description text-center">
                            <?=$auditoria->descricao?>
                        </p>
                    </div>
                    <hr>
                    <div class="text-center">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Data da Ocorrência</h5>
                            </div>
                            <div class="col-md-6">
                                <h5><small><?=$auditoria->data->format('d/m/Y H:i:s')?></small></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="header">
                        <h4 class="title">Dados do Responsável</h4>
                    </div>
                    <div class="content">
                        <ul class="list-unstyled team-members">
                            <li>
                                <div class="row">
                                    <div class="col-xs-4">
                                        Nome
                                    </div>
                                    <div class="col-xs-8">
                                        <?=$auditoria->responsavel->nome?>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="col-xs-4">
                                        Login
                                    </div>
                                    <div class="col-xs-8">
                                        <?=$auditoria->responsavel->nickname?>
                                    </div>

                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="col-xs-4">
                                        E-mail
                                    </div>
                                    <div class="col-xs-8">
                                        <?=$auditoria->responsavel->email?>
                                    </div>

                                </div>
                            </li>
                            
                            <li>
                                <div class="row">
                                    <div class="col-xs-4">
                                        Grupo
                                    </div>
                                    <div class="col-xs-8">
                                        <?=$grupo_usuario->nome?>
                                    </div>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-6">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Detalhes da Ocorrência</h4>
                    </div>
                    <div class="content">
                        <form>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Número</label><br/>
                                        <?=$this->Format->zeroPad($auditoria->id)?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Ocorrência</label><br/>
                                        <?=$this->Auditoria->buscarNomeOcorrencia($auditoria->ocorrencia)?>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Data</label><br/>
                                        <?=$auditoria->data->format('d/m/Y H:i:s')?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>IP</label><br/>
                                        <?=$auditoria->ip?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Navegador</label><br/>
                                        <?=$this->Agent->getBrowser($auditoria->agent)?>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Sistema Operacional</label><br/>
                                        <?=$this->Agent->getOperationSystem($auditoria->agent)?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Descrição</label><br/>
                                        <?=$auditoria->descricao?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                if($auditoria->dado_adicional != null):

                    $dados = json_decode($auditoria->dado_adicional);
                ?>
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Dados Adicionais</h4>
                        </div>
                        <div class="content">
                            <?php foreach($dados as $key => $value): ?>
                                <?php if(is_object($value)): ?>
                                    <h6><?=\Cake\Utility\Inflector::humanize($key)?></h6>
                                    <table class="table">
                                        <?php foreach($value as $k => $s): ?>
                                            <tr>
                                                <td><?=\Cake\Utility\Inflector::humanize($k)?></td>
                                                <?php if(is_object($s)): ?>
                                                    <td>
                                                        <?php if(count($s) > 0): ?>
                                                        <ul>
                                                            <?php foreach($s as $a => $b): ?>
                                                                <li><?=$b?></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                        <?php else: ?>
                                                            Nenhum
                                                        <?php endif; ?>
                                                    </td>
                                                <?php elseif(is_array($s)): ?>
                                                    <td>
                                                    <?php if(count($s) > 0): ?>
                                                        <ul>
                                                            <?php foreach($s as $a => $b): ?>
                                                                <li><?=$b?></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php else: ?>
                                                        Nenhum
                                                    <?php endif; ?>
                                                    </td>
                                                <?php else: ?>
                                                    <td><?=$s?></td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                <?php elseif(is_array($value)): ?>
                                    <h6><?=\Cake\Utility\Inflector::humanize($key)?></h6>
                                    <ul>
                                        <?php foreach($value as $v): ?>
                                            <li><?=$v?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><?=\Cake\Utility\Inflector::humanize($key)?></label><br/>
                                                <?=$value?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="card">
                    <div class="content">
                        <div class="text-right">
                            <button type="button" onclick="window.location = '<?= $this->Url->build('/auditoria') ?>'"
                                    class="btn btn-primary">Voltar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script('controller/firewall.cadastro.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?php
                            echo $this->Form->create($firewall, [
                                "url" => [
                                    "controller" => "firewall",
                                    "action" => "save",
                                    $id
                                ],
                                "role" => "form"]);
                            ?>
                                <?=$this->element('message', [
                                'name' => 'cadastro_erro',
                                'type' => 'error',
                                'message' => 'Ocorreu um erro ao salvar o registro do firewall',
                                'details' => ''
                            ]) ?>
                            <?= $this->Flash->render() ?>
                            <legend>Bloquear ou Cadastrar na Lista Branca</legend>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("ip", "Endereço de IP") ?>
                                        <?= $this->Form->text("ip", ["id" => "ip", "class" => "form-control", "maxlength" => 15]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    
                                </div>
                                <?php if ($firewall != null) : ?>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <label>Data do Cadastro</label>
                                        <p><i><?= $this->Format->date($firewall->data, true)?></i></p>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="col-md-6">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("tipo_lista", "Tipo de Registro") ?> <br/>
                                        <?= $this->Form->radio("tipo_lista", $tipo_lista) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= $this->Form->label("motivo", "Motivo") ?>
                                        <?= $this->Form->textarea("motivo", ["id" => "motivo", "class" => "form-control", "rows" => 2, "maxlength" => 160]) ?>
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
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" onclick="return validar()" class="btn btn-success pull-right">Salvar</button>
                            <?php if ($id > 0) :?>
                                <button type="button" onclick="window.location='<?= $this->Url->build('/firewall/add') ?>'" class="btn btn-warning pull-right">Novo</button>
                            <?php endif; ?>
                            <button type="reset" class="btn btn-default pull-right">Limpar</button>
                            <button type="button" onclick="window.location='<?= $this->Url->build('/firewall') ?>'" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

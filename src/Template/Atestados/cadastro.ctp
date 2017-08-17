<?= $this->Html->script('controller/atestados.cadastro.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?php
                            echo $this->Form->create($atestado, [
                                "url" => [
                                    "controller" => "atestados",
                                    "action" => "save",
                                    $id
                                ],
                                "role" => "form"]);
                            ?>
                                <?=$this->element('message', [
                                'name' => 'cadastro_erro',
                                'type' => 'error',
                                'message' => 'Ocorreu um erro ao salvar o atestado',
                                'details' => ''
                            ]) ?>
                            <?= $this->Flash->render() ?>
                            <legend>Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("funcionario", "Funcionário") ?>
                                        <?= $this->Form->hidden("funcionario") ?>
                                        <?= $this->Form->text("nome_funcionario", ["id" => "nome_funcionario", "class" => "form-control", "maxlength" => 80]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("data_emissao", "Data de Emissão") ?>
                                        <?= $this->Form->text("data_emissao", ["id" => "data_emissao", "class" => "form-control", "maxlength" => 14]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("data_afastamento", "Data de Afastamento") ?>
                                        <?= $this->Form->text("data_afastamento", ["id" => "data_afastamento", "class" => "form-control", "maxlength" => 14]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("data_retorno", "Data de Retorno") ?>
                                        <?= $this->Form->text("data_retorno", ["id" => "data_retorno", "class" => "form-control", "maxlength" => 11]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("quantidade_dias", "Quantidade de Dias") ?>
                                        <?= $this->Form->number("quantidade_dias", ["id" => "quantidade_dias", "class" => "form-control", "maxlength" => 3]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>  
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= $this->Form->label("medico", "Médico") ?>
                                        <?= $this->Form->hidden("medico") ?>
                                        <?= $this->Form->text("nome_medico", ["id" => "nome_medico", "class" => "form-control", "maxlength" => 80]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <?= $this->Form->label("cid", "CID") ?>
                                        <?= $this->Form->text("cid", ["id" => "cid", "class" => "form-control", "maxlength" => 3]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?= $this->Form->label("motivo", "Motivo") ?>
                                        <?= $this->Form->text("motivo", ["id" => "motivo", "class" => "form-control", "maxlength" => 160]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">                            
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= $this->Form->label("observacao", "Observação") ?> <br/>
                                        <?= $this->Form->textarea("observacao", ["id" => "observacao", "class" => "form-control"]) ?>
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
                                                <?= $this->Form->checkbox("inss") ?> Afastado por INSS
                                            </label>
                                        </div>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" onclick="return validar()" class="btn btn-success pull-right">Salvar</button>
                            <button type="reset" class="btn btn-default pull-right">Limpar</button>
                            <button type="button" onclick="window.location='<?= $this->Url->build('/atestados') ?>'" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

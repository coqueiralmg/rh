
<div class="content">
    <div class="container-fluid">
        <?php
            echo $this->Form->create(null, [
                "url" => [
                    "controller" => "cid",
                    "action" => "import"
                ],
                "role" => "form"]);
        ?>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-content">
                        <?=$this->element('message', [
                            'name' => 'cadastro_erro',
                            'type' => 'error',
                            'message' => 'Ocorreu um erro ao salvar o CID.',
                            'details' => ''
                        ]) ?>
                            <?= $this->Flash->render() ?>
                            <legend>Importação de Arquivo</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("tipo", "Tipo de Arquivo de Importação") ?>
                                        <?= $this->Form->select("tipo", $tipo_arquivo, ["id" => "tipo", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("separador", "Separador") ?>
                                        <?= $this->Form->select("separador", $separador, ["id" => "separador", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group form-file-upload is-fileinput">
                                        <?= $this->Form->label("arquivo", "Arquivo") ?>
                                        <?= $this->Form->file("arquivo", ["id" => "arquivo", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Outras Opções</label> <br/>
                                        <div class="togglebutton">
                                            <label>
                                                <?= $this->Form->checkbox("junto") ?> O arquivo contém código junto com detalhamento.
                                            </label>
                                        </div>
                                        <div class="togglebutton">
                                            <label>
                                                <?= $this->Form->checkbox("separado") ?> O código e o detalhamento são separados por ponto.
                                            </label>
                                        </div>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>   



                            <button type="submit" onclick="return validar()" class="btn btn-success pull-right">Salvar</button>
                            <button type="reset" class="btn btn-default pull-right">Limpar</button>
                            <button type="button" onclick="window.location='<?= $this->Url->build('/cid') ?>'" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                       
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-content">
                        
                        <legend>Ordem da Importação</legend>
                        <div class="row">
                            <div class="col-md-12">
                               <ul id="sortable">
                                    <li class="ui-state-default">Item 1</li>
                                    <li class="ui-state-default">Item 2</li>
                                    <li class="ui-state-default">Item 3</li>
                                    <li class="ui-state-default">Item 4</li>
                                    <li class="ui-state-default">Item 5</li>
                                    <li class="ui-state-default">Item 6</li>
                                    <li class="ui-state-default">Item 7</li>
                                </ul>        
                            </div>
                            
                        </div>
                        
                        
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

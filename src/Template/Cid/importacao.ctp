<?= $this->Html->script('controller/cid.importacao.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <?php
            echo $this->Form->create(null, [
                "url" => [
                    "controller" => "cid",
                    "action" => "file"
                ],
                'enctype' => 'multipart/form-data',
                "role" => "form"]);
        ?>
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-content">
                        <?=$this->element('message', [
                            'name' => 'cadastro_erro',
                            'type' => 'error',
                            'message' => 'Ocorreu um erro ao efetuar a importação do CID.',
                            'details' => ''
                        ]) ?>
                            <?= $this->Flash->render() ?>
                            <?= $this->Form->hidden('campos', ['id' => 'campos']) ?>
                            <legend>Importação de Dados via Arquivo</legend>
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
                                                <?= $this->Form->checkbox("ignorar") ?> Ignorar a primeira linha.
                                            </label>
                                        </div>
                                        <div class="togglebutton">
                                            <label>
                                                <?= $this->Form->checkbox("junto", ["id" => "junto"]) ?> O arquivo contém código junto com detalhamento.
                                            </label>
                                        </div>
                                        <div class="togglebutton">
                                            <label>
                                                <?= $this->Form->checkbox("separado", ["id" => "separado"]) ?> O código e o detalhamento são separados por ponto.
                                            </label>
                                        </div>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>   
                            <button type="submit" onclick="return validar()" class="btn btn-rose pull-right">Importar</button>
                            <button type="reset" class="btn btn-default pull-right">Limpar</button>
                            <button type="button" onclick="window.location='<?= $this->Url->build('/cid') ?>'" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-content">
                        <legend>Ordem dos Campos no Arquivo</legend>
                        <div class="row">
                            <div class="col-md-12 text-center">
                               <ul id="sortable">
                                    <li id="bdgCodigo" name="codigo" class="badge badge-primary">Código</li>
                                    <li id="bdgDetalhamento" name="detalhamento" class="badge badge-primary">Detalhamento</li>
                                    <li id="bdgCodDet" name="codigo_detalhamento" style="display: none" class="badge badge-primary">Código/Detalhamento</li>
                                    <li id="bdgNome" name="nome" class="badge badge-primary">Nome</li>
                                    <li id="bdgDescricao"  name="descricao" class="badge badge-secondary">Descrição</li>
                                </ul>
                                <hr/>
                                <a href="#" onclick="zerarPosicoes()">Resetar<div class="ripple-container"></div></a>
                                <br/><br/>
                                <div class="alert alert-info alert-with-icon text-left" data-notify="container">
                                    <button type="button" aria-hidden="true" class="close" onclick="$(this).parent().hide()">×</button>
                                    <i data-notify="icon" class="material-icons">info</i>
                                    <span data-notify="message">Você pode ordenar os campos dispostos no arquivo, para que o sistema leia corretamente. Para fazer isso, basta apenas arrastar e soltar os campos acima. O campo descrição é um campo opcional. Caso os dados com a descrição detalhada do CID não aparecerem no arquivo, recomenda-se deixar por último. O sistema irá desconsiderar seu uso.</span>
                                </div>        
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

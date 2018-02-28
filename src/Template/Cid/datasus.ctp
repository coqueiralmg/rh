<div class="content">
    <div class="container-fluid">
        <?php
            echo $this->Form->create(null, [
                "url" => [
                    "controller" => "cid",
                    "action" => "fsus"
                ],
                'enctype' => 'multipart/form-data',
                "role" => "form"]);
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?=$this->element('message', [
                            'name' => 'cadastro_erro',
                            'type' => 'error',
                            'message' => 'Ocorreu um erro ao efetuar a importação do CID.',
                            'details' => ''
                        ]) ?>
                            <?= $this->Flash->render() ?>
                            <legend>Importação de Dados via Datasus</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("tipo", "Tipo de Arquivo de Importação") ?>
                                        <?= $this->Form->select("tipo", $tipo_arquivo, ["id" => "tipo", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group form-file-upload is-fileinput">
                                        <?= $this->Form->label("arquivo", "Arquivo") ?>
                                        <?= $this->Form->file("arquivo", ["id" => "arquivo", "class" => "form-control"]) ?>
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
            
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

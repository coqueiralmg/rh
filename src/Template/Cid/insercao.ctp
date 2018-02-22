<?= $this->Html->script('controller/cid.insercao.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <?php
                        echo $this->Form->create(null, [
                            "url" => [
                                "controller" => "cid",
                                "action" => "push"
                            ],
                            "role" => "form"]);
                        ?>
                            <?=$this->element('message', [
                            'name' => 'cadastro_erro',
                            'type' => 'error',
                            'message' => 'Ocorreu um erro ao salvar o CID.',
                            'details' => ''
                        ]) ?>
                    <div class="card-content table-responsive">
                        <h4 class="card-title">Dados de CID a serem inseridos</h4>
                        <table id="tblCadastro" class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th style="width: 12%">Código</th>
                                    <th style="width: 10%">Detalhamento</th>
                                    <th>Nome</th>
                                    <th style="width: 10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="tr_clone">
                                    <td>
                                        <?=$this->Form->text("codigo[]", ["id" => "codigo", "onblur" => "uppercaseCID(this)",  "class" => "form-control", "maxlength" => 3])?>
                                    </td>
                                    <td>
                                        <?=$this->Form->text("detalhamento[]", ["id" => "detalhamento", "class" => "form-control", "maxlength" => 1])?>
                                    </td>
                                    <td>
                                        <?=$this->Form->text("nome[]", ["id" => "nome", "class" => "form-control", "onkeydown" => "finalizarLinha(this, event)", "maxlength" => 150])?>
                                    </td>
                                    <td class="td-actions text-right">
                                        <button type="button" tabindex="10000" onclick="adicionarLinha(this)" class="btn btn-info btn-round btn-add"><i class="material-icons">add</i></button>    
                                        <button type="button" tabindex="10001" onclick="removerLinha(this)" id="btnRemoveRow" disabled="true" onclick="" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <div class="card-content">
                        <div class="material-datatables">
                            <div class="row">
                            <button type="submit" onclick="return validar()" class="btn btn-success pull-right">Salvar</button>
                            <button type="reset" class="btn btn-default pull-right">Limpar</button>
                            <button type="button" onclick="window.location='<?= $this->Url->build('/cid') ?>'" class="btn btn-info pull-right">Voltar</button>
                            </div>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

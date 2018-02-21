<?= $this->Html->script('controller/cid.lista.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?= $this->Flash->render() ?>
                        <h4 class="card-title">Buscar</h4>
                        <?php
                        echo $this->Form->create("CID", [
                            "url" => [
                                "controller" => "cid",
                                "action" => "index"
                            ],
                            'type' => 'get',
                            "role" => "form"]);
                        ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("codigo", "Código") ?>
                                        <?= $this->Form->text("codigo", ["class" => "form-control"]) ?>
                                        <span class="material-input"></span></div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("detalhamento", "Detalhamento") ?>
                                        <?= $this->Form->text("detalhamento", ["class" => "form-control"]) ?>
                                        <span class="material-input"></span></div>
                                </div>
                                
                                <div class="col-md-8">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("nome", "Nome") ?>
                                        <?= $this->Form->text("nome", ["class" => "form-control"]) ?>
                                    <span class="material-input"></span></div>
                                </div>
                            </div>
                            
                            <div class="form-group form-button">
                                <button type="submit" onclick="return validar()" class="btn btn-fill btn-success pull-right">Buscar<div class="ripple-container"></div></button>
                                <?php if ($this->Membership->handleRole("adicionar_cid")) : ?>
                                    <a href="<?= $this->Url->build(['controller' => 'Cid', 'action' => 'add']) ?>" class="btn btn-warning btn-default pull-right">Novo<div class="ripple-container"></div></a>
                                    <a href="<?= $this->Url->build(['controller' => 'Cid', 'action' => 'addc']) ?>" class="btn btn-warning btn-default pull-right">Cadastro em Massa<div class="ripple-container"></div></a>
                                    <a href="<?= $this->Url->build(['controller' => 'Cid', 'action' => 'importar']) ?>" class="btn btn-rose btn-default pull-right">Importar<div class="ripple-container"></div></a>
                                <?php endif; ?>
                                <?php if ($this->Membership->handleRole("imprimir_cid")) : ?>
                                    <a href="<?= $this->Url->build(['controller' => 'Cid', 'action' => 'imprimir', '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                                <?php endif;?>
                            </div>
                            <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if (count($itens) > 0) :?>
                            <h4 class="card-title">Tabela de CID</h4>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Código</th>
                                        <th>Nome</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($itens as $item) : ?>
                                        <tr>
                                            <td><?=$item->cid?></td>
                                            <td><?=$item->nome?></td>
                                            <td class="td-actions text-right" style="width: 12%">
                                                <?php if ($this->Membership->handleRole("visualizar_cid")) : ?>
                                                    <a href="<?= $this->Url->build(['controller' => 'Cid', 'action' => 'view', $item->id]) ?>" class="btn btn-info btn-round">
                                                        <i class="material-icons">pageview</i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($this->Membership->handleRole("editar_cid")) : ?>
                                                    <a href="<?= $this->Url->build(['controller' => 'Cid', 'action' => 'edit', $item->id]) ?>" class="btn btn-primary btn-round">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($this->Membership->handleRole("excluir_cid")) : ?>
                                                    <button type="button" onclick="excluirCID(<?= $item->id ?>, '<?= $item->cid ?>', '<?= $item->nome ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <?php if ($this->Membership->handleRole("adicionar_cid")) : ?>
                                <h3>Nenhum item encontrado. Para cadastra o novo item, <?=$this->Html->link("clique aqui", ["controller" => "Cid", "action" => "add"])?>.</h3>
                            <?php else :?>
                                <h3>Nenhum item encontrado.</h3>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                     <div class="card-content">
                        <div class="material-datatables">
                            <div class="row">
                                <?=$this->element('pagination') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

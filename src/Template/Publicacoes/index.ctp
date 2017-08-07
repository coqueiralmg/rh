<?= $this->Html->script('controller/publicacoes.lista.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?= $this->Flash->render() ?>
                         <?=$this->element('message', [
                            'name' => 'lista_erro',
                            'type' => 'error',
                            'message' => 'Ocorreu um erro ao buscar as publicações',
                            'details' => ''
                        ]) ?>
                        <h4 class="card-title">Buscar</h4>
                        
                        <?php
                        echo $this->Form->create("Usuario", [
                            "url" => [
                                "controller" => "publicacoes",
                                "action" => "index"
                            ],
                            'type' => 'get',
                            "role" => "form"]);
                        ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("numero", "Número") ?>
                                        <?= $this->Form->text("numero", ["class" => "form-control"]) ?>
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("titulo", "Título") ?>
                                        <?= $this->Form->text("titulo", ["class" => "form-control"]) ?>
                                        <span class="material-input"></span></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("data_inicial", "Data Inicial") ?>
                                        <?= $this->Form->text("data_inicial", ["id" => "data_inicial", "class" => "form-control"]) ?>
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("data_final", "Data Inicial") ?>
                                        <?= $this->Form->text("data_final", ["id" => "data_final", "class" => "form-control"]) ?>
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("mostrar", "Mostrar") ?> <br/>
                                        <?=$this->Form->select('mostrar', $combo_mostra, ['class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-button">
                            <button type="submit" onclick="return validar()" class="btn btn-fill btn-success pull-right">Buscar<div class="ripple-container"></div></button>
                            <?php if ($this->Membership->handleRole("adicionar_publicacao")): ?>
                                <a href="<?= $this->Url->build(['controller' => 'Publicacoes', 'action' => 'add']) ?>" class="btn btn-warning btn-default pull-right">Novo<div class="ripple-container"></div></a>
                            <?php endif; ?>
                            <a href="<?= $this->Url->build(['controller' => 'Publicacoes', 'action' => 'imprimir', '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                            </div>
                         <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if(count($publicacoes) > 0):?>
                        <h4 class="card-title">Lista de Publicações</h4>
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th>Número</th>
                                    <th>Título</th>
                                    <th>Data</th>
                                    <th>Ativo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($publicacoes as $publicacao): ?>
                                    <tr>
                                        <td><?=$publicacao->numero?></td>
                                        <td><?=$publicacao->titulo?></td>
                                        <td><?= $this->Format->date($publicacao->data) ?></td>
                                        <td><?= $publicacao->ativado ?></td>
                                        <td class="td-actions text-right" style="width: 8%">
                                            <?php if ($this->Membership->handleRole("editar_publicacao")): ?>
                                                <a href="<?= $this->Url->build(['controller' => 'Publicacoes', 'action' => 'edit', $publicacao->id]) ?>" class="btn btn-primary btn-round">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($this->Membership->handleRole("excluir_publicacao")): ?>
                                                <button type="button" onclick="excluirPublicacao(<?= $publicacao->id ?>, '<?= $publicacao->ip ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                            <?php if ($this->Membership->handleRole("adicionar_usuario")): ?>
                                <h3>Nenhuma publicação encontrada. Para adicionar nova publicação, <?=$this->Html->link("clique aqui", ["controller" => "publicacoes", "action" => "add"])?>.</h3>
                            <?php else:?>
                                <h3>Nenhuma publicação encontrada.</h3>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                     <div class="card-content">
                        <div class="material-datatables">
                            <div class="row">
                               <?=$this->element('pagination', $opcao_paginacao) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
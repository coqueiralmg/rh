
<?
    var_dump($relatorio)
 ?>
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
                                "controller" => "relatorios",
                                "action" => "funcionariosatestados"
                            ],
                            'type' => 'get',
                            "role" => "form"]);
                        ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("empresa", "Empresa") ?> <br/>
                                        <?=$this->Form->select('empresa', $empresas, ['empty' => 'Todos', 'class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("tipo_funcionario", "Tipo de Funcionário") ?> <br/>
                                        <?=$this->Form->select('tipo_funcionario', $tipos_funcionarios, ['empty' => 'Todos', 'class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("exibir", "Exibir") ?> <br/>
                                        <?=$this->Form->select('exibir', $combo_exibir, ['class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("mostrar", "Mostrar") ?> <br/>
                                        <?=$this->Form->select('mostrar', $combo_mostra, ['class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group form-button">
                                <button type="submit" onclick="return validar()" class="btn btn-fill btn-success pull-right">Buscar<div class="ripple-container"></div></button>
                                <a href="<?= $this->Url->build(['controller' => 'Cid', 'action' => 'imprimir', '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                            </div>
                            <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if (count($relatorio) > 0) :?>
                            <h4 class="card-title">Tabela de CID</h4>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Matricula</th>
                                        <th>Nome</th>
                                        <th>Cargo</th>
                                        <th>Tipo</th>
                                        <th>Empresa</th>
                                        <th>Atestados</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($relatorio as $item) : ?>
                                        <tr>
                                            <td><?=$item->matricula?></td>
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
                </div>
            </div>
        </div>
    </div>
</div>

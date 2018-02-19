<?= $this->Html->script('controller/funcionarios.general.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?= $this->Flash->render() ?>
                        <h4 class="card-title">Buscar</h4>
                        <?php
                        echo $this->Form->create("Usuario", [
                            "url" => [
                                "controller" => "funcionarios",
                                "action" => "index"
                            ],
                            'type' => 'get',
                            "role" => "form"]);
                        ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("matricula", "Matricula") ?>
                                        <?= $this->Form->text("matricula", ["class" => "form-control"]) ?>
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("nome", "Nome") ?>
                                        <?= $this->Form->text("nome", ["class" => "form-control"]) ?>
                                      <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("area", "Área") ?>
                                        <?= $this->Form->text("area", ["class" => "form-control"]) ?>
                                    <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("cargo", "Cargo") ?>
                                        <?= $this->Form->text("cargo", ["class" => "form-control"]) ?>
                                    <span class="material-input"></span></div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("empresa", "Empresa") ?> <br/>
                                        <?=$this->Form->select('empresa', $empresas, ['empty' => 'Todos', 'class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("tipo", "Tipo de Funcionário") ?> <br/>
                                        <?=$this->Form->select('tipo', $tipos_funcionarios, ['empty' => 'Todos', 'class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
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
                            <button type="submit" class="btn btn-fill btn-success pull-right">Buscar<div class="ripple-container"></div></button>
                            <?php if ($this->Membership->handleRole("adicionar_funcionarios")) : ?>
                                <a href="<?= $this->Url->build(['controller' => 'Funcionarios', 'action' => 'add']) ?>" class="btn btn-warning btn-default pull-right">Novo<div class="ripple-container"></div></a>
                            <?php endif; ?>
                            <?php if ($this->Membership->handleRole("imprimir_funcionarios")) : ?>
                                <a href="<?= $this->Url->build(['controller' => 'Funcionarios', 'action' => 'imprimir', '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                            <?php endif; ?>
                            </div>
                            <?php echo $this->Form->end(); ?>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if (count($funcionarios) > 0) :?>
                            <h4 class="card-title">Lista de Funcionários</h4>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Matrícula</th>
                                        <th>Nome</th>
                                        <th>Cargo</th>
                                        <th>Área</th>
                                        <th>Tipo</th>
                                        <th>Ativo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($funcionarios as $funcionario) : ?>
                                        <tr>
                                            <td><?=$funcionario->matricula?></td>
                                            <td><?=$funcionario->nome?></td>
                                            <td><?=$funcionario->cargo?></td>
                                            <td><?=$funcionario->area?></td>
                                            <td><?=$funcionario->tipo->descricao?></td>
                                            <td><?=$funcionario->ativado?></td>
                                            <td class="td-actions text-right" style="width: 12%">
                                                <?php if ($this->Membership->handleRole("visualizar_funcionarios")) : ?>
                                                    <a href="<?= $this->Url->build(['controller' => 'Funcionarios', 'action' => 'view', $funcionario->id]) ?>" class="btn btn-info btn-round">
                                                        <i class="material-icons">pageview</i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($this->Membership->handleRole("editar_funcionarios")) : ?>
                                                    <a href="<?= $this->Url->build(['controller' => 'Funcionarios', 'action' => 'edit', $funcionario->id]) ?>" class="btn btn-primary btn-round">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($this->Membership->handleRole("excluir_funcionarios")) : ?>
                                                    <button type="button" onclick="excluirFuncionario(<?= $funcionario->id ?>, '<?= $funcionario->nome ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <?php if ($this->Membership->handleRole("adicionar_funcionarios")) : ?>
                                <h3>Nenhum funcionario encontrado. Para adicionar novo funcionário, <?=$this->Html->link("clique aqui", ["controller" => "Funcionarios", "action" => "add"])?>.</h3>
                            <?php else :?>
                                <h3>Nenhum funcionário encontrado.</h3>
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

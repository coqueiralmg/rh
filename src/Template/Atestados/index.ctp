<?= $this->Html->script('controller/atestados.general.js', ['block' => 'scriptBottom']) ?>
<?= $this->Html->script('controller/atestados.lista.js', ['block' => 'scriptBottom']) ?>
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
                            'message' => 'Ocorreu um erro ao buscar as atestados',
                            'details' => ''
                        ]) ?>
                        <h4 class="card-title">Buscar</h4>
                        <?php
                        echo $this->Form->create("Atestado", [
                            "url" => [
                                "controller" => "atestados",
                                "action" => "index"
                            ],
                            'type' => 'get',
                            "role" => "form"]);
                        ?>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("funcionario", "Funcionario") ?>
                                        <?= $this->Form->text("funcionario", ["class" => "form-control"]) ?>
                                        <span class="material-input"></span></div>
                                </div>
                                
                                <div class="col-md-5">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("medico", "Médico") ?>
                                        <?= $this->Form->text("medico", ["class" => "form-control"]) ?>
                                    <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("cid", "CID") ?>
                                        <?= $this->Form->text("cid", ["id" => "cid", "class" => "form-control"]) ?>
                                    <span class="material-input"></span></div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("emissao_inicial", "Data de Emissão Inicial") ?> <br/>
                                        <?= $this->Form->text("emissao_inicial", ["id" => "emissao_inicial", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("emissao_final", "Data de Emissão Final") ?> <br/>
                                        <?= $this->Form->text("emissao_final", ["id" => "emissao_final", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("afastamento_inicial", "Data de Afastamento Inicial") ?> <br/>
                                        <?= $this->Form->text("afastamento_inicial", ["id" => "afastamento_inicial", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("afastamento_final", "Data de Afastamento Final") ?> <br/>
                                        <?= $this->Form->text("afastamento_final", ["id" => "afastamento_final", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
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
                                        <?= $this->Form->label("tipo_funcionario", "Tipo de Funcionário") ?> <br/>
                                        <?=$this->Form->select('tipo_funcionario', $tipos_funcionarios, ['empty' => 'Todos', 'class' => 'form-control'])?>
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
                                <button type="submit" onclick="return validar()" class="btn btn-fill btn-success pull-right">Buscar<div class="ripple-container"></div></button>
                                <?php if ($this->Membership->handleRole("adicionar_atestados")) : ?>
                                    <a href="<?= $this->Url->build(['controller' => 'Atestados', 'action' => 'add']) ?>" class="btn btn-warning btn-default pull-right">Novo<div class="ripple-container"></div></a>
                                <?php endif; ?>
                                <?php if ($this->Membership->handleRole("imprimir_atestados")) : ?>
                                    <a href="<?= $this->Url->build(['controller' => 'Atestados', 'action' => 'imprimir', '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                                <?php endif;?>
                            </div>
                            <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if (count($atestados) > 0) :?>
                            <h4 class="card-title">Lista de Atestados</h4>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Funcionário</th>
                                        <th>Data de Emissão</th>
                                        <th>Data de Afastamento</th>
                                        <th>Data de Retorno</th>
                                        <th>CID</th>
                                        <th>INSS</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($atestados as $atestado) : ?>
                                        <tr>
                                            <td><?=$atestado->funcionario->nome?></td>
                                            <td><?=$this->Format->date($atestado->emissao)?></td>
                                            <td><?=$this->Format->date($atestado->afastamento)?></td>
                                            <td><?=$this->Format->date($atestado->retorno)?></td>
                                            <td><?=$atestado->cid?></td>
                                            <td><?=$atestado->afastado?></td>
                                            <td class="td-actions text-right" style="width: 12%">
                                                <?php if ($this->Membership->handleRole("visualizar_atestados")) : ?>
                                                    <a href="<?= $this->Url->build(['controller' => 'Atestados', 'action' => 'view', $atestado->id]) ?>" class="btn btn-info btn-round">
                                                        <i class="material-icons">pageview</i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($this->Membership->handleRole("editar_atestados")) : ?>
                                                    <a href="<?= $this->Url->build(['controller' => 'Atestados', 'action' => 'edit', $atestado->id]) ?>" class="btn btn-primary btn-round">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($this->Membership->handleRole("excluir_atestados")) : ?>
                                                    <button type="button" onclick="excluirAtestado(<?= $atestado->id ?>, '<?= $this->Format->date($atestado->emissao) ?>', '<?=$atestado->funcionario->nome?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <?php if ($this->Membership->handleRole("adicionar_atestados")) : ?>
                                <h3>Nenhum atestado encontrado. Para registrar o novo atestado, <?=$this->Html->link("clique aqui", ["controller" => "Atestados", "action" => "add"])?>.</h3>
                            <?php else :?>
                                <h3>Nenhum atestado encontrado.</h3>
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

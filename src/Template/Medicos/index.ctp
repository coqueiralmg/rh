<?= $this->Html->script('controller/medicos.general.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?= $this->Flash->render() ?>
                        <h4 class="card-title">Buscar</h4>
                         <?php
                         echo $this->Form->create("Medicos", [
                            "url" => [
                                "controller" => "medicos",
                                "action" => "index"
                            ],
                            'type' => 'get',
                            "role" => "form"]);
                        ?>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("nome", "Nome") ?>
                                        <?= $this->Form->text("nome", ["class" => "form-control"]) ?>
                                    <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("crm", "CRM") ?>
                                        <?= $this->Form->text("crm", ["class" => "form-control"]) ?>
                                    <span class="material-input"></span></div>
                                </div>
                            </div>
                            <div class="form-group form-button">
                                <button type="submit" class="btn btn-fill btn-success pull-right">Buscar<div class="ripple-container"></div></button>
                                <?php if ($this->Membership->handleRole("adicionar_medicos")) : ?>
                                    <a href="<?= $this->Url->build(['controller' => 'Medicos', 'action' => 'add']) ?>" class="btn btn-warning btn-default pull-right">Novo<div class="ripple-container"></div></a>
                                <?php endif; ?>
                                <?php if ($this->Membership->handleRole("imprimir_medicos")) : ?>
                                    <a href="<?= $this->Url->build(['controller' => 'Medicos', 'action' => 'imprimir', '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                                <?php endif; ?>
                            </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if (count($medicos) > 0) :?>
                            <h4 class="card-title">Lista de Médicos</h4>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Especialidade</th>
                                        <th>CRM</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($medicos as $medico) : ?>
                                        <tr>
                                            <td><?= $medico->nome ?></td>
                                            <td><?= $medico->especialidade ?></td>
                                            <td><?= $medico->crm ?></td>
                                            <td class="td-actions text-right">
                                                <?php if ($this->Membership->handleRole("visualizar_medicos")) : ?>
                                                    <a href="<?= $this->Url->build(['controller' => 'Medicos', 'action' => 'view', $medico->id]) ?>" class="btn btn-info btn-round">
                                                        <i class="material-icons">pageview</i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($this->Membership->handleRole("editar_medicos")) : ?>
                                                    <a href="<?= $this->Url->build(['controller' => 'Medicos', 'action' => 'edit', $medico->id]) ?>" class="btn btn-primary btn-round">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($this->Membership->handleRole("excluir_medicos")) : ?>
                                                    <button type="button" onclick="excluirRegistro(<?= $medico->id ?>, '<?= $medico->nome ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <?php if ($this->Membership->handleRole("adicionar_medicos")) : ?>
                                <h3>Nenhum médico encontrado. Para registrar o novo médico, <?=$this->Html->link("clique aqui", ["controller" => "Medicos", "action" => "add"])?>.</h3>
                            <?php else :?>
                                <h3>Nenhum médico encontrado.</h3>
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

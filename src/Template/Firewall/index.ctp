<?= $this->Html->script('controller/firewall.lista.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?= $this->Flash->render() ?>
                        <h4 class="card-title">Buscar</h4>
                         <?php
                         echo $this->Form->create("Firewall", [
                            "url" => [
                                "controller" => "firewall",
                                "action" => "index"
                            ],
                            'type' => 'get',
                            "role" => "form"]);
                        ?>
                            <div class="row">
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
                                <?php if ($this->Membership->handleRole("adicionar_ips_firewall")) : ?>
                                    <a href="<?= $this->Url->build(['controller' => 'Firewall', 'action' => 'add']) ?>" class="btn btn-warning btn-default pull-right">Novo<div class="ripple-container"></div></a>
                                <?php endif; ?>
                                <?php if ($this->Membership->handleRole("imprimir_ips_firewall")) : ?>
                                    <a href="<?= $this->Url->build(['controller' => 'Firewall', 'action' => 'imprimir', '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                                <?php endif; ?>
                            </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if (count($firewall) > 0) :?>
                            <h4 class="card-title">Lista de IPs</h4>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Endereço de IP</th>
                                        <th>Data do Cadastro</th>
                                        <th>Lista Branca</th>
                                        <th>Ativo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($firewall as $item) : ?>
                                        <tr>
                                            <td><?= $item->ip ?></td>
                                            <td><?= $this->Format->date($item->data) ?></td>
                                            <td><?= $item->whitelist ?></td>
                                            <td><?= $item->ativado ?></td>
                                            <td class="td-actions text-right">
                                                <?php if ($this->Membership->handleRole("editar_ips_firewall")) : ?>
                                                    <a href="<?= $this->Url->build(['controller' => 'Firewall', 'action' => 'edit', $item->id]) ?>" class="btn btn-primary btn-round">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($this->Membership->handleRole("excluir_ips_firewall")) : ?>
                                                    <button type="button" onclick="excluirRegistro(<?= $item->id ?>, '<?= $item->ip ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <h3>Nenhum item encontrado.</h3>
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

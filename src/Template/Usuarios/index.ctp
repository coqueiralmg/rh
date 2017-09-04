<script type="text/javascript">
    var usuario = <?=$this->request->session()->read('UsuarioID')?>;
</script>
<?= $this->Html->script('controller/usuarios.lista.js', ['block' => 'scriptBottom']) ?>
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
                                "controller" => "usuarios",
                                "action" => "index"
                            ],
                            'type' => 'get',
                            "role" => "form"]);
                        ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("nome", "Nome") ?>
                                        <?= $this->Form->text("nome", ["class" => "form-control"]) ?>
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("usuario", "Usuário") ?>
                                        <?= $this->Form->text("usuario", ["class" => "form-control"]) ?>
                                      <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("email", "E-mail") ?>
                                        <?= $this->Form->text("email", ["class" => "form-control"]) ?>
                                    <span class="material-input"></span></div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("mostrar", "Mostrar") ?> <br/>
                                        <?=$this->Form->select('mostrar', $combo_mostra, ['class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("grupo", "Grupo") ?> <br/>
                                        <?=$this->Form->select('grupo', $grupos, ['empty' => 'Todos', 'class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-button">
                            <button type="submit" class="btn btn-fill btn-success pull-right">Buscar<div class="ripple-container"></div></button>
                            <?php if ($this->Membership->handleRole("adicionar_usuarios")) : ?>
                                <a href="<?= $this->Url->build(['controller' => 'Usuarios', 'action' => 'add']) ?>" class="btn btn-warning btn-default pull-right">Novo<div class="ripple-container"></div></a>
                            <?php endif; ?>
                            <?php if ($this->Membership->handleRole("imprimir_usuarios")) : ?>
                                <a href="<?= $this->Url->build(['controller' => 'Usuarios', 'action' => 'imprimir', '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                            <?php endif; ?>
                            </div>
                            <?php echo $this->Form->end(); ?>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if (count($usuarios) > 0) :?>
                            <h4 class="card-title">Lista de Usuários</h4>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th style="width: 25%">Nome</th>
                                        <th>Usuário</th>
                                        <th>E-mail</th>
                                        <th>Ativo</th>
                                        <th>Grupo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($usuarios as $usuario) : ?>
                                        <tr>
                                            <td style="width: 30%"><?=$usuario->nome?></td>
                                            <td style="width: 15%"><?=$usuario->usuario?></td>
                                            <td style="width: 20%"><?=$usuario->email?></td>
                                            <td><?=$usuario->ativado?></td>
                                            <td><?=$usuario->grupoUsuario->nome?></td>
                                            <td class="td-actions text-right">
                                                <?php if ($this->Membership->handleRole("editar_usuarios")) : ?>
                                                    <a href="<?= $this->Url->build(['controller' => 'Usuarios', 'action' => 'edit', $usuario->id]) ?>" class="btn btn-primary btn-round">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($this->Membership->handleRole("excluir_usuarios")) : ?>
                                                    <button type="button" onclick="excluirUsuario(<?= $usuario->id ?>, '<?= $usuario->nome ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <?php if ($this->Membership->handleRole("adicionar_usuarios")) : ?>
                                <h3>Nenhum usuário encontrado. Para adicionar novo usuário, <?=$this->Html->link("clique aqui", ["controller" => "usuarios", "action" => "add"])?>.</h3>
                            <?php else :?>
                                <h3>Nenhum usuário encontrado.</h3>
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

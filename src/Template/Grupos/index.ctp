<?php
    $usuario = $this->request->session()->read('Usuario');
    $grupo = $usuario->grupo;
?>
<script type="text/javascript">
    var grupoUsuario = <?=$grupo?>;
</script>
<?= $this->Html->script('controller/grupos.lista.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?= $this->Flash->render() ?>
                        <?php if ($this->Membership->handleRole("adicionar_grupos_usuarios")) : ?>
                            <a href="<?= $this->Url->build(['controller' => 'Grupos', 'action' => 'add']) ?>" class="btn btn-fill btn-warning pull-right">Novo<div class="ripple-container"></div></a>
                        <?php endif; ?>
                        <?php if ($this->Membership->handleRole("imprimir_grupos")) : ?>
                            <a href="<?= $this->Url->build(['controller' => 'Grupos', 'action' => 'imprimir']) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <h4 class="card-title">Lista de Grupos de Usuários</h4>
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th style="width: 70%">Nome</th>
                                    <th>Ativo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($grupos as $grupo) : ?>
                                    <tr>
                                        <td><?= $grupo->nome ?></td>
                                        <td><?= $grupo->ativado ?></td>
                                        <td class="td-actions text-right">
                                            <?php if ($this->Membership->handleRole("editar_grupo_usuario")) : ?>
                                                <a href="<?= $this->Url->build(['controller' => 'Grupos', 'action' => 'edit', $grupo->id]) ?>" class="btn btn-primary btn-round">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($this->Membership->handleRole("excluir_grupo_usuario")) : ?>
                                                <button type="button" onclick="excluirGrupoUsuario(<?= $grupo->id ?>, '<?= $grupo->nome ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>   
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        
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

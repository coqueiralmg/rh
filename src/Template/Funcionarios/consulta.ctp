<?= $this->Html->script('controller/funcionarios.general.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                            <?= $this->Flash->render() ?>
                            <legend>Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("matricula", "Matrícula") ?><br/>
                                        <?=$funcionario->matricula?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("nome", "Nome") ?><br/>
                                        <?=$funcionario->nome?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("data_admissao", "Data de Admissão") ?><br/>
                                        <?= $this->Format->date($funcionario->data_admissao)?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("cpf", "CPF") ?><br/>
                                        <?= $this->Format->cpf($funcionario->cpf)?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("pis", "PIS") ?><br/>
                                        <?=$funcionario->pis?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <?= $this->Form->label("area", "Área") ?><br/>
                                        <?=$funcionario->area?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?= $this->Form->label("cargo", "Cargo") ?><br/>
                                        <?=$funcionario->cargo?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?= $this->Form->label("email", "E-mail") ?>
                                        <?=$funcionario->email?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?=$this->Form->label("empresa", "Empresa") ?> <br/>
                                        <?=$funcionario->empresa->nome?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <?= $this->Form->label("tipo", "Tipo") ?> <br/>
                                        <?=$funcionario->tipo->descricao?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">                            
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= $this->Form->label("observacao", "Observação") ?> <br/>
                                        <?=$funcionario->observacao?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Outras Opções</label> <br/>
                                        <div class="togglebutton">
                                                Em estágio probatório: <?=$funcionario->estagio?>
                                            
                                        </div>
                                        <div class="togglebutton">
                                                Ativo: <?=$funcionario->ativado?>
                                        </div>
                                        
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <?php if ($this->Membership->handleRole("imprimir_funcionarios")) : ?>
                                <a href="<?= $this->Url->build(['controller' => 'Funcionarios', 'action' => 'documento', $id]) ?>" class="btn btn-default btn-default pull-right" target="_blank">Imprimir<div class="ripple-container"></div></a>
                            <?php endif; ?>
                            <?php if ($this->Membership->handleRole("excluir_funcionarios")) : ?>
                            <button type="button" onclick="excluirFuncionario(<?= $funcionario->id ?>, '<?= $funcionario->nome ?>')" class="btn btn-danger pull-right">Excluir</button>
                            <?php endif; ?>
                            <?php if ($this->Membership->handleRole("editar_funcionarios")) : ?>
                                <a href="<?= $this->Url->build(['controller' => 'Funcionarios', 'action' => 'edit', $id]) ?>" class="btn btn-primary btn-default pull-right">Editar<div class="ripple-container"></div></a>
                            <?php endif; ?>
                            <button type="button" onclick="window.location='<?= $this->Url->build('/funcionarios') ?>'" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

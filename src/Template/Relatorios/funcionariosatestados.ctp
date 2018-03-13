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
                                <a href="<?= $this->Url->build(['controller' => 'Relatorios', 'action' => 'imprimirfuncionariosatestados', '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                            </div>
                            <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <h4 class="card-title">Relatório</h4>
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
                                <?php while ($item = $relatorio->fetch(PDO::FETCH_OBJ)) : ?>
                                    <tr>
                                        <td><?=$item->matricula?></td>
                                        <td><?=$item->nome?></td>
                                        <td><?=$item->cargo?></td>
                                        <td><?=$item->tipo?></td>
                                        <td><?=$item->empresa?></td>
                                        <td><?=$item->quantidade?></td>
                                        <td class="td-actions text-right" style="width: 6%">
                                            <a href="<?= $this->Url->build(['controller' => 'Relatorios', 'action' => 'atestadosfuncionario', '?' => ['idFuncionario' => $item->id, 'periodo' => $data['mostrar']]]) ?>" title="Ver Atestados" class="btn btn-info btn-round">
                                                <i class="material-icons">content_paste</i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

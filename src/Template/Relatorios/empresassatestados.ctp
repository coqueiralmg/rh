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
                                "action" => "empresassatestados"
                            ],
                            'type' => 'get',
                            "role" => "form"]);
                        ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("mostrar", "Mostrar") ?> <br/>
                                        <?=$this->Form->select('mostrar', $combo_mostra, ['class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group form-button">
                                <button type="submit" onclick="return validar()" class="btn btn-fill btn-success pull-right">Buscar<div class="ripple-container"></div></button>
                                <a href="<?= $this->Url->build(['controller' => 'Relatorios', 'action' => 'imprimirempresassatestados', '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
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
                                    <th>Empresa</th>
                                    <th>Total de Funcionários</th>
                                    <th>Atestados Emitidos</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($item = $relatorio->fetch(PDO::FETCH_OBJ)) : ?>
                                    <tr>
                                        <td><?=$item->nome?></td>
                                        <td><?=$item->funcionarios?></td>
                                        <td><?=$item->atestados?></td>
                                        <td class="td-actions text-right" style="width: 12%">
                                            <a href="<?= $this->Url->build(['controller' => 'Relatorios', 'action' => 'funcionariosempresa', '?' => ['idEmpresa' => $item->id, 'periodo' => $data['mostrar']]]) ?>" title="Ver Funcionários" class="btn btn-info btn-round">
                                                <i class="material-icons">assignment_ind</i>
                                            </a>
                                            <a href="<?= $this->Url->build(['controller' => 'Relatorios', 'action' => 'atestadosempresa', '?' => ['idEmpresa' => $item->id, 'periodo' => $data['mostrar']]]) ?>" title="Ver Atestados" class="btn btn-info btn-round">
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

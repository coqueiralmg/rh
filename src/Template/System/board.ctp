<?= $this->Html->script('controller/system.board.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="orange">
                        <i class="material-icons">assignment_ind</i>
                    </div>
                    <div class="card-content">
                        <p class="category">Funcionários</p>
                        <h3 class="title"><?=$funcionarios?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <?php if ($this->Membership->handleRole("listar_funcionarios")) : ?>
                                <i class="material-icons text-info">content_paste</i> <a href="<?= $this->Url->build(['controller' => 'Funcionarios', 'action' => 'index']) ?>">Ver todos</a>
                            <?php else:?>
                                <i class="material-icons text-info">business</i> Distribuídos entre <?=$empresas?> empresas
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">local_hospital</i>
                    </div>
                    <div class="card-content">
                        <p class="category">Atestados</p>
                        <h3 class="title"><?=$atestados?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">schedule</i> Nos últimos 12 meses
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="red">
                        <i class="material-icons">local_hotel</i>
                    </div>
                    <div class="card-content">
                        <p class="category">Afastados INSS</p>
                        <h3 class="title"><?=$inss?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">schedule</i> Nos últimos 12 meses
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="blue">
                        <i class="material-icons">face</i>
                    </div>
                    <div class="card-content">
                        <p class="category">Médicos</p>
                        <h3 class="title"><?=$medicos?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <?php if ($this->Membership->handleRole("listar_medicos")) : ?>
                                <i class="material-icons text-info">content_paste</i> <a href="<?= $this->Url->build(['controller' => 'Medicos', 'action' => 'index']) ?>">Ver todos</a>
                            <?php else:?>
                                <i class="material-icons text-info">local_hospital</i> Emitentes de  <?=$atestados?> atestados
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="blue">
                        <h4 class="title">Quantidade de Funcionários Por Empresa</h4>
                        <p class="category">Do total de <?=$funcionarios?> funcionários.</p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover">
                            <thead class="text-warning">
                                <th>Empresa</th>
                                <th>Quantidade</th>
                            </thead>
                            <tbody>
                                <?php foreach ($relatorio_funcionarios as $item): ?>
                                    <tr>
                                        <td><?=$item->empresa->nome?></td>
                                        <td><?=$item->quantidade ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="blue">
                        <h4 class="title">Atestados Emitidos por Empresa</h4>
                        <p class="category">Dos últimos 12 meses</p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover">
                        <thead class="text-warning">
                                <th>Empresa</th>
                                <th>Quantidade</th>
                            </thead>
                            <tbody>
                                <?php foreach ($relatorio_atestados as $item): ?>
                                    <tr>
                                        <td><?=$item->nome?></td>
                                        <td><?=$item->quantidade ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-chart" data-background-color="green">
                        <canvas class="ct-chart" id="graficoEvolucao"></canvas>
                    </div>
                    <div class="card-content">
                        <h4 class="title">Evolução dos Atestados</h4>
                        <p class="category">Por data de emissão, nos últimos 12 meses.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="blue">
                        <h4 class="title">Maiores Solicitantes de Atestados</h4>
                        <p class="category">Dos últimos 12 meses</p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover">
                            <thead class="text-warning">
                                <th>Matrícula</th>
                                <th>Empresa</th>
                                <th>Quantidade</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach ($top_funcionarios as $item): ?>
                                    <tr>
                                        <td><?=$item->matricula?></td>
                                        <td><?=$item->nome?></td>
                                        <td><?=$item->quantidade ?></td>
                                        <td class="td-actions text-right">
                                            <?php if ($this->Membership->handleRole("relatorio_funcionario_atestado")) : ?>
                                                <a href="<?= $this->Url->build(['controller' => 'Relatorios', 'action' => 'atestadosfuncionario', '?' => ['idFuncionario' => $item->id, 'periodo' => 12]]) ?>" title="Ver Atestados" class="btn btn-info btn-round">
                                                    <i class="material-icons">content_paste</i>
                                                </a>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right">
                                        <?php if ($this->Membership->handleRole("relatorio_funcionario_atestado")): ?>
                                            <a href="<?= $this->Url->build(['controller' => 'Relatorios', 'action' => 'funcionariosatestados', '?' => ['mostrar' => 12]]) ?>" class="btn btn-default btn-info">Ver Lista Completa</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="blue">
                        <h4 class="title">CIDs mais disgnosticados</h4>
                        <p class="category">Dos últimos 12 meses</p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover">
                        <thead class="text-warning">
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Quantidade</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach ($top_cid as $item): ?>
                                    <tr>
                                        <td><?=$item->codigo?></td>
                                        <td><?=$item->nome?></td>
                                        <td><?=$item->quantidade ?></td>
                                        <td class="td-actions text-right">
                                            <?php if ($this->Membership->handleRole("relatorio_cid")) : ?>
                                                <a href="<?= $this->Url->build(['controller' => 'Relatorios', 'action' => 'cidatestados', $item->codigo, '?' => ['mostrar' => 12]]) ?>" title="Ver Atestados" class="btn btn-info btn-round">
                                                    <i class="material-icons">content_paste</i>
                                                </a>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right">
                                        <?php if ($this->Membership->handleRole("relatorio_cid")): ?>
                                            <a href="<?= $this->Url->build(['controller' => 'Relatorios', 'action' => 'atestadoscid', '?' => ['mostrar' => 12]]) ?>" class="btn btn-default btn-info">Ver Lista Completa</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

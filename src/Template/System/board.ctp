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
                            <i class="material-icons text-info">content_paste</i> <a href="#pablo">Ver todos</a>
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
                            <i class="material-icons text-info">content_paste</i> <a href="#pablo">Ver todos</a>
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
    </div>
</div>

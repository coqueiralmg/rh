<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <h4 class="card-title">Dados Gerais</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">person</i>
                    </div>
                    <div class="card-content">
                        <p class="category">Usuários</p>
                        <h3 class="title"><?=$usuarios?></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="orange">
                        <i class="material-icons">assignment_ind</i>
                    </div>
                    <div class="card-content">
                        <p class="category">Funcionários</p>
                        <h3 class="title"><?=$funcionarios?></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="red">
                        <i class="material-icons">local_hospital</i>
                    </div>
                    <div class="card-content">
                        <p class="category">Atestados</p>
                        <h3 class="title"><?=$atestados?></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="purple">
                        <i class="material-icons">face</i>
                    </div>
                    <div class="card-content">
                        <p class="category">Médicos</p>
                        <h3 class="title"><?=$medicos?></h3>
                    </div>
                </div>
            </div>

            <?php if ($this->Membership->handleRoles("relatorio_funcionario_atestado", "relatorio_empresas_atestado", "relatorio_cid", "relatorios_medicos_atestados")): ?>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-content">
                            <h4 class="card-title">Relatórios</h4>
                        </div>
                    </div>
                </div>

                <?php if ($this->Membership->handleRole("relatorio_funcionario_atestado")) : ?>
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-content">
                                <a href="<?=$this->Url->build([
                                    'controller' => 'relatorios',
                                    'action' => 'funcionariosatestados'
                                ])?>">
                                    <span>
                                        <i class="material-icons" style="font-size: 100px">assignment_ind</i>
                                    </span>
                                    <h4 style="display: inline">Funcionários por Atestados</h4>
                                </a>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <div class="col-md-1">
                                        <i class="material-icons">class</i>
                                    </div>
                                    <div class="col-md-11">
                                        Exibe uma lista de funcionários, juntamente com a quantidade total de atestados médicos emitidos a cada um deles.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($this->Membership->handleRole("relatorio_empresas_atestado")) : ?>
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-content">
                                <a href="<?=$this->Url->build([
                                    'controller' => 'relatorios',
                                    'action' => 'empresassatestados'
                                ])?>">
                                    <span>
                                        <i class="material-icons" style="font-size: 100px">business</i>
                                    </span>
                                    <h4 style="display: inline">Empresas por Atestados</h4>
                                </a>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <div class="col-md-1">
                                        <i class="material-icons">class</i>
                                    </div>
                                    <div class="col-md-11">
                                        Exibe uma lista de empresas, juntamente com a quantidade total de atestados médicos emitidos a cada uma das empresas.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($this->Membership->handleRole("relatorio_cid")) : ?>
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-content">
                                <a href="<?=$this->Url->build([
                                    'controller' => 'relatorios',
                                    'action' => 'atestadoscid'
                                ])?>">
                                    <span>
                                        <i class="material-icons" style="font-size: 100px">grid_on</i>
                                    </span>
                                    <h4 style="display: inline">Atestados por CID</h4>
                                </a>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <div class="col-md-1">
                                        <i class="material-icons">class</i>
                                    </div>
                                    <div class="col-md-11">
                                        Exibe uma lista de CID, juntamente com a quantidade de atestados emitidos para este CID.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($this->Membership->handleRole("relatorios_medicos_atestados")) : ?>
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-content">
                                <a href="<?=$this->Url->build([
                                    'controller' => 'relatorios',
                                    'action' => 'medicoatestado'
                                ])?>">
                                    <span>
                                        <i class="material-icons" style="font-size: 100px">face</i>
                                    </span>
                                    <h4 style="display: inline">Médicos por Atestados Emitidos</h4>
                                </a>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <div class="col-md-1">
                                        <i class="material-icons">class</i>
                                    </div>
                                    <div class="col-md-11">
                                        Exibe uma lista de médicos cadastrados, juntamente com a quantidade de atestados emitidos por ele.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
            <?php endif; ?>
        </div>
    </div>
</div>
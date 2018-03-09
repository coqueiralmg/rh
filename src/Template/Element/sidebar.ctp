<div class="sidebar" data-background-color="white" data-color="blue">
    <div class="logo">
        <center>
            <?= $this->Html->image('brasao_coqueiral.png', ['class' => 'img-responsive', 'width' => '100px;', 'title' => 'Prefeitura Municipal de Coqueiral', 'alt' => 'Prefeitura Municipal de Coqueiral', 'url' => ['controller' => 'System', 'action' => 'board']]); ?>
        </center>
        <?= $this->Html->link('Recursos Humanos', ['controller' => 'System', 'action' => 'board'], ['class' => 'simple-text']) ?>
    </div>

    <div class="user">

        <div class="info">
            <a data-toggle="collapse" href="#collapseExample" class="collapsed" aria-expanded="false">
                <i class="material-icons">assignment_ind</i> 
                 <?=$this->request->session()->read('UsuarioNome')?>
                <b class="caret"></b>
            </a>
            <div class="collapse" id="collapseExample" aria-expanded="false" style="height: auto;">
                <ul class="nav">
                    <li>
                        <a href="<?= $this->Url->build(['controller' => 'perfil', 'action' => 'index']) ?>">Perfil</a>
                    </li>
                    <li>
                        <a href="<?= $this->Url->build(['controller' => 'log', 'action' => 'index']) ?>">Log de Acesso</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="sidebar-wrapper">
        <ul class="nav">
            <?php if ($this->Membership->handleMenu("painel")) : ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'system', 'action' => 'board']) ?>">
                    <a href="<?= $this->Url->build(['controller' => 'system', 'action' => 'board']) ?>">
                        <i class="material-icons">dashboard</i>
                        <p>Início</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("usuarios")) : ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'usuarios']) ?>">
                    <a href="<?= $this->Url->build('/usuarios') ?>">
                        <i class="material-icons">person</i>
                        <p>Usuários</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("grupo_usuarios")) : ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'grupos']) ?>">
                    <a href="<?= $this->Url->build('/grupos') ?>">
                        <i class="material-icons">group_work</i>
                        <p>Grupo de Usuários</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("firewall")) : ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'firewall']) ?>">
                    <a href="<?= $this->Url->build(['controller' => 'firewall', 'action' => 'index']) ?>">
                        <i class="material-icons">security</i>
                        <p>Firewall</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("funcionarios")) : ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'funcionarios']) ?>">
                    <a href="<?= $this->Url->build('/funcionarios') ?>">
                        <i class="material-icons">work</i>
                        <p>Funcionários</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("atestados")) : ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'atestados']) ?>">
                    <a href="<?= $this->Url->build('/atestados') ?>">
                        <i class="material-icons">local_hospital</i>
                        <p>Atestados</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("medicos")) : ?>
                 <li class="<?= $this->Menu->activeMenu(['controller' => 'medicos']) ?>">
                    <a href="<?= $this->Url->build('/medicos') ?>">
                        <i class="material-icons">face</i>
                        <p>Médicos</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("cid")) : ?>
                 <li class="<?= $this->Menu->activeMenu(['controller' => 'cid']) ?>">
                    <a href="<?= $this->Url->build('/cid') ?>">
                        <i class="material-icons">grid_on</i>
                        <p>CID</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("relatorios")) : ?>
                 <li class="<?= $this->Menu->activeMenu(['controller' => 'relatorios']) ?>">
                    <a href="<?= $this->Url->build('/relatorios') ?>">
                        <i class="material-icons">library_books</i>
                        <p>Relatorios</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("auditoria")): ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'auditoria']) ?>">
                    <a href="<?= $this->Url->build('/auditoria') ?>">
                    <i class="material-icons">fingerprint</i>
                        <p>Auditoria</p>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>

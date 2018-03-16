<!doctype html>
<html lang="pt">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<title>
        <?php
        if (isset($title)) {
            echo $title . " | " . $this->Data->setting('System.name');
        } else {
            echo $this->Data->setting('System.name');
        }
        ?>
    </title>

    <!-- Bootstrap core CSS     -->
    <?= $this->Html->css('bootstrap.min.css') ?>
    <!--  Material Dashboard CSS    -->
    <?= $this->Html->css('material-dashboard.css') ?>

    <!-- Bootstrap DatePicker -->
    <?= $this->Html->css('bootstrap-datepicker.css') ?>

    <!-- JQuey -->
    <?= $this->Html->css('jquery-ui.css') ?>
    <?= $this->Html->css('jquery-ui.structure.css') ?>
    <?= $this->Html->css('jquery-ui.theme.css') ?>

    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>

    <?= $this->Html->script('jquery-3.1.0.min.js') ?>
    <?= $this->Html->script('jquery-ui.min.js') ?>
    <?= $this->Html->script('bootstrap.min.js') ?>
    <?= $this->Html->script('material.min.js') ?>
    <?= $this->Html->script('bootstrap-notify.js') ?>
    <?= $this->Html->script('bootstrap-datepicker.min.js') ?>
    <?= $this->Html->script('locales/bootstrap-datepicker.pt-BR.min.js') ?>
    <?= $this->Html->script('jquery.mask.min.js') ?>
    <?= $this->Html->script('ckeditor/ckeditor.js') ?>
    <?= $this->Html->script('utils.js') ?>
</head>

<body>
    <div class="wrapper">
        
        <?= $this->element('sidebar') ?>

        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"><i class="material-icons"><?=$icon?></i> <?=$title?></a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <?php if ($ultimo_acesso == null) : ?>
                                    <a href="#">
                                        <i class="material-icons">info</i>Este é o seu primeiro acesso ao sistema
                                    </a>    
                                <?php else : ?>
                                <a href="<?= $this->Url->build(['controller' => 'log', 'action' => 'index']) ?>">
                                    <i class="material-icons">info</i>Último acesso: <?= $this->Format->date($ultimo_acesso, true) ?>
                                </a>
                                <?php endif; ?>
                            </li>

                            <li>
                                <a href="#" class="dropdown-toggle center" data-toggle="dropdown">
                                   <i class="material-icons">schedule</i><span id="hora_atual"> Carregando a Hora Corrente</span>
                                </a>
                            </li>

                            <li>
                                <a href="<?= $this->Url->build(['controller' => 'system', 'action' => 'logoff']) ?>" >
                                   <i class="material-icons">power_settings_new</i> Sair
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
            </nav>

                <?= $this->fetch('content') ?>

            <footer class="footer">
                <div class="container-fluid">
                    <p class="copyright pull-left">
                        Versão <?= $this->Data->setting('System.version') ?>
                    </p>
                    <p class="copyright pull-right">
                        &copy; <?= $this->Data->release() ?> <?= $this->Data->setting('Author.name') ?>. Todos os Direitos Reservados.
                    </p>
                </div>
            </footer>
        </div>
    </div>
    <?= $this->Html->script('material-dashboard.js') ?>
    <?= $this->Html->script('default.js') ?>    
    <?= $this->fetch('scriptBottom') ?>
</body>
    
</html>

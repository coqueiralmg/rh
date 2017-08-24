<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <title>
        <?php
            if(isset($title))
            {
                echo $title . " | " . $this->Data->setting('System.name');
            }
            else
            {
                echo $this->Data->setting('System.name');
            }
        ?>
    </title>
   
    <!-- Bootstrap core CSS     -->
    <?= $this->Html->css('bootstrap.min.css') ?>
    <!--  Material Dashboard CSS    -->
    <?= $this->Html->css('material-dashboard.css') ?>
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <?= $this->Html->css('demo.css') ?>
    <!--  Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />
</head>

<body>
    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page">
            <?= $this->fetch('content') ?>
        </div>
    </div>

    <?= $this->Html->script('jquery-3.1.0.min.js') ?>
    <?= $this->Html->script('bootstrap.min.js') ?>
    <?= $this->Html->script('material.min.js') ?>
    <?= $this->Html->script('chartlist.min.js') ?>
    <?= $this->Html->script('bootstrap-notify.js') ?>
    <?= $this->Html->script('material-dashboard.js') ?>
    <?= $this->Html->script('demo.js') ?>
    <?= $this->fetch('scriptBottom') ?>
</body>

</html>
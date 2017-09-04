<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html>
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
            <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                <form id="form_login">
                    <div class="card card-login card-hidden">
                        <div class="card-header text-center" data-background-color="red">
                            <h4 class="card-title">Erro</h4>
                        </div>
                        <div class="card-content">
                            <?= $this->Flash->render() ?>

                            <?= $this->fetch('content') ?>
                        </div>
                        <div class="footer text-center">
                            <?= $this->Html->link('Voltar', 'javascript:history.back()', ['class' => 'btn btn-danger btn-simple btn-wd btn-lg']) ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

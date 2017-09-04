<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = 'error';

if (Configure::read('debug')):
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error400.ctp');

    $this->start('file');
?>
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
<?php endif; ?>
<?= $this->element('auto_table_warning') ?>
<?php
    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;
?>
<h4><?= h($message) ?></h4>
<p class="error">
    <?php if($message == 'Forbidden'): ?>
    <strong>Erro: </strong>
    <?= __d('cake', 'Você não tem permissão para acessar este endereço {0}.', "<strong>'{$url}'</strong>") ?>
    <?php elseif($message == 'Not Found'):?>
    <strong>Erro: </strong>
    <?= __d('cake', 'O endereço requisitado {0} não foi encontrado em nosso servidor.', "<strong>'{$url}'</strong>") ?>
    <?php endif;?>
    
</p>

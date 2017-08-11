<div class="alert alert-danger alert-with-icon" data-notify="container">
    <i class="material-icons" data-notify="icon">error</i>
    <button type="button" aria-hidden="true" class="close" onclick="$(this).parent().hide()">
        <i class="material-icons">close</i>
    </button>
     <?php if(isset($params['details'])): ?>
        <span data-notify="message">
            <?= h($message) ?>
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="$('#detalhes_erro').toggle('blind');">Detalhes</a>
        </span>
        <div id="detalhes_erro" class="detalhes">
            <?= h($params['details']) ?>
        </div>
    <?php else: ?>
        <span data-notify="message">
            <?= h($message) ?>
        </span>
    <?php endif; ?>
</div>
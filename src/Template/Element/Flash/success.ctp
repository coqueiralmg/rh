<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="text-success" onclick="this.classList.add('hidden')"><?= $message ?></div>

<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="text-danger" onclick="this.classList.add('hidden');"><?= $message ?></div>

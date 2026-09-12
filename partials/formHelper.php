<?php
if (!isset($_SESSION['csrf'])) { $_SESSION['csrf']=bin2hex(random_bytes(16)); }
function h($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function formToken() { echo '<input type="hidden" name="csrf" value="'.h($_SESSION['csrf']).'">'; }
if ($_SERVER['REQUEST_METHOD']=='POST' && !hash_equals($_SESSION['csrf'], $_POST['csrf'] ?? '')) {
    http_response_code(403); die("Please reload the page and try again.");
}

?>

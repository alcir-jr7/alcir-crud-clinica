<?php
session_start();

// Encerra a sessão atual
session_destroy();

// Redireciona para a página de login
header('Location: user-login.php');
exit();
?>

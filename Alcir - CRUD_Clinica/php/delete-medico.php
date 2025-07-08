<?php
require_once 'db.php';
require_once 'authenticate.php';

$id = $_GET['id'];

// Deleta o médico pelo ID
$stmt = $pdo->prepare("DELETE FROM medicos WHERE id = ?");
$stmt->execute([$id]);

// Redireciona para a lista de médicos
header('Location: index-medico.php');
exit();
?>

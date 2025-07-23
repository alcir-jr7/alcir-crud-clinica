<?php
require_once 'db.php';
require_once 'authenticate.php';

$id = $_GET['id'];

// Prepara a instrução SQL para excluir o paciente pelo ID
$stmt = $pdo->prepare("DELETE FROM pacientes WHERE id = ?");
$stmt->execute([$id]);

// Redireciona para a lista de pacientes após a exclusão
header('Location: index-paciente.php');
exit();
?>

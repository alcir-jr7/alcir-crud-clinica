<?php
require_once 'db.php';
require_once 'authenticate.php';

$id_medico = $_GET['id_medico'] ?? null;
$id_paciente = $_GET['id_paciente'] ?? null;
$data_hora = $_GET['data_hora'] ?? null;

if (!$id_medico || !$id_paciente || !$data_hora) {
    die('Parâmetros inválidos.');
}

// Deleta a consulta pela chave composta
$stmt = $pdo->prepare("
    DELETE FROM consultas
    WHERE id_medico = ? AND id_paciente = ? AND data_hora = ?
");
$stmt->execute([$id_medico, $id_paciente, $data_hora]);

header('Location: index-consulta.php');
exit();

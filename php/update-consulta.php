<?php
require_once 'db.php';
require_once 'authenticate.php';

$id_medico = $_GET['id_medico'] ?? null;
$id_paciente = $_GET['id_paciente'] ?? null;
$data_hora_original = $_GET['data_hora'] ?? null;

if (!$id_medico || !$id_paciente || !$data_hora_original) {
    die('Parâmetros inválidos.');
}

// Buscar dados da consulta para preencher o formulário
$stmt = $pdo->prepare("
    SELECT c.*, m.nome AS nome_medico, p.nome AS nome_paciente
    FROM consultas c
    JOIN medicos m ON c.id_medico = m.id
    JOIN pacientes p ON c.id_paciente = p.id
    WHERE c.id_medico = ? AND c.id_paciente = ? AND c.data_hora = ?
");
$stmt->execute([$id_medico, $id_paciente, $data_hora_original]);
$consulta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$consulta) {
    die('Consulta não encontrada.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data_hora = $_POST['data_hora'];
    $observacoes = $_POST['observacoes'];

    // Atualiza a consulta (data_hora e observacoes)
    // Atenção: a data_hora pode ser alterada, então temos que usar a chave antiga para localizar o registro.
    $stmt = $pdo->prepare("
        UPDATE consultas
        SET data_hora = ?, observacoes = ?
        WHERE id_medico = ? AND id_paciente = ? AND data_hora = ?
    ");
    $stmt->execute([$data_hora, $observacoes, $id_medico, $id_paciente, $data_hora_original]);

    header('Location: read-consulta.php?id_medico=' . $id_medico . '&id_paciente=' . $id_paciente . '&data_hora=' . urlencode($data_hora));
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editar Consulta</title>
    <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
<header>
    <h1>Editar Consulta</h1>
    <nav>
        <ul>
            <li><a href="/index.php">Home</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li>Pacientes: 
                    <a href="/php/create-paciente.php">Adicionar</a> | 
                    <a href="/php/index-paciente.php">Listar</a>
                </li>
                <li>Médicos: 
                    <a href="/php/create-medico.php">Adicionar</a> | 
                    <a href="/php/index-medico.php">Listar</a>
                </li>
                <li>Consultas: 
                    <a href="/php/create-consulta.php">Adicionar</a> | 
                    <a href="/php/index-consulta.php">Listar</a>
                </li>
                <li><a href="/php/logout.php">Logout (<?= $_SESSION['username'] ?>)</a></li>
            <?php else: ?>
                <li><a href="/php/user-login.php">Login</a></li>
                <li><a href="/php/user-register.php">Registrar</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<main>
    <form method="POST">
        <p><strong>Médico:</strong> <?= htmlspecialchars($consulta['nome_medico']) ?></p>
        <p><strong>Paciente:</strong> <?= htmlspecialchars($consulta['nome_paciente']) ?></p>

        <label for="data_hora">Data e Hora:</label>
        <input 
            type="datetime-local" 
            id="data_hora" 
            name="data_hora" 
            value="<?= date('Y-m-d\TH:i', strtotime($consulta['data_hora'])) ?>" 
            required
        />

        <label for="observacoes">Observações:</label>
        <textarea id="observacoes" name="observacoes"><?= htmlspecialchars($consulta['observacoes']) ?></textarea>

        <button type="submit">Atualizar</button>
    </form>
</main>
</body>
</html>

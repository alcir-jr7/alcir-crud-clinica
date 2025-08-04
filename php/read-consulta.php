<?php
require_once 'db.php';
require_once 'authenticate.php';

$id_medico = $_GET['id_medico'] ?? null;
$id_paciente = $_GET['id_paciente'] ?? null;
$data_hora = $_GET['data_hora'] ?? null;

if (!$id_medico || !$id_paciente || !$data_hora) {
    die('Parâmetros inválidos.');
}

// Buscar consulta com JOIN para pegar nomes de médico e paciente
$stmt = $pdo->prepare("
    SELECT c.*, m.nome AS nome_medico, p.nome AS nome_paciente
    FROM consultas c
    JOIN medicos m ON c.id_medico = m.id
    JOIN pacientes p ON c.id_paciente = p.id
    WHERE c.id_medico = ? AND c.id_paciente = ? AND c.data_hora = ?
");
$stmt->execute([$id_medico, $id_paciente, $data_hora]);
$consulta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$consulta) {
    die('Consulta não encontrada.');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detalhes da Consulta</title>
    <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
<header>
    <h1>Detalhes da Consulta</h1>
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
    <p><strong>Médico:</strong> <?= htmlspecialchars($consulta['nome_medico']) ?></p>
    <p><strong>Paciente:</strong> <?= htmlspecialchars($consulta['nome_paciente']) ?></p>
    <p><strong>Data e Hora:</strong> <?= date('d/m/Y H:i', strtotime($consulta['data_hora'])) ?></p>
    <p><strong>Observações:</strong> <?= nl2br(htmlspecialchars($consulta['observacoes'])) ?></p>

    <p>
        <a href="update-consulta.php?id_medico=<?= $consulta['id_medico'] ?>&id_paciente=<?= $consulta['id_paciente'] ?>&data_hora=<?= urlencode($consulta['data_hora']) ?>">Editar</a> |
        <a href="delete-consulta.php?id_medico=<?= $consulta['id_medico'] ?>&id_paciente=<?= $consulta['id_paciente'] ?>&data_hora=<?= urlencode($consulta['data_hora']) ?>" onclick="return confirm('Tem certeza que deseja excluir esta consulta?');">Excluir</a> |
        <a href="index-consulta.php">Voltar</a>
    </p>
</main>
</body>
</html>

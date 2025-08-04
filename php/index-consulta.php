<?php
require_once 'db.php';
require_once 'authenticate.php';

// Consulta todas as consultas juntando médico e paciente para exibir dados amigáveis
$stmt = $pdo->query("
    SELECT c.id_medico, c.id_paciente, c.data_hora, c.observacoes, 
           m.nome AS nome_medico, p.nome AS nome_paciente
    FROM consultas c
    JOIN medicos m ON c.id_medico = m.id
    JOIN pacientes p ON c.id_paciente = p.id
    ORDER BY c.data_hora DESC
");
$consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Consultas</title>
    <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
<header>
    <h1>Lista de Consultas</h1>
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
    <table>
        <thead>
            <tr>
                <th>Médico</th>
                <th>Paciente</th>
                <th>Data e Hora</th>
                <th>Observações</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($consultas as $consulta): ?>
                <tr>
                    <td><?= htmlspecialchars($consulta['nome_medico']) ?></td>
                    <td><?= htmlspecialchars($consulta['nome_paciente']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($consulta['data_hora'])) ?></td>
                    <td><?= nl2br(htmlspecialchars($consulta['observacoes'])) ?></td>
                    <td>
                        <a href="read-consulta.php?id_medico=<?= $consulta['id_medico'] ?>&id_paciente=<?= $consulta['id_paciente'] ?>&data_hora=<?= urlencode($consulta['data_hora']) ?>">Visualizar</a> |
                        <a href="update-consulta.php?id_medico=<?= $consulta['id_medico'] ?>&id_paciente=<?= $consulta['id_paciente'] ?>&data_hora=<?= urlencode($consulta['data_hora']) ?>">Editar</a> |
                        <a href="delete-consulta.php?id_medico=<?= $consulta['id_medico'] ?>&id_paciente=<?= $consulta['id_paciente'] ?>&data_hora=<?= urlencode($consulta['data_hora']) ?>" onclick="return confirm('Tem certeza que deseja excluir esta consulta?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
</body>
</html>

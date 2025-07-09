<?php
require_once 'db.php';
require_once 'authenticate.php';

$id = $_GET['id'];

// Seleciona o paciente pelo ID
$stmt = $pdo->prepare("SELECT pacientes.*, usuarios.username FROM pacientes LEFT JOIN usuarios ON pacientes.usuario_id = usuarios.id WHERE pacientes.id = ?");
$stmt->execute([$id]);
$paciente = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detalhes do Paciente</title>
    <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
    <header>
        <h1>Detalhes do Paciente</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
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
        <?php if ($paciente): ?>
            <p><strong>ID:</strong> <?= $paciente['id'] ?></p>
            <p><strong>Nome:</strong> <?= htmlspecialchars($paciente['nome']) ?></p>
            <p><strong>Data de Nascimento:</strong> <?= $paciente['data_nascimento'] ?></p>
            <p><strong>Tipo Sanguíneo:</strong> <?= htmlspecialchars($paciente['tipo_sanguineo']) ?></p>
            <p><strong>Usuário Associado:</strong> <?= htmlspecialchars($paciente['username']) ?></p>
            <p>
                <a href="update-paciente.php?id=<?= $paciente['id'] ?>">Editar</a>
                <a href="delete-paciente.php?id=<?= $paciente['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este paciente?');">Excluir</a>
            </p>
        <?php else: ?>
            <p>Paciente não encontrado.</p>
        <?php endif; ?>
    </main>
</body>
</html>

<?php
require_once 'db.php';
require_once 'authenticate.php';

// Busca todos os pacientes
$stmt = $pdo->query("SELECT * FROM pacientes");
$pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Pacientes</title>
    <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
    <header>
        <h1>Bem-vindo ao Sistema de Gerenciamento de Pacientes</h1>
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
        <h2>Lista de Pacientes</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Data de Nascimento</th>
                    <th>Tipo Sanguíneo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pacientes as $paciente): ?>
                    <tr>
                        <td><?= $paciente['id'] ?></td>
                        <td><?= htmlspecialchars($paciente['nome']) ?></td>
                        <td><?= $paciente['data_nascimento'] ?></td>
                        <td><?= htmlspecialchars($paciente['tipo_sanguineo']) ?></td>
                        <td>
                            <a href="read-paciente.php?id=<?= $paciente['id'] ?>">Visualizar</a>
                            <a href="update-paciente.php?id=<?= $paciente['id'] ?>">Editar</a>
                            <a href="delete-paciente.php?id=<?= $paciente['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este paciente?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>&copy; 2024 - Sistema de Gerenciamento de Pacientes</p>
    </footer>
</body>
</html>

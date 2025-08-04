<?php
require_once 'db.php';
require_once 'authenticate.php';

$id = $_GET['id'];

// Seleciona o paciente específico pelo ID
$stmt = $pdo->prepare("SELECT * FROM pacientes WHERE id = ?");
$stmt->execute([$id]);
$paciente = $stmt->fetch(PDO::FETCH_ASSOC);

// Obter todos os usuários para associar ao paciente
$stmt = $pdo->query("SELECT id, username FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $tipo_sanguineo = $_POST['tipo_sanguineo'];
    $usuario_id = $_POST['usuario_id'];

    // Atualiza o paciente no banco de dados
    $stmt = $pdo->prepare("UPDATE pacientes SET nome = ?, data_nascimento = ?, tipo_sanguineo = ?, usuario_id = ? WHERE id = ?");
    $stmt->execute([$nome, $data_nascimento, $tipo_sanguineo, $usuario_id, $id]);

    header('Location: read-paciente.php?id=' . $id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editar Paciente</title>
    <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
    <header>
        <h1>Editar Paciente</h1>
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
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($paciente['nome']) ?>" required />

            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" id="data_nascimento" name="data_nascimento" value="<?= $paciente['data_nascimento'] ?>" required />

            <label for="tipo_sanguineo">Tipo Sanguíneo:</label>
            <input type="text" id="tipo_sanguineo" name="tipo_sanguineo" value="<?= htmlspecialchars($paciente['tipo_sanguineo']) ?>" maxlength="3" required />

            <label for="usuario_id">Usuário:</label>
            <select id="usuario_id" name="usuario_id" required>
                <option value="">Selecione o usuário</option>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= $usuario['id'] ?>" <?= $usuario['id'] == $paciente['usuario_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($usuario['username']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Atualizar</button>
        </form>
    </main>
</body>
</html>

<?php
require_once 'db.php';
require_once 'authenticate.php';

// Obter todos os usuários para associar ao paciente
$stmt = $pdo->query("SELECT id, username FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $tipo_sanguineo = $_POST['tipo_sanguineo'];
    $usuario_id = $_POST['usuario_id'];

    // Insere o novo paciente no banco de dados
    $stmt = $pdo->prepare("INSERT INTO pacientes (nome, data_nascimento, tipo_sanguineo, usuario_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $data_nascimento, $tipo_sanguineo, $usuario_id]);

    header('Location: index-paciente.php');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Adicionar Paciente</title>
    <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
    <header>
        <h1>Adicionar Paciente</h1>
    </header>
    <main>
        <form method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required />

            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" id="data_nascimento" name="data_nascimento" required />

            <label for="tipo_sanguineo">Tipo Sanguíneo:</label>
            <input type="text" id="tipo_sanguineo" name="tipo_sanguineo" required maxlength="3" />

            <label for="usuario_id">Usuário:</label>
            <select id="usuario_id" name="usuario_id" required>
                <option value="">Selecione o usuário</option>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= $usuario['id'] ?>"><?= htmlspecialchars($usuario['username']) ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Adicionar</button>
        </form>
    </main>
</body>
</html>

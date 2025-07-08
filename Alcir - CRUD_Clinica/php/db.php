<?php
// Define as variáveis de conexão ao banco de dados MySQL
$host = 'localhost:3306'; // Endereço do servidor MySQL e a porta utilizada
$db = 'sistema_clinica';  // Nome do banco de dados atualizado
$user = 'root';           // Usuário do banco de dados
$pass = '1234';           // Senha do usuário do banco de dados

try {
    // Cria uma nova instância de PDO para a conexão com o banco de dados, já com charset UTF-8
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);

    // Configura o PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
}
?>

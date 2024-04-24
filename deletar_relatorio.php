<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit;
}

// Verifica se o ID do relatório foi fornecido via GET
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

// Obtém o ID do relatório a ser deletado
$id_relatorio = $_GET['id'];

// Conexão com o banco de dados (substitua pelos seus dados de conexão)
$conn = new mysqli("localhost", "root", "", "SegurancaDB");

// Verifica se a conexão foi estabelecida com sucesso
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Query para excluir o relatório da tabela
$query = "DELETE FROM RelatoriosDespesas WHERE id=$id_relatorio";

if ($conn->query($query) === TRUE) {
    // Redireciona de volta para a página de dashboard após a deleção
    header("Location: dashboard.php");
} else {
    echo "Erro ao deletar o relatório: " . $conn->error;
}

$conn->close();
?>

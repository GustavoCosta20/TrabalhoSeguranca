<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: login.html"); // Redireciona para a página de login se não estiver logado
    exit;
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os campos obrigatórios foram preenchidos
    if (!empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['senha']) && !empty($_POST['cargo'])) {
        // Obtém os dados do formulário
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $cargo = $_POST['cargo'];

        // Conexão com o banco de dados (substitua pelos seus dados de conexão)
        $conn = new mysqli("localhost", "root", "", "SegurancaDB");

        // Verifica se a conexão foi estabelecida com sucesso
        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }

        // Query para inserir o novo funcionário no banco de dados
        $query = "INSERT INTO Funcionarios (nome, email, senha, cargo) VALUES ('$nome', '$email', '$senha', '$cargo')";

        if ($conn->query($query) === TRUE) {
            // Redireciona de volta para a página de relatórios pendentes após o cadastro ser concluído
            header("Location: relatorios_pendentes.php");
            exit;
        } else {
            echo "Erro ao cadastrar o funcionário: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Por favor, preencha todos os campos.";
    }
} else {
    // Se o formulário não foi submetido, redireciona de volta para a página de cadastro
    header("Location: cadastrar_novo_funcionario.php");
    exit;
}
?>

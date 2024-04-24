<?php
// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os campos foram preenchidos
    if (!empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['cargo']) && !empty($_POST['senha'])) {
        // Aqui você deve implementar a lógica para inserir os dados do novo funcionário no banco de dados
        // Por exemplo:
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cargo = $_POST['cargo'];
        $senha = $_POST['senha'];

        // Conexão com o banco de dados (substitua pelos seus dados de conexão)
        $conn = new mysqli("localhost", "root", "", "SegurancaDB");

        // Verifica se a conexão foi estabelecida com sucesso
        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }

        // Query para inserir um novo funcionário
        $query = "INSERT INTO Funcionarios (nome, email, cargo, senha) VALUES ('$nome', '$email', '$cargo', '$senha')";

        if ($conn->query($query) === TRUE) {
            // Funcionário cadastrado com sucesso
            header("Location: login.html");
        } else {
            // Erro ao cadastrar funcionário
            echo "Erro ao cadastrar funcionário: " . $conn->error;
        }

        $conn->close();
    } else {
        // Campos não preenchidos
        echo "Por favor, preencha todos os campos.";
    }
}
?>

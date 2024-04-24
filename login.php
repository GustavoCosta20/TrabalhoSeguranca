<?php
session_start();

$error_message = "";

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os campos foram preenchidos
    if (!empty($_POST['email']) && !empty($_POST['senha'])) {
        // Aqui você deve implementar a lógica para autenticar o usuário e verificar as credenciais no banco de dados
        // Por exemplo:
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Conexão com o banco de dados (substitua pelos seus dados de conexão)
        $conn = new mysqli("localhost", "root", "", "SegurancaDB");

        // Verifica se a conexão foi estabelecida com sucesso
        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }

        // Query para verificar se o usuário existe e as credenciais estão corretas
        $query = "SELECT * FROM Funcionarios WHERE email='$email' AND senha='$senha'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // Usuário autenticado com sucesso
            $row = $result->fetch_assoc();
            $_SESSION['email'] = $email;
            if ($row['cargo'] == 'Gestor' || $row['cargo'] == 'Gerente' || $row['cargo'] == 'Diretor' ||
                $row['cargo'] == 'gestor' || $row['cargo'] == 'gerente' || $row['cargo'] == 'diretor') {
                header("Location: relatorios_pendentes.php"); // Redireciona para a página de relatórios pendentes
            } else {
                header("Location: dashboard.php"); // Redireciona para a página principal após o login
            }
            exit; // Termina a execução do script para evitar que o código abaixo seja executado
        } else {
            // Usuário ou senha incorretos
            $error_message = "E-mail ou senha incorretos. Tente novamente.";
        }

        $conn->close();
    } else {
        // Campos não preenchidos
        $error_message = "Por favor, preencha todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form id="login-form" action="login.php" method="POST">
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
        <?php if (!empty($error_message)) { ?>
            <p><?php echo $error_message; ?></p>
        <?php } ?>
        <p>Não tem uma conta? <a href="cadastro_funcionario.html">Cadastre-se</a></p>
    </div>
</body>
</html>

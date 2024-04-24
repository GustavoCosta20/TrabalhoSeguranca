<?php
// Verifica se o usuário está logado
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html"); // Redireciona para a página de login se não estiver logado
    exit;
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Aqui você deve implementar a lógica para criar o novo relatório de despesas no banco de dados
    // Por exemplo:
    $data = $_POST['data'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $status = 'pendente'; // Define o status como pendente por padrão

    // Verifica se um arquivo PDF foi enviado
    if (isset($_FILES['arquivo_pdf'])) {
        $arquivo_pdf_nome = $_FILES['arquivo_pdf']['name'];
        $arquivo_pdf_tmp = $_FILES['arquivo_pdf']['tmp_name'];
        $arquivo_pdf_destino = "uploads/" . $arquivo_pdf_nome; // Define o diretório de destino para salvar o arquivo PDF

        // Move o arquivo PDF para o diretório de destino
        if (move_uploaded_file($arquivo_pdf_tmp, $arquivo_pdf_destino)) {
            // Arquivo PDF movido com sucesso
            // Conexão com o banco de dados (substitua pelos seus dados de conexão)
            $conn = new mysqli("localhost", "root", "", "SegurancaDB");

            // Verifica se a conexão foi estabelecida com sucesso
            if ($conn->connect_error) {
                die("Erro de conexão: " . $conn->connect_error);
            }

            // Obtém o ID do funcionário logado
            $email = $_SESSION['email'];
            $query = "SELECT id FROM Funcionarios WHERE email='$email'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $funcionario_id = $row['id'];

                // Query para inserir o novo relatório de despesas
                $query = "INSERT INTO RelatoriosDespesas (funcionario_id, data, descricao, valor, arquivo_pdf, status) VALUES ($funcionario_id, '$data', '$descricao', $valor, '$arquivo_pdf_destino', '$status')";
                if ($conn->query($query) === TRUE) {
                    // Redireciona de volta para o dashboard após a criação do relatório
                    header("Location: dashboard.php");
                    exit;
                } else {
                    echo "Erro ao criar o relatório: " . $conn->error;
                }
            }

            $conn->close();
        } else {
            echo "Erro ao fazer o upload do arquivo PDF.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Relatório</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="criar-relatorio-container">
        <h2>Criar Novo Relatório de Despesas</h2>
        <form id="criar-relatorio-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
            <label for="data">Data:</label>
            <input type="date" id="data" name="data" required>
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="4" required></textarea>
            <label for="valor">Valor:</label>
            <input type="number" id="valor" name="valor" step="0.01" min="0" required>
            <label for="arquivo_pdf">Arquivo PDF:</label>
            <input type="file" id="arquivo_pdf" name="arquivo_pdf" accept="application/pdf" required>
            <button type="submit">Criar Relatório</button>
        </form>
    </div>
</body>
</html>

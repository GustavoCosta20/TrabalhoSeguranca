<?php
// Verifica se o formulário foi submetido via método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os campos obrigatórios foram preenchidos
    if (isset($_POST['id_relatorio']) && isset($_POST['data']) && isset($_POST['descricao']) && isset($_POST['valor'])) {
        // Recebe e sanitiza os dados do formulário
        $id_relatorio = $_POST['id_relatorio'];
        $data = $_POST['data'];
        $descricao = $_POST['descricao'];
        $valor = $_POST['valor'];
        
        // Verifica se foi feito upload de um novo arquivo PDF
        if (!empty($_FILES['pdf']['name'])) {
            // Define o diretório de destino para o upload
            $diretorio_destino = "uploads/";
            $nome_arquivo = basename($_FILES["pdf"]["name"]);
            $caminho_arquivo = $diretorio_destino . $nome_arquivo;
            
            // Move o arquivo para o diretório de destino
            if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $caminho_arquivo)) {
                // Arquivo movido com sucesso, atualize o nome do arquivo no banco de dados
                $arquivo_pdf = $caminho_arquivo;
            } else {
                // Falha ao mover o arquivo, trate conforme necessário (exibir mensagem de erro, etc.)
            }
        } else {
            // Se nenhum novo arquivo foi enviado, mantenha o valor atual do arquivo PDF no banco de dados
            // Isso é importante para não perder o arquivo anterior se nenhum novo arquivo for enviado no formulário
            $arquivo_pdf = $_POST['arquivo_pdf'];
        }

        // Aqui você precisaria realizar a conexão com o banco de dados e executar a query para atualizar os dados do relatório
        // Substitua os detalhes da conexão com seu banco de dados
        $conn = new mysqli("localhost", "root", "", "SegurancaDB");

        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }

        // Query para atualizar os dados do relatório
        $sql = "UPDATE RelatoriosDespesas SET data = '$data', descricao = '$descricao', valor = '$valor', arquivo_pdf = '$arquivo_pdf' WHERE id = $id_relatorio";

        if ($conn->query($sql) === TRUE) {
            // Redireciona de volta para a página de dashboard após a atualização
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Erro ao atualizar o relatório: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Todos os campos obrigatórios devem ser preenchidos.";
    }
} else {
    echo "Método de requisição inválido.";
}
?>

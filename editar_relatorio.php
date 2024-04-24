<?php
// Verifica se o ID do relatório foi passado via GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID do relatório não fornecido.";
    exit;
}

$id_relatorio = $_GET['id'];

// Aqui você precisa buscar os dados do relatório com base no ID fornecido
// Substitua os detalhes da conexão com seu banco de dados
$conn = new mysqli("localhost", "root", "", "SegurancaDB");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Consulta SQL para buscar os dados do relatório com base no ID
$sql = "SELECT * FROM RelatoriosDespesas WHERE id = $id_relatorio";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Obtém os dados do relatório
    $row = $result->fetch_assoc();
    $data = $row['data'];
    $descricao = $row['descricao'];
    $valor = $row['valor'];
    $arquivo_pdf = $row['arquivo_pdf'];
} else {
    echo "Relatório não encontrado.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Relatório</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="editar-relatorio-container">
        <h2>Editar Relatório de Despesas</h2>
        <form id="editar-relatorio-form" action="processar_edicao.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_relatorio" value="<?php echo $id_relatorio; ?>">
            <label for="data">Data:</label>
            <input type="date" id="data" name="data" value="<?php echo $data; ?>" required>
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="4" required><?php echo $descricao; ?></textarea>
            <label for="valor">Valor:</label>
            <input type="number" id="valor" name="valor" step="0.01" min="0" value="<?php echo $valor; ?>" required>
            <label for="pdf">Arquivo PDF:</label>
            <input type="file" id="pdf" name="pdf">
            <?php if (!empty($arquivo_pdf)): ?>
                <p>Arquivo PDF atual: <?php echo $arquivo_pdf; ?></p>
            <?php endif; ?>
            <button type="submit">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>

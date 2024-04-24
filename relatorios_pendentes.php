<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: login.html"); // Redireciona para a página de login se não estiver logado
    exit;
}

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

    // Query para buscar os relatórios de despesas do funcionário logado
    $query = "SELECT * FROM RelatoriosDespesas WHERE status = 'pendente'";
    $result = $conn->query($query);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Bem-vindo!</h2>
        <div class="crud-funcionarios-container">
    <h3>Gerenciar Funcionários</h3>
    <a href="cadastrar_novo_func.php" class="btn-novo-relatorio">Novo funcionário</a>

    <!-- Listagem de Funcionários -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Cargo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Consulta SQL para recuperar todos os funcionários
            $query = "SELECT * FROM Funcionarios";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nome'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['cargo'] . "</td>";
                    echo "<td>";
                    echo "<a href='editar_funcionario.php?id=" . $row['id'] . "'>Editar</a> | ";
                    echo "<a href='deletar_funcionario.php?id=" . $row['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir este funcionário?\")'>Excluir</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Nenhum funcionário encontrado.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
        <div class="relatorios-container">
            <h3>Relatórios pendentes</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Arquivo PDF</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['data'] . "</td>";
                            echo "<td>" . $row['descricao'] . "</td>";
                            echo "<td>R$ " . number_format($row['valor'], 2, ',', '.') . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td><a href='" . $row['arquivo_pdf'] . "' target='_blank'>Visualizar</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>*Nenhum relatório de despesas encontrado.</td></tr>*";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

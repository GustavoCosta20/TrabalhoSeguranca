<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Novo Funcionário</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="cadastrar-novo-funcionario-container">
        <h2>Cadastrar Novo Funcionário</h2>
        <form action="processar_cadastro_funcionario.php" method="POST">
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <input type="cargo" name="cargo" placeholder="Cargo" required>
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>

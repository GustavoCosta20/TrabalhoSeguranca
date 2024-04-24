# TrabalhoSeguranca

-- Tabela Funcionários
CREATE TABLE Funcionarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255),
    email VARCHAR(255),
    cargo VARCHAR(100),
    senha VARCHAR(255) -- Sugiro utilizar algum algoritmo de hash para armazenar a senha de forma segura
);

-- Tabela Relatórios de Despesas
CREATE TABLE RelatoriosDespesas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    funcionario_id INT,
    data DATE,
    descricao TEXT,
    valor DECIMAL(10, 2),
    arquivo_pdf VARCHAR(255),
    status ENUM('pendente', 'aprovado', 'rejeitado'),
    FOREIGN KEY (funcionario_id) REFERENCES Funcionarios(id)
);

-- Tabela Assinaturas Digitais
CREATE TABLE AssinaturasDigitais (
    id INT AUTO_INCREMENT PRIMARY KEY,
    relatorio_id INT,
    gerente_id INT,
    data TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    assinatura TEXT,
    FOREIGN KEY (relatorio_id) REFERENCES RelatoriosDespesas(id),
    FOREIGN KEY (gerente_id) REFERENCES Funcionarios(id)
);

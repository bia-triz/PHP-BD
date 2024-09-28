<?php
// Configurações de conexão
$servername = "localhost";
$username = "seu_usuario";
$password = "sua_senha";
$dbname = "livros_discos";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Criar as tabelas
$sql = "
CREATE TABLE IF NOT EXISTS Artista (
    id_artista INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    nome VARCHAR(500) NOT NULL,
    data_nasc VARCHAR(10) NOT NULL,
    nacionalidade VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS Livro (
    id_livro INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    titulo VARCHAR(500) NOT NULL,
    editora VARCHAR(500) NOT NULL,
    isbn BIGINT NOT NULL,
    data_publi VARCHAR(10) NOT NULL,
    id_artista INT,
    FOREIGN KEY (id_artista) REFERENCES Artista(id_artista)
);

CREATE TABLE IF NOT EXISTS Disco (
    id_disco INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    titulo VARCHAR(500) NOT NULL,
    ano_publi VARCHAR(10) NOT NULL,
    produtora VARCHAR(500) NOT NULL,
    isbn BIGINT NOT NULL,
    id_artista INT,
    FOREIGN KEY (id_artista) REFERENCES Artista(id_artista)
);
";

// Executar a criação das tabelas
if ($conn->multi_query($sql)) {
    
    echo "Tabelas criadas com sucesso.";
} else {
    echo "Erro ao criar tabelas: " . $conn->error;
}

// Função para inserir um artista
function inserirArtista($conn, $nome, $data_nasc, $nacionalidade) {
    $stmt = $conn->prepare("INSERT INTO Artista (nome, data_nasc, nacionalidade) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $data_nasc, $nacionalidade);
    $stmt->execute();
    $stmt->close();
}

// Função para inserir um livro
function inserirLivro($conn, $titulo, $editora, $isbn, $data_publi, $id_artista) {
    $stmt = $conn->prepare("INSERT INTO Livro (titulo, editora, isbn, data_publi, id_artista) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisi", $titulo, $editora, $isbn, $data_publi, $id_artista);
    $stmt->execute();
    $stmt->close();
}

// Função para inserir um disco
function inserirDisco($conn, $titulo, $ano_publi, $produtora, $isbn, $id_artista) {
    $stmt = $conn->prepare("INSERT INTO Disco (titulo, ano_publi, produtora, isbn, id_artista) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisi", $titulo, $ano_publi, $produtora, $isbn, $id_artista);
    $stmt->execute();
    $stmt->close();
}

// Exemplo de inserção de dados
inserirArtista($conn, "Nome do Artista", "01/01/1980", "Brasileiro");
inserirLivro($conn, "Título do Livro", "Editora Exemplo", 1234567890123, "01/01/2020", 1);
inserirDisco($conn, "Título do Disco", "2020", "Produtora Exemplo", 1234567890123, 1);

// Fechar a conexão
$conn->close();
?>
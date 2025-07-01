<?php
// /produtos/adicionar.php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}
require '../login/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $descricao = $_POST['descricao'];
    $imagem_path = '';

    // 
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $imagem = $_FILES['imagem'];
        // 
        if ($imagem['size'] > 2 * 1024 * 1024) {
            die("Erro: Tamanho do arquivo excede 2MB.");
        }
        
        // 
        $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
        if (!in_array($extensao, ['jpg', 'jpeg', 'png'])) {
            die("Erro: Formato de arquivo não permitido. Apenas JPG, JPEG e PNG.");
        }

        // 
        $nome_unico = uniqid() . '.' . $extensao;
        $diretorio = 'imagens/'; // 
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }
        $imagem_path = $diretorio . $nome_unico;

        if (!move_uploaded_file($imagem['tmp_name'], $imagem_path)) {
            die("Erro ao fazer upload da imagem.");
        }
    }

    // 
    $stmt = $pdo->prepare("INSERT INTO produtos (nome, preco, quantidade, descricao, imagem) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nome, $preco, $quantidade, $descricao, $imagem_path]);

    header("Location: listar.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Produto</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Adicionar Novo Produto</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="nome" placeholder="Nome do Produto" required> <input type="number" step="0.01" name="preco" placeholder="Preço" required> <input type="number" name="quantidade" placeholder="Quantidade" required> <textarea name="descricao" placeholder="Descrição"></textarea> <label>Imagem do Produto (JPG, PNG - Máx 2MB):</label> <input type="file" name="imagem" accept=".jpg,.jpeg,.png" required>
            <button type="submit" class="btn">Adicionar</button>
        </form>
        <p><a href="listar.php">Voltar para a lista</a></p>
    </div>
    <script src="../js/animacoes.js"></script>
</body>
</html>
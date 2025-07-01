<?php
// /produtos/editar.php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}
require '../login/conexao.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch();

if (!$produto) {
    die("Produto não encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $descricao = $_POST['descricao'];
    $imagem_path = $produto['imagem'];

    // 
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $imagem = $_FILES['imagem'];
        if ($imagem['size'] > 2 * 1024 * 1024) {
            die("Erro: Tamanho do arquivo excede 2MB.");
        }
        $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
        if (!in_array($extensao, ['jpg', 'jpeg', 'png'])) {
            die("Erro: Formato de arquivo não permitido.");
        }
        
        if ($produto['imagem'] && file_exists($produto['imagem'])) {
            unlink($produto['imagem']);
        }
        
        $nome_unico = uniqid() . '.' . $extensao;
        $diretorio = 'imagens/';
        $imagem_path = $diretorio . $nome_unico;

        if (!move_uploaded_file($imagem['tmp_name'], $imagem_path)) {
            die("Erro ao fazer upload da nova imagem.");
        }
    }

    $stmt = $pdo->prepare("UPDATE produtos SET nome = ?, preco = ?, quantidade = ?, descricao = ?, imagem = ? WHERE id = ?");
    $stmt->execute([$nome, $preco, $quantidade, $descricao, $imagem_path, $id]);

    header("Location: listar.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Editar Produto</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required>
            <input type="number" step="0.01" name="preco" value="<?php echo htmlspecialchars($produto['preco']); ?>" required>
            <input type="number" name="quantidade" value="<?php echo htmlspecialchars($produto['quantidade']); ?>" required>
            <textarea name="descricao"><?php echo htmlspecialchars($produto['descricao']); ?></textarea>
            <label>Imagem Atual:</label>
            <img src="<?php echo htmlspecialchars($produto['imagem']); ?>" alt="Imagem Atual" width="100">
            <label>Trocar Imagem (opcional):</label>
            <input type="file" name="imagem" accept=".jpg,.jpeg,.png">
            <button type="submit" class="btn">Atualizar</button>
        </form>
        <p><a href="listar.php">Voltar para a lista</a></p>
    </div>
    <script src="../js/animacoes.js"></script>
</body>
</html>
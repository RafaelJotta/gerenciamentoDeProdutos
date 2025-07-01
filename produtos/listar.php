<?php
// /produtos/listar.php
session_start();
// 
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}

require '../login/conexao.php';

// 
$stmt = $pdo->query("SELECT * FROM produtos ORDER BY data_criacao DESC");
$produtos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <a href="../login/logout.php" class="btn logout-btn">Logout</a>
    <div class="container">
        <h2>Gerenciamento de Produtos</h2>
        <p>Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</p>
        <a href="adicionar.php" class="btn">Adicionar Novo Produto</a>

        <input type="text" id="search-product" class="search-bar" placeholder="Pesquisar produto por nome...">
        
        <div class="product-grid">
            <?php foreach ($produtos as $produto): ?>
                <div class="product-card">
                    <img src="<?php echo htmlspecialchars($produto['imagem']); ?>" alt="Imagem do Produto">
                    <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                    <p>Preço: R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                    <p>Quantidade: <?php echo htmlspecialchars($produto['quantidade']); ?></p>
                    <p>Descrição: <?php echo htmlspecialchars($produto['descricao']); ?></p>
                    <div class="product-actions">
                        <a href="editar.php?id=<?php echo $produto['id']; ?>" class="btn">Editar</a>
                        <a href="deletar.php?id=<?php echo $produto['id']; ?>" class="btn btn-danger" onclick="return confirmarExclusao();">Remover</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="../js/animacoes.js"></script>
</body>
</html>
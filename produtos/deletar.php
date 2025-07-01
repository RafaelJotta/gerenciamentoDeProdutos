<?php
// /produtos/deletar.php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}
require '../login/conexao.php';

$id = $_GET['id'];

// 
$stmt = $pdo->prepare("SELECT imagem FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch();

if ($produto && $produto['imagem'] && file_exists($produto['imagem'])) {
    unlink($produto['imagem']);
}

$stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
$stmt->execute([$id]);

header("Location: listar.php");
exit();
?>
<?php
// /login/conexao.php

$host = 'localhost';
$db   = 'pw2_projeto';
$user = 'root'; // ou seu usuário do MySQL
$pass = '';     // ou sua senha do MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>
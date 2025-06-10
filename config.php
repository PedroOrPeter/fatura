<?php
$host = 'sql102.infinityfree.com';
$db = 'if0_39198747_fatura';
$user = 'if0_39198747';
$pass = '25111998152003';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

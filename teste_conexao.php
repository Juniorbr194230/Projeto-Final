<?php
$host = "localhost";
$port = "5432";
$dbname = "ProjetoFinal";
$user = "postgres";
$password = "31927"; // <--- Coloque sua senha

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $pdo = new PDO($dsn, $user, $password);
    echo "<h1>Sucesso! O PHP conectou no PostgreSQL.</h1>";
} catch (PDOException $e) {
    echo "<h1>Erro! Não entrou:</h1> " . $e->getMessage();
}
?>
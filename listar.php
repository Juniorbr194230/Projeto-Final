<?php
// listar.php - ATUALIZADO para CPF e TELEFONE
header("Content-Type: application/json");

// --- CONFIGURAÇÃO DE CONEXÃO (Use as mesmas credenciais do salvar.php) ---
$host = "localhost";
$port = "5432";
$dbname = "ProjetoFinal";
$user = "postgres"; 
$password = "31927"; 

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // 1. Comando SQL ATUALIZADO para selecionar CPF e TELEFONE
    $sql = "SELECT id, tipo, nome, cpf, telefone FROM cadastros ORDER BY id DESC";
    
    $stmt = $pdo->query($sql);
    
    // 2. Transforma todos os resultados em um array JSON
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($registros);

} catch (PDOException $e) {
    // Se der erro, retorna código de erro 500 para o JavaScript
    http_response_code(500); 
    echo json_encode(["erro" => "Falha ao buscar registros: " . $e->getMessage()]);
}
?>
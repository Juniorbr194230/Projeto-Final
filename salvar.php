<?php

header("Content-Type: application/json");
$response = ["sucesso" => false, "msg" => ""];

$host = "localhost";
$port = "5432";
$dbname = "ProjetoFinal";
$user = "postgres"; 
$password = "31927"; 
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";


try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // 1. Recebe os dados do JavaScript
    $dados = json_decode(file_get_contents("php://input"));

    // 2. Validação simples para garantir que os campos necessários vieram
    if(isset($dados->nome) && isset($dados->cpf) && isset($dados->telefone)) {
        
        // 3. Comando SQL ATUALIZADO
        $sql = "INSERT INTO cadastros (tipo, nome, cpf, telefone) 
                VALUES (:tipo, :nome, :cpf, :telefone)";
        
        $stmt = $pdo->prepare($sql);

        // 4. Executa a inserção com os novos parâmetros
        $stmt->execute([
            ':tipo' => $dados->tipo,
            ':nome' => $dados->nome,
            ':cpf' => $dados->cpf,
            ':telefone' => $dados->telefone
        ]);

        $response["sucesso"] = true;
        $response["msg"] = "Cadastro (CPF/Telefone) salvo no PostgreSQL com sucesso!";
    } else {
        $response["msg"] = "Dados incompletos ou inválidos recebidos.";
    }

} catch (PDOException $e) {
    http_response_code(500);
    $response["msg"] = "Erro no servidor: " . $e->getMessage();
}

echo json_encode($response);
?>
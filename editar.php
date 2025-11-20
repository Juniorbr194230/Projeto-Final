<?php
// editar.php - BACKEND QUE EXECUTA O COMANDO UPDATE
header("Content-Type: application/json");
$response = ["sucesso" => false, "msg" => ""];

// --- CONFIGURAÇÃO DE CONEXÃO (Use suas credenciais) ---
$host = "localhost";
$port = "5432";
$dbname = "sistema_escolar";
$user = "postgres"; 
$password = "SUA_SENHA_AQUI"; // <-- COLOQUE A SENHA AQUI
// -----------------------------------------------------------

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // 1. Recebe os dados do JavaScript
    $data = json_decode(file_get_contents("php://input"));
    
    // 2. Validação básica
    if(isset($data->id) && isset($data->nome)) {
        
        // 3. Comando SQL de Atualização
        $sql = "UPDATE cadastros 
                SET tipo = :tipo, nome = :nome, cpf = :cpf, telefone = :telefone 
                WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id' => $data->id,
            ':tipo' => $data->tipo,
            ':nome' => $data->nome,
            ':cpf' => $data->cpf,
            ':telefone' => $data->telefone
        ]);

        if ($stmt->rowCount()) {
            $response["sucesso"] = true;
            $response["msg"] = "Registro ID: $data->id atualizado com sucesso!";
        } else {
            $response["sucesso"] = true; // Retorna sucesso mesmo se não houve alteração
            $response["msg"] = "Nenhuma alteração feita no registro ID: $data->id.";
        }
    } else {
        $response["msg"] = "Dados incompletos ou ID inválido recebido.";
    }

} catch (PDOException $e) {
    http_response_code(500);
    $response["msg"] = "Erro de edição: " . $e->getMessage();
}

echo json_encode($response);
?>
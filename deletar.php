<?php
// deletar.php - BACKEND QUE EXECUTA O COMANDO DELETE
header("Content-Type: application/json");
$response = ["sucesso" => false, "msg" => ""];

// --- CONFIGURAÇÃO DE CONEXÃO (Use suas credenciais) ---
$host = "localhost";
$port = "5432";
$dbname = "ProjetoFinal";
$user = "postgres"; 
$password = "31927";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // 1. Recebe os dados do JavaScript
    $data = json_decode(file_get_contents("php://input"));
    $id = isset($data->id) ? (int)$data->id : 0;

    if ($id > 0) {
        // 2. Comando SQL de Deleção
        $sql = "DELETE FROM cadastros WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount()) {
            $response["sucesso"] = true;
            $response["msg"] = "Registro ID: $id deletado com sucesso!";
        } else {
            $response["msg"] = "Nenhum registro encontrado com o ID: $id.";
        }
    } else {
        $response["msg"] = "ID inválido recebido.";
    }

} catch (PDOException $e) {
    http_response_code(500);
    $response["msg"] = "Erro de deleção: " . $e->getMessage();
}

echo json_encode($response);
?>
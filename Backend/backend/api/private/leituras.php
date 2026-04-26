<?php
header("Content-Type: application/json");

require_once "../../auth/verificar_token.php";
require_once "../../auth/verificar_role.php";
require_once "../../config/db.php";

verificarRoles(["admin","tecnico"]);

if (!isset($_GET["id_estacao"]) || !is_numeric($_GET["id_estacao"])) {
    echo json_encode([
        "status" => "erro",
        "mensagem" => "id_estacao inválido"
    ]);
    exit;
}

$id_estacao = (int)$_GET["id_estacao"];

$stmt = $conn->prepare("
SELECT 
    timestamp,
    nivel_agua,
    temperatura
FROM leituras
WHERE id_estacao = ?
ORDER BY timestamp ASC
");

$stmt->bind_param("i", $id_estacao);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = [
        "timestamp" => $row["timestamp"],
        "nivel_agua" => (float)$row["nivel_agua"],
        "temperatura" => (float)$row["temperatura"]
    ];
}

echo json_encode([
    "status" => "ok",
    "total_registos" => count($data),
    "data" => $data
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$stmt->close();
$conn->close();
?>
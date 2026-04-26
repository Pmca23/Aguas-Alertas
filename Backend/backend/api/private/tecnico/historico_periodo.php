<?php
header("Content-Type: application/json");

require_once "../../../auth/verificar_token.php";
require_once "../../../auth/verificar_role.php";
require_once "../../../config/db.php";

verificarRoles(["tecnico"]);

$id_estacao = $_GET["id_estacao"] ?? null;
$dias       = $_GET["dias"] ?? 7;

if (!$id_estacao || !is_numeric($id_estacao)) {

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Estação inválida"
    ]);
    exit;
}

if (!is_numeric($dias) || $dias <= 0) {
    $dias = 7;
}

$id_estacao = (int)$id_estacao;
$dias       = (int)$dias;

$stmt = $conn->prepare("
SELECT 
    timestamp,
    nivel_agua,
    temperatura,
    em_alerta
FROM leituras
WHERE id_estacao = ?
AND timestamp >= NOW() - INTERVAL ? DAY
ORDER BY timestamp ASC
");

$stmt->bind_param("ii", $id_estacao, $dias);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {

    $data[] = [
        "timestamp"   => $row["timestamp"],
        "nivel_agua"  => (float)$row["nivel_agua"],
        "temperatura" => (float)$row["temperatura"],
        "em_alerta"   => (bool)$row["em_alerta"]
    ];
}

echo json_encode([
    "status" => "ok",
    "id_estacao" => $id_estacao,
    "dias" => $dias,
    "total_registos" => count($data),
    "data" => $data
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$stmt->close();
$conn->close();
?>
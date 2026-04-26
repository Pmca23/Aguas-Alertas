<?php
header("Content-Type: application/json");

require_once "../../config/db.php";

if (!isset($_GET['id_estacao']) || !is_numeric($_GET['id_estacao'])) {

    echo json_encode([
        "status" => "erro",
        "mensagem" => "id_estacao inválido"
    ]);
    exit;
}

$id_estacao = (int) $_GET['id_estacao'];

$stmt = $conn->prepare("
    SELECT timestamp, nivel_agua, temperatura, em_alerta
    FROM leituras
    WHERE id_estacao = ?
    ORDER BY timestamp DESC
    LIMIT 20
");

$stmt->bind_param("i", $id_estacao);
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

$data = array_reverse($data);

echo json_encode([
    "status" => "ok",
    "id_estacao" => $id_estacao,
    "total_registos" => count($data),
    "data" => $data
]);

$stmt->close();
$conn->close();
?>
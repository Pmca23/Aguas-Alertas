<?php
header("Content-Type: application/json");

require_once "../../config/db.php";

$sql = "
SELECT l.timestamp,
       e.nome,
       l.nivel_agua,
       l.temperatura,
       l.em_alerta
FROM leituras l
JOIN estacoes e ON l.id_estacao = e.id_estacao
ORDER BY l.timestamp DESC
LIMIT 30
";

$result = $conn->query($sql);

$data = [];

while($row = $result->fetch_assoc()){

    $data[] = [
        "timestamp" => $row["timestamp"],
        "nome" => $row["nome"],
        "nivel_agua" => $row["nivel_agua"],
        "temperatura" => $row["temperatura"],
        "em_alerta" => (bool)$row["em_alerta"]
    ];
}

echo json_encode([
    "status" => "ok",
    "data" => $data
]);

$conn->close();
?>
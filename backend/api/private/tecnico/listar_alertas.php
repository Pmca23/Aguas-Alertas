<?php
header("Content-Type: application/json");

require_once "../../../auth/verificar_token.php";
require_once "../../../auth/verificar_role.php";
require_once "../../../config/db.php";

verificarRoles(["tecnico"]);

$stmt = $conn->prepare("
SELECT
a.id_alerta,
a.id_estacao,
e.nome AS estacao,
a.nivel_critico,
a.tipo,
a.estado,
a.data_hora,
a.resolvido_em
FROM alertas a
JOIN estacoes e ON e.id_estacao = a.id_estacao
ORDER BY a.estado ASC, a.data_hora DESC
");

$stmt->execute();

$result = $stmt->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {

    $data[] = [
        "id_alerta" => (int)$row["id_alerta"],
        "id_estacao" => (int)$row["id_estacao"],
        "estacao" => $row["estacao"],
        "nivel_critico" => (float)$row["nivel_critico"],
        "tipo" => $row["tipo"],
        "estado" => $row["estado"],
        "data_hora" => $row["data_hora"],
        "resolvido_em" => $row["resolvido_em"]
    ];
}

echo json_encode([
    "status" => "ok",
    "total" => count($data),
    "data" => $data
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$stmt->close();
$conn->close();
?>
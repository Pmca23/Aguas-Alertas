<?php
header("Content-Type: application/json");

require_once "../../../auth/verificar_token.php";
require_once "../../../auth/verificar_role.php";
require_once "../../../config/db.php";

verificarRoles(["tecnico"]);

$id_estacao = $_GET["id_estacao"] ?? null;

if (!$id_estacao || !is_numeric($id_estacao)) {
    echo json_encode([
        "status" => "erro",
        "mensagem" => "Estação inválida"
    ]);
    exit;
}

$id_estacao = (int)$id_estacao;

$stmt = $conn->prepare("
SELECT
ROUND(AVG(nivel_agua),2) AS media,
MAX(nivel_agua) AS maximo,
MIN(nivel_agua) AS minimo,
COUNT(*) AS total
FROM leituras
WHERE id_estacao = ?
");

$stmt->bind_param("i", $id_estacao);
$stmt->execute();

$data = $stmt->get_result()->fetch_assoc();

echo json_encode([
    "status" => "ok",
    "data" => [
        "media" => (float)$data["media"],
        "maximo" => (float)$data["maximo"],
        "minimo" => (float)$data["minimo"],
        "total" => (int)$data["total"]
    ]
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$stmt->close();
$conn->close();
?>
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
    o.id_observacao,
    o.observacao,
    o.data_registo,
    u.nome AS tecnico
FROM observacoes o
JOIN utilizadores u 
    ON o.id_utilizador = u.id_utilizador
WHERE o.id_estacao = ?
ORDER BY o.data_registo DESC
");

$stmt->bind_param("i", $id_estacao);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode([
    "status" => "ok",
    "total" => count($data),
    "data" => $data
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$stmt->close();
$conn->close();
?>
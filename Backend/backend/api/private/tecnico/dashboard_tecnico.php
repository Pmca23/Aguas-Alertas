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
e.nome,
e.localizacao,

(SELECT nivel_agua
 FROM leituras
 WHERE id_estacao = e.id_estacao
 ORDER BY timestamp DESC
 LIMIT 1) AS nivel_atual,

(SELECT ROUND(AVG(nivel_agua),2)
 FROM leituras
 WHERE id_estacao = e.id_estacao) AS media,

(SELECT MAX(nivel_agua)
 FROM leituras
 WHERE id_estacao = e.id_estacao) AS maximo,

(SELECT COUNT(*)
 FROM alertas
 WHERE id_estacao = e.id_estacao
 AND estado = 'ativo') AS alertas

FROM estacoes e
WHERE e.id_estacao = ?
");

$stmt->bind_param("i", $id_estacao);
$stmt->execute();

$data = $stmt->get_result()->fetch_assoc();

echo json_encode([
    "status" => "ok",
    "data" => [
        "nome" => $data["nome"],
        "localizacao" => $data["localizacao"],
        "nivel_atual" => (float)$data["nivel_atual"],
        "media" => (float)$data["media"],
        "maximo" => (float)$data["maximo"],
        "alertas" => (int)$data["alertas"]
    ]
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$stmt->close();
$conn->close();
?>
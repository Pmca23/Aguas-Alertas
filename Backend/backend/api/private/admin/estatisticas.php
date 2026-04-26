<?php
header("Content-Type: application/json");

require_once "../../../auth/verificar_token.php";
require_once "../../../auth/verificar_role.php";
require_once "../../../config/db.php";

verificarRoles(["admin"]);

$r1 = $conn->query("
SELECT COUNT(*) total
FROM estacoes
");
$total_estacoes = $r1->fetch_assoc()["total"];

$r2 = $conn->query("
SELECT COUNT(*) total
FROM alertas
WHERE estado = 'ativo'
");
$total_alertas = $r2->fetch_assoc()["total"];

$r3 = $conn->query("
SELECT ROUND(AVG(nivel_agua),2) media
FROM leituras
");
$media = $r3->fetch_assoc()["media"];

$r4 = $conn->query("
SELECT COUNT(*) total
FROM utilizadores
");
$total_users = $r4->fetch_assoc()["total"];

echo json_encode([
    "status" => "ok",
    "data" => [
        "total_estacoes"     => (int)$total_estacoes,
        "alertas_ativos"     => (int)$total_alertas,
        "media_nivel_agua"   => (float)$media,
        "total_utilizadores" => (int)$total_users
    ]
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$conn->close();
?>
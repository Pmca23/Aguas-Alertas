<?php
header("Content-Type: application/json");

require_once "../../../auth/verificar_token.php";
require_once "../../../auth/verificar_role.php";
require_once "../../../config/db.php";

verificarRoles(["admin"]);

$sql = "
SELECT

    (SELECT COUNT(*) FROM estacoes)
    AS total_estacoes,

    (SELECT COUNT(*)
     FROM alertas
     WHERE estado = 'ativo')
    AS alertas_ativos,

    (SELECT ROUND(AVG(nivel_agua),2)
     FROM leituras)
    AS media_nivel_agua,

    (SELECT COUNT(*)
     FROM utilizadores)
    AS total_utilizadores,

    (SELECT COUNT(*)
     FROM leituras
     WHERE chuva = TRUE)
    AS leituras_com_chuva
";

$result = $conn->query($sql);

$data = $result->fetch_assoc();

echo json_encode([

    "status" => "ok",

    "data" => [

        "total_estacoes" =>
            (int)$data["total_estacoes"],

        "alertas_ativos" =>
            (int)$data["alertas_ativos"],

        "media_nivel_agua" =>
            (float)$data["media_nivel_agua"],

        "total_utilizadores" =>
            (int)$data["total_utilizadores"],

        "leituras_com_chuva" =>
            (int)$data["leituras_com_chuva"]
    ]

], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$conn->close();
?>
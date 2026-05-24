<?php
header("Content-Type: application/json");

require_once "../../../auth/verificar_token.php";
require_once "../../../auth/verificar_role.php";
require_once "../../../config/db.php";

verificarRoles(["tecnico"]);

$id_estacao = $_GET["id_estacao"] ?? null;

if (
    !$id_estacao ||
    !is_numeric($id_estacao)
) {

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Estação inválida"
    ]);

    exit;
}

$id_estacao = (int)$id_estacao;

$stmt = $conn->prepare("
SELECT 
    nivel_agua,
    chuva
FROM leituras
WHERE id_estacao = ?
ORDER BY timestamp DESC
LIMIT 5
");

$stmt->bind_param("i", $id_estacao);

$stmt->execute();

$result = $stmt->get_result();

$valores = [];
$chuva_ativa = false;

while ($row = $result->fetch_assoc()) {

    $valores[] = (float)$row["nivel_agua"];

    if ($row["chuva"]) {
        $chuva_ativa = true;
    }
}

$mensagem = "Nível estável";

if (count($valores) >= 2) {

    if ($valores[0] > $valores[count($valores) - 1]) {

        $mensagem = $chuva_ativa
            ? "Nível a subir com chuva ativa"
            : "Nível a subir";
    }

    if ($valores[0] < $valores[count($valores) - 1]) {

        $mensagem = $chuva_ativa
            ? "Nível a descer com chuva ativa"
            : "Nível a descer";
    }
}

echo json_encode([

    "status" => "ok",

    "analise" => $mensagem,

    "chuva_ativa" => $chuva_ativa,

    "ultimos_valores" => $valores

], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$stmt->close();
$conn->close();
?>
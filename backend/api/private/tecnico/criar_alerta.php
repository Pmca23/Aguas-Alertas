<?php
header("Content-Type: application/json");

require_once "../../../auth/verificar_token.php";
require_once "../../../auth/verificar_role.php";
require_once "../../../config/db.php";

verificarRoles(["tecnico"]);

$id_estacao = $_POST["id_estacao"] ?? null;
$nivel_critico = $_POST["nivel_critico"] ?? null;
$tipo = $_POST["tipo"] ?? "aviso";

$tipos_validos = ["informacao", "aviso", "critico"];

if (
    !$id_estacao ||
    !$nivel_critico ||
    !is_numeric($id_estacao) ||
    !is_numeric($nivel_critico) ||
    !in_array($tipo, $tipos_validos)
) {
    echo json_encode([
        "status" => "erro",
        "mensagem" => "Dados inválidos"
    ]);
    exit;
}

$stmt = $conn->prepare("
SELECT id_alerta
FROM alertas
WHERE id_estacao = ?
AND estado = 'ativo'
LIMIT 1
");

$stmt->bind_param("i", $id_estacao);
$stmt->execute();

$res = $stmt->get_result();

if ($res->num_rows > 0) {
    echo json_encode([
        "status" => "erro",
        "mensagem" => "Já existe alerta ativo nesta estação"
    ]);
    exit;
}

$stmt->close();

/* criar alerta */
$stmt = $conn->prepare("
INSERT INTO alertas
(id_estacao, nivel_critico, tipo, estado)
VALUES (?, ?, ?, 'ativo')
");

$stmt->bind_param("ids", $id_estacao, $nivel_critico, $tipo);

if ($stmt->execute()) {

    echo json_encode([
        "status" => "ok",
        "mensagem" => "Alerta criado com sucesso",
        "tipo" => $tipo
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

} else {

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Erro ao criar alerta"
    ]);
}

$stmt->close();
$conn->close();
?>
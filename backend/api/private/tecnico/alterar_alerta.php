<?php
header("Content-Type: application/json");

require_once "../../../auth/verificar_token.php";
require_once "../../../auth/verificar_role.php";
require_once "../../../config/db.php";

verificarRoles(["tecnico"]);

$id_estacao = $_POST["id_estacao"] ?? null;
$nivel = $_POST["nivel_critico"] ?? null;

if (!$id_estacao || !is_numeric($id_estacao) || !$nivel || !is_numeric($nivel)) {
    echo json_encode([
        "status" => "erro",
        "mensagem" => "Dados inválidos"
    ]);
    exit;
}

$id_estacao = (int)$id_estacao;
$nivel = (float)$nivel;

$stmt = $conn->prepare("
UPDATE alertas
SET nivel_critico = ?
WHERE id_estacao = ?
AND estado = 'ativo'
");

$stmt->bind_param("di", $nivel, $id_estacao);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode([
        "status" => "ok",
        "mensagem" => "Nível de alerta atualizado"
    ]);
} else {
    echo json_encode([
        "status" => "erro",
        "mensagem" => "Alerta ativo não encontrado"
    ]);
}

$stmt->close();
$conn->close();
?>
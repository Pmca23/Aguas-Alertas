<?php
header("Content-Type: application/json");
require_once "../../../auth/verificar_token.php";
require_once "../../../auth/verificar_role.php";
require_once "../../../config/db.php";
verificarRoles(["tecnico"]);

$id_estacao   = $_POST["id_estacao"] ?? null;
$nivel_critico = $_POST["nivel_critico"] ?? null;

if (!$id_estacao || !is_numeric($id_estacao) || !$nivel_critico || !is_numeric($nivel_critico)) {
    echo json_encode(["status" => "erro", "mensagem" => "Dados inválidos"]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO alertas (id_estacao, nivel_critico, estado) VALUES (?, ?, 'ativo')");
$stmt->bind_param("id", $id_estacao, $nivel_critico);

if ($stmt->execute()) {
    echo json_encode(["status" => "ok", "mensagem" => "Alerta criado"]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao criar alerta"]);
}
$stmt->close(); $conn->close();
?>
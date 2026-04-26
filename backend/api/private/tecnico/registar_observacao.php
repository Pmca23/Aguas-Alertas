<?php
header("Content-Type: application/json");

require_once "../../../auth/verificar_token.php";
require_once "../../../auth/verificar_role.php";
require_once "../../../config/db.php";

verificarRoles(["tecnico"]);

global $user_data;

$id_estacao = $_POST["id_estacao"] ?? null;
$texto      = $_POST["observacao"] ?? null;
$id_user    = $user_data->id;

if (!$id_estacao || !is_numeric($id_estacao) || !$texto) {

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Dados inválidos"
    ]);
    exit;
}

$id_estacao = (int)$id_estacao;

$stmt = $conn->prepare("
INSERT INTO observacoes
(id_estacao, id_utilizador, observacao)
VALUES (?, ?, ?)
");

$stmt->bind_param("iis", $id_estacao, $id_user, $texto);

if ($stmt->execute()) {

    echo json_encode([
        "status" => "ok",
        "mensagem" => "Observação registada"
    ]);

} else {

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Erro ao registar observação"
    ]);
}

$stmt->close();
$conn->close();
?>
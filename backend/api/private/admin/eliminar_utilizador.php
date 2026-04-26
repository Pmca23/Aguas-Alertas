<?php
header("Content-Type: application/json");

require_once "../../../auth/verificar_token.php";
require_once "../../../auth/verificar_role.php";
require_once "../../../config/db.php";

verificarRoles(["admin"]);

$id = $_POST["id_utilizador"] ?? null;

if (!$id || !is_numeric($id)) {

    echo json_encode([
        "status" => "erro",
        "mensagem" => "ID inválido"
    ]);
    exit;
}

$id = (int)$id;

$stmt = $conn->prepare("
DELETE FROM utilizadores
WHERE id_utilizador = ?
AND role = 'tecnico'
");

$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {

    echo json_encode([
        "status" => "ok",
        "mensagem" => "Técnico eliminado"
    ]);

} else {

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Utilizador não encontrado ou não é técnico"
    ]);
}

$stmt->close();
$conn->close();
?>
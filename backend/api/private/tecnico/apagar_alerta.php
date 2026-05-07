<?php
header("Content-Type: application/json");
require_once "../../../auth/verificar_token.php";
require_once "../../../auth/verificar_role.php";
require_once "../../../config/db.php";
verificarRoles(["tecnico"]);

$id_alerta = $_POST["id_alerta"] ?? null;
if (!$id_alerta || !is_numeric($id_alerta)) {
    echo json_encode(["status" => "erro", "mensagem" => "ID inválido"]);
    exit;
}
$stmt = $conn->prepare("DELETE FROM alertas WHERE id_alerta = ?");
$stmt->bind_param("i", $id_alerta);
$stmt->execute();
echo json_encode($stmt->affected_rows > 0
    ? ["status" => "ok", "mensagem" => "Alerta apagado"]
    : ["status" => "erro", "mensagem" => "Alerta não encontrado"]);
$stmt->close(); $conn->close();
?>
<?php
header("Content-Type: application/json");
require_once "../../../auth/verificar_token.php";
require_once "../../../auth/verificar_role.php";
require_once "../../../config/db.php";
verificarRoles(["tecnico"]);

$id_obs = $_POST["id_observacao"] ?? null;
if (!$id_obs || !is_numeric($id_obs)) {
    echo json_encode(["status" => "erro", "mensagem" => "ID inválido"]);
    exit;
}
$stmt = $conn->prepare("DELETE FROM observacoes WHERE id_observacao = ?");
$stmt->bind_param("i", $id_obs);
$stmt->execute();
echo json_encode($stmt->affected_rows > 0
    ? ["status" => "ok", "mensagem" => "Observação apagada"]
    : ["status" => "erro", "mensagem" => "Observação não encontrada"]);
$stmt->close(); $conn->close();
?>
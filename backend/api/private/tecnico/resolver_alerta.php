<?php
header("Content-Type: application/json");

require_once "../../../auth/verificar_token.php";
require_once "../../../auth/verificar_role.php";
require_once "../../../config/db.php";

verificarRoles(["tecnico"]);

$id_alerta = $_POST["id_alerta"] ?? null;

if (!$id_alerta || !is_numeric($id_alerta)) {
    echo json_encode([
        "status" => "erro",
        "mensagem" => "ID inválido"
    ]);
    exit;
}

$stmt = $conn->prepare("
UPDATE alertas
SET estado = 'resolvido',
    resolvido_em = NOW()
WHERE id_alerta = ?
AND estado = 'ativo'
");

$stmt->bind_param("i", $id_alerta);

if ($stmt->execute()) {

    if ($stmt->affected_rows > 0) {

        echo json_encode([
            "status" => "ok",
            "mensagem" => "Alerta resolvido com sucesso"
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    } else {

        echo json_encode([
            "status" => "erro",
            "mensagem" => "Alerta não encontrado ou já resolvido"
        ]);
    }

} else {

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Erro ao atualizar alerta"
    ]);
}

$stmt->close();
$conn->close();
?>
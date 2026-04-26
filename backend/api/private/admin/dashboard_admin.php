<?php
header("Content-Type: application/json");

require_once "../../../auth/verificar_token.php";
require_once "../../../auth/verificar_role.php";

verificarRoles(["admin"]);

echo json_encode([
    "status" => "ok",
    "mensagem" => "Bem-vindo Admin"
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
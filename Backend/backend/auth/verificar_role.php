<?php

function verificarRoles($rolesPermitidas)
{
    global $user_data;

    if (!isset($user_data->role)) {

        http_response_code(403);

        echo json_encode([
            "status" => "erro",
            "mensagem" => "Role não encontrada"
        ]);

        exit;
    }

    if (!in_array($user_data->role, $rolesPermitidas)) {

        http_response_code(403);

        echo json_encode([
            "status" => "erro",
            "mensagem" => "Acesso negado"
        ]);

        exit;
    }
}
?>
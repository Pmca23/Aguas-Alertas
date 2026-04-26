<?php
session_start();
header("Content-Type: application/json");

if (isset($_SESSION['user_id'])) {

    echo json_encode([
        "status" => "ok",
        "user" => [
            "id" => $_SESSION['user_id'],
            "nome" => $_SESSION['nome'],
            "role" => $_SESSION['role']
        ]
    ]);

} else {
    echo json_encode([
        "status" => "erro",
        "mensagem" => "Não autenticado"
    ]);
}
?>
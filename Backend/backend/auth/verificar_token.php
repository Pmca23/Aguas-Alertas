<?php
header("Content-Type: application/json");

require_once __DIR__ . "/../vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


$secret_key = "VIR4329473298779374298fhdiius3728";

$headers = getallheaders();

$authHeader = $headers["Authorization"] ?? $headers["authorization"] ?? null;

if (!$authHeader) {
    http_response_code(401);

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Token não enviado"
    ]);
    exit;
}

if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    http_response_code(401);

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Formato token inválido"
    ]);
    exit;
}

$jwt = $matches[1];

try {

    $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));
    $user_data = $decoded->data;

} catch (Exception $e) {

    http_response_code(401);

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Token inválido ou expirado"
    ]);
    exit;
}
?>
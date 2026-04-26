<?php
header("Content-Type: application/json");

require_once "../config/db.php";
require_once "../vendor/autoload.php";

use Firebase\JWT\JWT;

$secret_key = "VIR4329473298779374298fhdiius3728";

$email = $_POST["email"] ?? null;
$password = $_POST["password"] ?? null;

if(!$email || !$password){

    echo json_encode([
        "status"=>"erro",
        "mensagem"=>"Dados em falta"
    ]);
    exit;
}

$stmt = $conn->prepare("
SELECT id_utilizador,nome,email,password_hash,role
FROM utilizadores
WHERE email=?
");

$stmt->bind_param("s",$email);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

if(!$user){

    echo json_encode([
        "status"=>"erro",
        "mensagem"=>"Utilizador não encontrado"
    ]);
    exit;
}

if(!password_verify($password,$user["password_hash"])){

    echo json_encode([
        "status"=>"erro",
        "mensagem"=>"Password incorreta"
    ]);
    exit;
}

$payload = [
    "iss" => "VIR",
    "iat" => time(),
    "exp" => time() + 3600,
    "data" => [
        "id" => $user["id_utilizador"],
        "nome" => $user["nome"],
        "email" => $user["email"],
        "role" => $user["role"]
    ]
];

$jwt = JWT::encode($payload, $secret_key, 'HS256');

echo json_encode([
    "status"=>"ok",
    "token"=>$jwt,
    "user"=>[
        "id"=>$user["id_utilizador"],
        "nome"=>$user["nome"],
        "role"=>$user["role"]
    ]
], JSON_PRETTY_PRINT);
?>
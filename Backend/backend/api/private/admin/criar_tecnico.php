<?php
header("Content-Type: application/json");

require_once "../../../auth/verificar_token.php";
require_once "../../../auth/verificar_role.php";
require_once "../../../config/db.php";

verificarRoles(["admin"]);

$nome = $_POST["nome"] ?? null;
$email = $_POST["email"] ?? null;
$password = $_POST["password"] ?? null;

if (!$nome || !$email || !$password) {

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Dados em falta"
    ]);
    exit;
}

$stmt = $conn->prepare("
SELECT id_utilizador
FROM utilizadores
WHERE email = ?
");

$stmt->bind_param("s", $email);
$stmt->execute();

$res = $stmt->get_result();

if ($res->num_rows > 0) {

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Email já existe"
    ]);
    exit;
}

$stmt->close();

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("
INSERT INTO utilizadores
(nome, email, password_hash, role)
VALUES (?, ?, ?, 'tecnico')
");

$stmt->bind_param("sss", $nome, $email, $hash);

if ($stmt->execute()) {

    echo json_encode([
        "status" => "ok",
        "mensagem" => "Técnico criado com sucesso"
    ]);

} else {

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Erro ao criar técnico"
    ]);
}

$stmt->close();
$conn->close();
?>
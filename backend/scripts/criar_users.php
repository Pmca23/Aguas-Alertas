<?php
require_once "../config/db.php";

function criarUtilizador($conn, $nome, $email, $password, $role)
{
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("
        INSERT INTO utilizadores (nome, email, password_hash, role)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param("ssss", $nome, $email, $password_hash, $role);

    if ($stmt->execute()) {
        echo "Utilizador $nome criado com sucesso<br>";
    } else {
        echo "Erro ao criar $nome<br>";
    }

    $stmt->close();
}

$conn->query("DELETE FROM utilizadores WHERE email='admin@vir.pt'");
$conn->query("DELETE FROM utilizadores WHERE email='tecnico@vir.pt'");

criarUtilizador(
    $conn,
    "Administrador",
    "admin@vir.pt",
    "admin123",
    "admin"
);

criarUtilizador(
    $conn,
    "Tecnico",
    "tecnico@vir.pt",
    "tecnico123",
    "tecnico"
);

$conn->close();
?>
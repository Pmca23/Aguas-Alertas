<?php
header("Content-Type: application/json");

require_once "../../../auth/verificar_token.php";
require_once "../../../auth/verificar_role.php";
require_once "../../../config/db.php";

verificarRoles(["admin"]);

$sql = "
SELECT 
    id_utilizador,
    nome,
    email,
    role
FROM utilizadores
ORDER BY role ASC, nome ASC
";

$result = $conn->query($sql);

$data = [];

if ($result && $result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        $data[] = [
            "id_utilizador" => (int)$row["id_utilizador"],
            "nome"          => $row["nome"],
            "email"         => $row["email"],
            "role"          => $row["role"]
        ];
    }
}

echo json_encode([
    "status" => "ok",
    "total_utilizadores" => count($data),
    "data" => $data
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$conn->close();
?>
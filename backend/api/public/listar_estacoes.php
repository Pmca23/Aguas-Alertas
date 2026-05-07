<?php
header("Content-Type: application/json");

require_once "../../config/db.php";

$sql = "SELECT id_estacao, nome, localizacao, latitude, longitude, nivel_max_seguranca FROM estacoes ORDER BY nome";
$result = $conn->query($sql);

$data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "id_estacao"          => $row["id_estacao"],
            "nome"                => $row["nome"],
            "localizacao"         => $row["localizacao"],
            "latitude"            => $row["latitude"],
            "longitude"           => $row["longitude"],
            "nivel_max_seguranca" => $row["nivel_max_seguranca"]
        ];
    }
}

echo json_encode([
    "status" => "ok",
    "data" => $data
]);

$conn->close();
?>
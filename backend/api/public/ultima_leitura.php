<?php
header("Content-Type: application/json");

require_once "../../config/db.php";

$sql = "SELECT * FROM v_ultima_leitura";
$result = $conn->query($sql);

$data = [];

if ($result && $result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        $data[] = [
            "id_estacao"   => $row["id_estacao"],
            "nome"         => $row["nome"],
            "localizacao"  => $row["localizacao"],
            "latitude"     => $row["latitude"],
            "longitude"    => $row["longitude"],
            "timestamp"    => $row["timestamp"],
            "nivel_agua"   => $row["nivel_agua"],
            "temperatura"  => $row["temperatura"],
            "em_alerta"    => (bool)$row["em_alerta"]
        ];
    }
}

echo json_encode([
    "status" => "ok",
    "data" => $data
]);

$conn->close();
?>
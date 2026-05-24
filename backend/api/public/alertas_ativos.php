<?php
header("Content-Type: application/json");

require_once "../../config/db.php";

$sql = "SELECT * FROM v_alertas_ativos";

$result = $conn->query($sql);

$data = [];

if ($result && $result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        $data[] = [

            "id_alerta" =>
                $row["id_alerta"],

            "id_estacao" =>
                $row["id_estacao"],

            "nome_estacao" =>
                $row["nome"],

            "localizacao" =>
                $row["localizacao"],

            "nivel_critico" =>
                (float)$row["nivel_critico"],

            "tipo" =>
                $row["tipo"],

            "data_hora" =>
                $row["data_hora"],

            "estado" =>
                $row["estado"]
        ];
    }
}

echo json_encode([
    "status" => "ok",
    "total_alertas" => count($data),
    "data" => $data
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$conn->close();
?>
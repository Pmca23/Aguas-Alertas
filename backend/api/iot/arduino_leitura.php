<?php
header("Content-Type: application/json");

require_once "../../config/db.php";

// =====================================
// API KEY
// =====================================

$api_key = $_POST["api_key"] ?? "";

if ($api_key !== "vir_estação1") {

    echo json_encode([
        "status" => "erro",
        "mensagem" => "API KEY inválida"
    ]);

    exit;
}

// =====================================
// RECEBER DADOS
// =====================================

$id_estacao = $_POST["id_estacao"] ?? null;
$nivel = $_POST["nivel"] ?? null;
$temp = $_POST["temperatura"] ?? null;
$chuva = $_POST["chuva"] ?? 0;

// =====================================
// VALIDAR
// =====================================

if (
    !$id_estacao || !is_numeric($id_estacao) ||
    !$nivel || !is_numeric($nivel)
) {

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Dados inválidos"
    ]);

    exit;
}

$id_estacao = (int)$id_estacao;
$nivel = (float)$nivel;

$temp = ($temp !== null && is_numeric($temp))
    ? (float)$temp
    : null;

$chuva = ($chuva == 1) ? 1 : 0;

// =====================================
// REGISTAR LEITURA
// =====================================

$stmt = $conn->prepare("
CALL sp_registar_leitura(?, ?, ?, ?)
");

$stmt->bind_param(
    "iddi",
    $id_estacao,
    $nivel,
    $temp,
    $chuva
);

// =====================================
// EXECUTAR
// =====================================

if ($stmt->execute()) {

    echo json_encode([

        "status" => "ok",

        "mensagem" =>
            "Leitura recebida do Arduino",

        "dados" => [

            "id_estacao" =>
                $id_estacao,

            "nivel" =>
                $nivel,

            "temperatura" =>
                $temp,

            "chuva" =>
                (bool)$chuva
        ]

    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

} else {

    echo json_encode([

        "status" => "erro",

        "mensagem" =>
            $stmt->error

    ]);
}

$stmt->close();
$conn->close();
?>
<?php
header("Content-Type: application/json");

require_once "../../auth/verificar_token.php";
require_once "../../auth/verificar_role.php";
require_once "../../config/db.php";
require_once "../../utils/enviar_email.php";

verificarRoles(["admin","tecnico"]);

$id_estacao = $_POST["id_estacao"] ?? null;
$nivel = $_POST["nivel"] ?? null;
$temp = $_POST["temperatura"] ?? null;

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
$temp = ($temp !== null && is_numeric($temp)) ? (float)$temp : null;

$stmt = $conn->prepare("CALL sp_registar_leitura(?, ?, ?)");
$stmt->bind_param("idd", $id_estacao, $nivel, $temp);

if (!$stmt->execute()) {
    echo json_encode([
        "status" => "erro",
        "mensagem" => $stmt->error
    ]);
    exit;
}

$stmt->close();

$stmt = $conn->prepare("
SELECT a.id_alerta, e.nome
FROM alertas a
JOIN estacoes e ON e.id_estacao = a.id_estacao
WHERE a.id_estacao = ?
AND a.estado = 'ativo'
ORDER BY a.id_alerta DESC
LIMIT 1
");

$stmt->bind_param("i", $id_estacao);
$stmt->execute();

$result = $stmt->get_result();
$alerta = $result->fetch_assoc();

$emails_enviados = 0;

if ($alerta) {

    $id_alerta = (int)$alerta["id_alerta"];
    $nome_estacao = $alerta["nome"];

    $stmt->close();

    $stmt = $conn->prepare("
    SELECT id_localidade, nome, contacto_email
    FROM localidades
    WHERE id_estacao = ?
    ");

    $stmt->bind_param("i", $id_estacao);
    $stmt->execute();

    $locais = $stmt->get_result();

    while ($row = $locais->fetch_assoc()) {

        $id_localidade = (int)$row["id_localidade"];
        $email = $row["contacto_email"];
        $nome_local = $row["nome"];

        if ($email) {

            $assunto = "ALERTA CHEIA - " . $nome_estacao;

            $mensagem =
                "Localidade: $nome_local\n" .
                "Estação: $nome_estacao\n" .
                "Nível atual: $nivel m\n" .
                "Situação crítica detetada.";

            $ok = enviarAlertaEmail($email, $assunto, $mensagem);

            $canal = "email";
            $sucesso = $ok ? 1 : 0;

            $ins = $conn->prepare("
            INSERT INTO notificacoes
            (id_alerta, id_localidade, canal, sucesso)
            VALUES (?, ?, ?, ?)
            ");

            $ins->bind_param(
                "iisi",
                $id_alerta,
                $id_localidade,
                $canal,
                $sucesso
            );

            $ins->execute();
            $ins->close();

            if ($ok) {
                $emails_enviados++;
            }
        }
    }
}

echo json_encode([
    "status" => "ok",
    "mensagem" => "Leitura registada",
    "emails_enviados" => $emails_enviados
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$stmt->close();
$conn->close();
?>
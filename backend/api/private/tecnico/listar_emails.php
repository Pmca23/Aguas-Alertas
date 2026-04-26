<?php
header("Content-Type: application/json");

require_once "../../../auth/verificar_token.php";
require_once "../../../auth/verificar_role.php";

verificarRoles(["tecnico"]);

$ficheiro = __DIR__ . "/../../../logs/emails.txt";

if (!file_exists($ficheiro)) {
    echo json_encode([
        "status" => "ok",
        "total" => 0,
        "emails" => []
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

$conteudo = file_get_contents($ficheiro);

$blocos = preg_split('/={10,}\R/', $conteudo);
$emails = [];

foreach ($blocos as $bloco) {

    $bloco = trim($bloco);

    if (empty($bloco)) {
        continue;
    }

    $data = "";
    $para = "";
    $assunto = "";
    $mensagem = "";

    if (preg_match('/DATA:\s*(.+)/', $bloco, $m)) {
        $data = trim($m[1]);
    }

    if (preg_match('/PARA:\s*(.+)/', $bloco, $m)) {
        $para = trim($m[1]);
    }

    if (preg_match('/ASSUNTO:\s*(.+)/', $bloco, $m)) {
        $assunto = trim($m[1]);
    }

    if (preg_match('/MENSAGEM:\s*(.*)/s', $bloco, $m)) {
        $mensagem = trim($m[1]);
    }

    $emails[] = [
        "data" => $data,
        "para" => $para,
        "assunto" => $assunto,
        "mensagem" => $mensagem
    ];
}

$emails = array_reverse($emails);

echo json_encode([
    "status" => "ok",
    "total" => count($emails),
    "emails" => $emails
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
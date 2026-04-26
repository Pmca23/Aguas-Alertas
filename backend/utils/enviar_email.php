<?php

function enviarAlertaEmail($destinatario, $assunto, $mensagem)
{
    $texto  = "====================================\n";
    $texto .= "DATA: " . date("Y-m-d H:i:s") . "\n";
    $texto .= "PARA: " . $destinatario . "\n";
    $texto .= "ASSUNTO: " . $assunto . "\n";
    $texto .= "MENSAGEM:\n" . $mensagem . "\n";
    $texto .= "====================================\n\n";

    $ficheiro = __DIR__ . "/../logs/emails.txt";

    file_put_contents($ficheiro, $texto, FILE_APPEND);

    return true;
}
?>
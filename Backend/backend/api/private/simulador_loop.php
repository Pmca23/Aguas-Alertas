<?php
require_once "../../config/db.php";

set_time_limit(0);

echo "Simulador iniciado...<br><br>";

while (true) {

    $result = $conn->query("SELECT id_estacao, nivel_max_seguranca FROM estacoes");

    if (!$result) {
        echo "Erro ao buscar estações<br>";
        break;
    }

    echo "Nova simulação: " . date("H:i:s") . "<br>";

    while ($row = $result->fetch_assoc()) {

        $id_estacao = $row['id_estacao'];
        $nivel_max = $row['nivel_max_seguranca'];

        if (rand(1, 10) <= 7) {
            
            $nivel = rand(10, ($nivel_max * 10) - 10) / 10;
        } else {
            
            $nivel = rand(($nivel_max * 10), ($nivel_max * 10) + 20) / 10;
        }

        $temp = rand(10, 25);

        $stmt = $conn->prepare("CALL sp_registar_leitura(?, ?, ?)");
        $stmt->bind_param("idd", $id_estacao, $nivel, $temp);
        $stmt->execute();

        echo "Estação $id_estacao → Nivel: $nivel | Temp: $temp<br>";
    }

    echo "<hr>";

    sleep(15);
}
?>
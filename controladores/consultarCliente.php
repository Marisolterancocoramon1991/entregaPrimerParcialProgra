<?php
require_once './clases/cliente.php';

if (isset($_POST["tipoCliente"]) && isset($_POST["numeroCliente"])) {
    $tipoCliente = $_POST["tipoCliente"];
    $numeroCliente = $_POST["numeroCliente"];

    $retorno = cliente::verificarClienteIdTipo($numeroCliente, $tipoCliente);
    echo json_encode($retorno);
} else {
    echo json_encode("Faltan datos de cliente");
}

?>


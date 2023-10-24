<?php
require_once "./controladores/archivos.php";
include_once './clases/cliente.php';
include_once 'validar.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    if ($data !== null) {
        // Verifica que se hayan proporcionado los campos requeridos
        $camposRequeridos = ["numeroCliente", "nombre", "apellido", "tipoDocumento", "numeroDocumento", "mail", "tipoCliente", "pais", "ciudad", "telefono"];
        if (array_diff($camposRequeridos, array_keys($data)) === []) {
         
                $cliente = new cliente($data["numeroCliente"], $data["nombre"], $data["apellido"], $data["tipoDocumento"], $data["numeroDocumento"], $data["mail"], $data["tipoCliente"], $data["pais"], $data["ciudad"], $data["telefono"]);
            
                $retorno = cliente::modificarCliente($cliente);
                echo json_encode($retorno);
           
        } else {
            // En caso de datos faltantes
            echo json_encode(["error" => "Faltan campos requeridos"]);
        }
    } else {
        // En caso de datos JSON nulos
        echo json_encode(["error" => "Datos JSON nulos"]);
    }
}


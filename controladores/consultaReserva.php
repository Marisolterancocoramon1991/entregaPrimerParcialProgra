<?php

require_once "./clases/reserva.php";
$opcionListar = $_GET["listar"];

echo $opcionListar;
try {
    switch ($opcionListar) {
        case 'a':
            if (isset($_GET["fecha"]) && isset($_GET["tipoHabitacion"])) {
                $fecha = $_GET["fecha"];
                $tipoHabitacion = $_GET["tipoHabitacion"];
                $importe = reserva::acumuladorImporteHabitacionFecha($tipoHabitacion, $fecha);
                echo $importe;
            } else {
                date_default_timezone_set("America/Argentina/Buenos_Aires");
                $fechaAyer = new DateTime();
                $fechaAyer->modify("-1 days"); 
                $fechaAyerString = $fechaAyer->format("d-m-Y");   
                $importe = reserva::acumuladorImporteHabitacionFecha($tipoHabitacion, $fechaAyerString);
                echo $importe;
            }
            
            break;
        case 'b':
            
          //  echo "cliente";
            $numeroDeCliente = isset($_GET["numeroDeCliente"]) ? $_GET["numeroDeCliente"] : null;
            if ($numeroDeCliente !== null) {
               
                $reservasFiltradas = reserva::listadoReservasCliente($numeroDeCliente);
                echo $reservasFiltradas;
            } else {
                throw new Exception("Falta el parámetro 'numeroDeCliente'");
            }
            break;
        case 'c':
            $fechaUno = isset($_GET["fechaUno"]) ? $_GET["fechaUno"] : '';
            $fechaDos = isset($_GET["fechaDos"]) ? $_GET["fechaDos"] : '';
            if ($fechaUno && $fechaDos) {
                $retorno = reserva::listadoReservasFecha($fechaUno, $fechaDos);
                $arrayReservasFiltradas = json_decode($retorno, true);
                usort($arrayReservasFiltradas, 'comparaFecha');
                echo json_encode($arrayReservasFiltradas);
            } else {
                throw new Exception("Faltan los parámetros 'fechaUno' y 'fechaDos'");
            }
            break;
        case 'd':
            if (isset($_GET["tipoHabitacion"])) {
                $tipoHabitacion = $_GET["tipoHabitacion"];
                $reservasFiltradas = reserva::listadoReservasTipoHabitacion($tipoHabitacion);
                echo $reservasFiltradas;
            } else {
                throw new Exception("Falta el parámetro 'tipoHabitacion'");
            }
            break;
        default:
            echo json_encode(['error' => 'parámetro "listar" no válido']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

function comparaFecha($fechaA, $fechaB) {
    $dateA = strtotime($fechaA["fechaDeEntrada"]);
    $dateB = strtotime($fechaB["fechaDeEntrada"]);

    if ($dateA == $dateB) {
        return 0;
    }

    return ($dateA < $dateB) ? -1 : 1;
}
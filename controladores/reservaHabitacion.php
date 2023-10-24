<?php
    require_once "./clases/cliente.php";
    require_once "./clases/reserva.php";
    require_once "archivos.php";
    require_once "validar.php";
    require_once "./controladores/archivosImagen.php";
    
    if (isset($_POST["tipoCliente"]) && isset($_POST["numeroCliente"]) && isset($_POST["fechaDeEntrada"]) && isset($_POST["fechaDeSalida"]) && isset($_POST["tipoHabitacion"]) && isset($_POST["importeTotalReserva"])) {
        $id = mt_rand(100000, 999999);
        $tipoCliente = $_POST["tipoCliente"];
        $numeroCliente = $_POST["numeroCliente"];
        $fechaDeEntrada = $_POST["fechaDeEntrada"];
        $fechaDeSalida = $_POST["fechaDeSalida"];
        $tipoHabitacion = $_POST["tipoHabitacion"];
        $importeTotalReserva = $_POST["importeTotalReserva"];
    }

    $retorno = cliente::verificarClienteIdTipo($numeroCliente, $tipoCliente);
    if($retorno  !="Tipo de cliente incorrecto")
    {
        
    if(Validar::validarTipoHabitacion($tipoHabitacion) && Validar::validar_fecha($fechaDeEntrada) 
    && Validar::validar_fecha($fechaDeSalida))
        {
            $manejadorArchivos = new ManejadorArchivos("reservas.json");
            $reserva = new Reserva($id, $fechaDeEntrada,
            $fechaDeSalida, $tipoHabitacion, $importeTotalReserva, $numeroCliente, $tipoCliente);
            
            $data = $manejadorArchivos->leer();
            $nuevaReserva = ['id' => $reserva->id,'fechaDeEntrada' => $reserva->fechaDeEntrada, 
            'fechaDeSalida' => $reserva->fechaDeSalida, 'tipoHabitacion' => $reserva->tipoHabitacion,
            'importeTotalReserva' => $reserva->importeTotal, 'numeroCliente' => $reserva->numeroCliente, 
            'tipoCliente' => $reserva->tipoCliente, 'estado'=> $reserva->estado];
            $data[] = $nuevaReserva;
            $manejadorArchivos->guardar($data);

            $GuardarImagen = new guardarImagen();
            $GuardarImagen->guardarImagenReserva($reserva);
            echo "Se ha cargado exitosamente la imagen";

        }



    }

  
<?php
    require_once "./clases/reserva.php";
    if(isset($_POST["IdReserva"]) && isset($_POST["motivo"]) && isset($_POST["importe"]))
    {
        $retornoVerificarReserva = reserva::verificarReserva($_POST["IdReserva"]);
            if($retornoVerificarReserva == true)
            {
                $retornoCambiarReserva = reserva::cambiarImporte($_POST["IdReserva"],$_POST["importe"]);
                if ($retornoCambiarReserva == true) 
                {
                    reserva::insertarAjusteReserva($_POST["IdReserva"],
                    $_POST["motivo"], $_POST["importe"]);
                    echo "se ha cargado el motivo y se ha cambiado el importe exitosamente";
                }
            }else
            {
                echo "no se ha verificado el numero de reserva exitosamente";
            }
        

    }
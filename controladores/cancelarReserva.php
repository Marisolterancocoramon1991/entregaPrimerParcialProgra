<?php
include_once './clases/cliente.php';
require_once "./clases/reserva.php";

if(isset($_POST["tipoCliente"]) && isset($_POST["numeroCliente"]) && isset($_POST["IdReserva"]) && isset($_POST["estado"]))
{
    $retornoVerificarCliente = cliente::verificarclienteId($_POST["numeroCliente"]);
    $retornoVerificarReservaCliente = reserva::verificarReservaCliente($_POST["numeroCliente"]);
    $retornoVerificarReserva = reserva::verificarReserva($_POST["IdReserva"]);

    if($retornoVerificarCliente == true &&  
    $retornoVerificarReserva == true)
    {
        if($retornoVerificarReserva== true)
        {
            $retornoCambiarReserva = reserva::cambiarEstadoReserva($_POST["IdReserva"],$_POST["estado"]);
            if($retornoCambiarReserva == true)
            {
                echo "Estado de reserva modificado";
            }
            else
            {
                echo "hubo algun problema vuelva a intentarlo mas tarde";
            }
        }
        else
        {
            echo "no se hallo en la base de datos el numero de reserva";
        }
    }
    else
    {
        echo "el cliente fue buscado en la base de datos y no fue hallado";
    }

}else
{
    echo "algunos de las entradas no ha sido satisfecha";
}

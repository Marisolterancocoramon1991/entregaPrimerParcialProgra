<?php
if(isset($_GET['accion']))
{
    switch($_SERVER['REQUEST_METHOD'])
    {
        case 'POST':
            switch($_GET['accion'])
            {
                case 'clienteAlta':
                    include_once './controladores/clienteAlta.php';
                break;
                case 'consultarCliente':
                    include_once './controladores/consultarCliente.php';
                break;
                case 'reservaHabitacion':
                    include_once './controladores/reservaHabitacion.php';
                break;
                case 'cancelarReserva':
                    include_once './controladores/cancelarReserva.php';
                    break;
                    case 'ajustesReserva':
                        include_once './controladores/ajustesReserva.php';
                        break;
                default:
                    echo json_encode(['error' => 'parámetro "accion" no permitido']);
                break ;
            }
           
        break;
        case 'GET':
            switch($_GET['accion'])
            {
                case 'consultarReservas':
                   
                    include_once "./controladores/consultaReserva.php";
                    break;

            }
            break;
     
        case 'PUT':
            switch ($_GET['accion']){
                case 'modificarCliente':
                include './controladores/modificarCliente.php';
            break;
            default:
                echo json_encode(['error' => 'Parámetro "accion" no permitido']);
         break;
       }
    }

}

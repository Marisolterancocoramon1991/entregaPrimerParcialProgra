<?php

require_once "./controladores/archivos.php";
class Reserva {
    public $id;
    public $fechaDeEntrada;
    public $fechaDeSalida;
    public $tipoHabitacion;
    public $importeTotal;
    public $numeroCliente;
    public $tipoCliente;
    public $estado;

    public function __construct($id, $fechaDeEntrada, $fechaDeSalida, $tipoHabitacion, $importeTotal, $numeroCliente, $tipoCliente) {
        $this->id = $id;
        $this->fechaDeEntrada = $fechaDeEntrada;
        $this->fechaDeSalida = $fechaDeSalida;
        $this->tipoHabitacion = $tipoHabitacion;
        $this->importeTotal = $importeTotal;
        $this->numeroCliente = $numeroCliente;
        $this->tipoCliente = $tipoCliente;
        $this->estado = "ocupado";
    }

    public static function acumuladorImporteHabitacionFecha($tipoHabitacion,$fecha){
        $manejadorArchivos = new ManejadorArchivos("reservas.json");
        $data = $manejadorArchivos->leer();
        $acumuladorImporte = 0;
        foreach ($data as  $value) {
            if ($value["tipoHabitacion"] == $tipoHabitacion && $value["fechaDeEntrada"] == $fecha) {
                $acumuladorImporte += $value["importeTotalReserva"];
            } 
        }
        
        return $acumuladorImporte;
    }

    public static function listadoReservasCliente($numeroCliente){
        $manejadorArchivos = new ManejadorArchivos("reservas.json");
        $data = $manejadorArchivos->leer();
        $reservasFiltradas = [];
        foreach ($data as  $value) {
            if ($value["numeroCliente"] == $numeroCliente) {
                $reservasFiltradas[] = $value;
            }
        }
        return json_encode($reservasFiltradas);
    }
    
    public static function listadoReservasFecha($fechaUno,$fechaDos){
        $manejadorArchivos = new ManejadorArchivos("reservas.json");
        $data = $manejadorArchivos->leer();
        $reservasFiltradas = [];

        foreach ($data as  $value) {
            if ($value["fechaDeEntrada"] == $fechaUno || $value["fechaDeEntrada"] == $fechaDos) {
                $reservasFiltradas[] = $value;
            }
        }

        return json_encode($reservasFiltradas);
    }

    public static function listadoReservasTipoHabitacion($tipoHabitacion) {
        static $reservas = null;
        if ($reservas === null) {
            $manejadorArchivos = new ManejadorArchivos("reservas.json");
            $reservas = $manejadorArchivos->leer();
        }
    
        $reservasFiltradas = array_filter($reservas, function($value) use ($tipoHabitacion) {
            return $value["tipoHabitacion"] == $tipoHabitacion;
        });
    
        return json_encode(array_values($reservasFiltradas)); // Reindexa el arreglo resultante
    }
    
    public static function verificarReservaCliente($numeroCliente) {
        $manejadorArchivos = new ManejadorArchivos("reservas.json");
        $reservas = $manejadorArchivos->leer();
        
        foreach ($reservas as $value) {
            if ($value["numeroCliente"] == $numeroCliente) {
                return true; 
            }
        }
    
        return false; 
    }

    public static function verificarReserva($numeroReserva) {
        $manejadorArchivos = new ManejadorArchivos("reservas.json");
        $reservas = $manejadorArchivos->leer();
        
        foreach ($reservas as $value) {
            if ($value["id"] == $numeroReserva) {
                return true; 
            }
        }
    
        return false; 
    }
    
    public static function cambiarEstadoReserva($idReserva,$nuevoEstado){
        $manejadorArchivos = new ManejadorArchivos("reservas.json");
        $data = $manejadorArchivos->leer();
        $respuesta = false;
        foreach ($data as $index => $value) {
            if ($value["id"] == $idReserva) {
               
                $data[$index]["estado"] = $nuevoEstado;
                $respuesta = true;
                break;
            }
        }
        $manejadorArchivos->guardar($data);
        return $respuesta;
    }
    public static function cambiarImporte($idReserva,$importe){
        $manejadorArchivos = new ManejadorArchivos("reservas.json");
        $data = $manejadorArchivos->leer();
        $respuesta = false;
        foreach ($data as $index => $value) {
            if ($value["id"] == $idReserva) {
               
                $data[$index]["importeTotalReserva"] = $importe;
                $respuesta = true;
                break;
            }
        }
        $manejadorArchivos->guardar($data);
        return $respuesta;
    }

    public static function insertarAjusteReserva($idReserva, $motivo, $nuevoImporte) {
        $manejadorArchivos = new ManejadorArchivos("ajustes.json");
        $data = $manejadorArchivos->leer();
        
        $nuevoAjuste = ['numeroReserva' => $idReserva, 'motivo' => $motivo, 'nuevoImporte' => $nuevoImporte];
        
        $data[] = $nuevoAjuste;
        
        if ($manejadorArchivos->guardar($data)) {
            return true; // Inserción exitosa
        } else {
            return false; // Error al guardar
        }
    }
    

}

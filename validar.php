<?php

class Validar {
    public static function validarNombreApellido($nombre, $apellido) {
        if (empty($nombre) || empty($apellido)) {
            return "El nombre y el apellido no pueden estar vacíos.";
        }
        
        if (!preg_match('/^[A-Za-z\s]+$/', $nombre) || !preg_match('/^[A-Za-z\s]+$/', $apellido)) {
            return "El nombre y el apellido solo pueden contener letras y espacios.";
        }

        return true; // La validación pasó, los nombres son válidos
    }
    public static function validarTipoCliente($tipoCliente) {
        $tiposPermitidos = ["individual", "corporativo"];

        if (!in_array($tipoCliente, $tiposPermitidos)) {
            return false;
        }

        return true; // La validación pasó, el tipo de cliente es válido
    }

    public static function contieneSoloNumeros($variable) {
        if (preg_match('/^\d+$/', $variable)) {
            return true; // La variable contiene solo números.
        } else {
            return false; // La variable contiene caracteres no numéricos.
        }
    }
    public static function validarTipoHabitacion($tipoHabitacion) {
        $tiposValidos = array("SIMPLE", "DOBLE", "SUITE");
    
        // Convierte el tipo de habitación a mayúsculas para hacer la comparación insensible a mayúsculas y minúsculas.
        $tipoHabitacion = strtoupper($tipoHabitacion);
    
        if (in_array($tipoHabitacion, $tiposValidos)) {
            return true; // El tipo de habitación es válido.
        } else {
            return false; // El tipo de habitación no es válido.
        }
    }
    public static function validar_fecha($fecha) {
        $patron = '/^\d{2}-\d{2}-\d{4}$/';
        if (preg_match($patron, $fecha)) {
            list($dia, $mes, $anio) = explode('-', $fecha);
            if (1 <= $dia && $dia <= 31 && 1 <= $mes && $mes <= 12 && $anio > 0) {
                return true;
            }
        }
        return false;
    }
    
  
    
    
}


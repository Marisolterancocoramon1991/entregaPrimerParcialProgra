<?php
require_once "./controladores/archivos.php";
class Cliente {
    public $numeroCliente;
    public $nombre;
    public $apellido;
    public $tipoDocumento;
    public $numeroDocumento;
    public $email;
    public $tipoCliente;
    public $pais;
    public $ciudad;
    public $telefono;

    public function __construct($numeroCliente, $nombre, $apellido, $tipoDocumento,
     $numeroDocumento, $email, $tipoCliente, $pais, $ciudad, $telefono) {
        $this->numeroCliente = $numeroCliente;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->tipoDocumento = $tipoDocumento;
        $this->numeroDocumento = $numeroDocumento;
        $this->email = $email;
        $this->tipoCliente = $tipoCliente;
        $this->pais = $pais;
        $this->ciudad = $ciudad;
        $this->telefono = $telefono;
    }

    // Métodos para acceder a los atributos
    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getTipoDocumento() {
        return $this->tipoDocumento;
    }

    public function getNumeroDocumento() {
        return $this->numeroDocumento;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTipoCliente() {
        return $this->tipoCliente;
    }

    public function getPais() {
        return $this->pais;
    }

    public function getCiudad() {
        return $this->ciudad;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    // Métodos para establecer los atributos (setter) si es necesario
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function setTipoDocumento($tipoDocumento) {
        $this->tipoDocumento = $tipoDocumento;
    }

    public function setNumeroDocumento($numeroDocumento) {
        $this->numeroDocumento = $numeroDocumento;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setTipoCliente($tipoCliente) {
        $this->tipoCliente = $tipoCliente;
    }

    public function setPais($pais) {
        $this->pais = $pais;
    }

    public function setCiudad($ciudad) {
        $this->ciudad = $ciudad;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

  /*  public function cargarClienteArchivo()
    {
        $manejadorArchivos = new ManejadorArchivos("hoteles.json");
        $data = $manejadorArchivos->leer();
        $retorno ="cliente ingesado";
        foreach ($data as $index => $clienteGuardado)
        {
            if ($clienteGuardado["nombre"] == $this->nombre &&
            $clienteGuardado["tipoCliente"] == $this->tipoCliente) {
                // Actualizar los datos del cliente existente
                $clienteGuardado = $this->actualizarDatosCliente($this, $clienteGuardado, $index);
                $respuesta = "CLIENTE MODIFICADO";
                $clienteEncontrado = true;
                break;
            }
        }
        if (!$clienteEncontrado) {
            // Crear un nuevo cliente si no se encontró uno existente
            $nuevoCliente = [
                'numeroCliente' => $cliente->numeroCliente,
                'nombre' => $cliente->nombre,
                'apellido' => $cliente->apellido,
                'tipoDocumento' => $cliente->tipoDocumento,
                'numeroDocumento' => $cliente->numeroDocumento,
                'mail' => $cliente->mail,
                'tipoCliente' => $cliente->tipoCliente,
                'pais' => $cliente->pais,
                'ciudad' => $cliente->ciudad,
                'telefono' => $cliente->telefono
            ];
            $data[] = $nuevoCliente;
        }

        $manejadorArchivos->guardar($data);
    }
*/

public function cargarClienteArchivo()
{
    $manejadorArchivos = new ManejadorArchivos("hoteles.json");
    $data = $manejadorArchivos->leer();
    $clienteEncontrado = false;

    foreach ($data as $index => $clienteGuardado) {
        if ($clienteGuardado["nombre"] == $this->nombre && $clienteGuardado["tipoCliente"] == $this->tipoCliente) {
            // Actualizar los datos del cliente existente
            $this->actualizarDatosCliente($data,$index);
            $data[$index] = $this;
            $clienteEncontrado = true;
            break;
        }
    }

    if (!$clienteEncontrado) {
        
        // Crear un nuevo cliente si no se encontró uno existente
        $nuevoCliente = [
            'numeroCliente' => $this->numeroCliente,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'tipoDocumento' => $this->tipoDocumento,
            'numeroDocumento' => $this->numeroDocumento,
            'mail' => $this->email,
            'tipoCliente' => $this->tipoCliente,
            'pais' => $this->pais,
            'ciudad' => $this->ciudad,
            'telefono' => $this->telefono
        ];
        $data[] = $nuevoCliente;
    }

    $manejadorArchivos->guardar($data);
    return $clienteEncontrado;
}

private function actualizarDatosCliente($data,$index)
{
    $data[$index]["numeroCliente"] = $this->numeroCliente;
    $data[$index]["nombre"] = $this->nombre;
    $data[$index]["apellido"] = $this->apellido;
    $data[$index]["tipoDocumento"] = $this->tipoDocumento;
    $data[$index]["numeroDocumento"] = $this->numeroDocumento;
    $data[$index]["mail"] = $this->email;
    $data[$index]["tipoCliente"] = $this->tipoCliente;
    $data[$index]["pais"] = $this->pais;
    $data[$index]["ciudad"] = $this->ciudad;
    $data["telefono"] = $this->telefono;
}
public static function verificarClienteIdTipo($numeroCliente, $tipoCliente)
{
    $manejadorArchivos = new ManejadorArchivos("hoteles.json");
    $data = $manejadorArchivos->leer();
   
    foreach ($data as $value) {
        if ($value["tipoCliente"] == $tipoCliente && $value["numeroCliente"] == $numeroCliente) {
            $pais = $value["pais"];
            $ciudad = $value["ciudad"];
            $telefono = $value["telefono"];
            $data = array(
                "pais" => $pais,
                "ciudad" => $ciudad,
                "telefono" => $telefono
            );
            return  $data;
           
        }
    }

    return "Tipo de cliente incorrecto";
}
     static function modificarCliente($cliente) {
    $manejadorArchivos = new ManejadorArchivos("hoteles.json");
    $data = $manejadorArchivos->leer();
    $encontrado = false;

    foreach ($data as $index => $value) {
            if ($value["numeroCliente"] == $cliente->numeroCliente && $value["tipoCliente"] == $cliente->tipoCliente) {
                $encontrado = true;
                foreach ($cliente as $campo => $valor) {
                    $data[$index][$campo] = $valor;
                }
            }
        }

        if ($encontrado) {
            $manejadorArchivos->guardar($data);
            return "CLIENTE MODIFICADO";
        } else {
            return "NO SE ENCONTRO EL CLIENTE";
        }
    }

    public static function verificarclienteId($numeroCliente) {
        $manejadorArchivos = new ManejadorArchivos("hoteles.json");
        $data = $manejadorArchivos->leer();
        $retorno = false;
        foreach ($data as $value) {
            if ($value["numeroCliente"] == $numeroCliente) {
                $retorno = true;
                break; 
            }
        }
    
        return $retorno;
    }
    
}

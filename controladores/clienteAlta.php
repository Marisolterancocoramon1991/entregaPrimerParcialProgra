<?php

include_once './clases/cliente.php';
include_once 'validar.php';
include_once './controladores/archivosImagen.php';
if (isset($_POST['nombre']) &&
    isset($_POST['apellido']) &&
    isset($_POST['tipoDocumento']) &&
    isset($_POST['email']) &&
    isset($_POST['tipoCliente']) &&
    isset($_POST['pais']) &&
    isset($_POST['ciudad']) &&
    isset($_POST['telefono'])&&
    isset($_POST['numeroDocumento'])) {
    $numeroCliente = mt_rand(100000, 999999);
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $numeroDocumento = $_POST['numeroDocumento'];
    $email = $_POST['email'];
    $tipoCliente = $_POST['tipoCliente'];
    $pais = $_POST['pais'];
    $ciudad = $_POST['ciudad'];
    $telefono = $_POST['telefono'];

    if(Validar::validarTipoCliente($tipoCliente) &&
     Validar::validarNombreApellido($nombre, $apellido) 
     && Validar::contieneSoloNumeros($numeroDocumento))
     {
        $cliente = new Cliente($numeroCliente, $nombre, $apellido,
     $tipoDocumento, $numeroDocumento, $email, $tipoCliente, $pais, $ciudad, $telefono);

   $retorno = $cliente ->cargarClienteArchivo();

   if($retorno==true)
   {
      echo "Cliente Modificado";
   }else
   {
     
      $GuardarImagenCliente = new guardarImagen();
      $GuardarImagenCliente->guardarImagenCliente($cliente);

      echo "<br><br>Cliente Ingresado";
   }
     }else
     {
        echo 'nombre, apellido o tipo de cliente ha sido mal cargado, par favor vuelva a intentarlo';
     }
    
    
} else {
    echo 'algun valor no esta definido o no ha sido verificado';
    // Aquí puedes manejar el caso en el que algún valor no esté definido en $_POST
}

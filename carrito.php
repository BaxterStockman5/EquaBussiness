<?php
require 'conexion.php';

if (isset($_POST['id_producto']) && isset($_POST['accion']) && $_POST['accion'] == 'agregar'){
$id_producto=$_POST['id_producto'];
    $sql = "SELECT * FROM carrito WHERE codproducto = '$id_producto'";
    $resultado = $conexion->query($sql);

    if($resultado->num_rows > 0){
        $sql = "UPDATE carrito SET cantidad = cantidad + 1 WHERE codproducto = '$id_producto'";

    }
    else{
        $sql = "INSERT INTO carrito ( codproducto, cantidad) VALUES ('$id_producto', 1)";
    }
   $ejecucion = $conexion->query($sql);
    if($ejecucion ){
        echo 1;
    }else{
        echo 2;
    }
    

} 
?>
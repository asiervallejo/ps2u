<?php
include("../../../_db/conexion.php");

$db="ps2";

$conexion=mysqli_connect($host,$usuario,$password,$db);

if (mysqli_connect_errno()) {
    echo "Error al conectar con la base de datos";
    exit();
}

    $sql="SELECT id_juego FROM juegos";
    $pre=mysqli_query($conexion,$sql);  
    $registros=mysqli_num_rows($pre);
    mysqli_close($conexion);
    $paginas=ceil($registros/6);

echo ($paginas);

?>
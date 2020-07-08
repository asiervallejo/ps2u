<?php
include("../../../_db/conexion.php");


$db="ps2";

$conexion=mysqli_connect($host,$usuario,$password,$db);

if ($_POST["id"]) {
    $id_usuario=$_POST["id"];

if (mysqli_connect_errno()) {
    echo "Error al conectar con la base de datos";
    exit();
}

    $sql="SELECT juegos.id_juego
        FROM juegos
        LEFT JOIN favoritos ON favoritos.id_juego=juegos.id_juego
        WHERE favoritos.id_usuario=".$id_usuario." AND favoritos.favorito=true";
    $pre=mysqli_query($conexion,$sql);  
    $registros=mysqli_num_rows($pre);
    mysqli_close($conexion);
    $paginas=ceil($registros/6);

echo ($paginas);

}

?>
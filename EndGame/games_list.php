<?php
include("../../../_db/conexion.php");


$db="ps2";

$conexion=mysqli_connect($host,$usuario,$password,$db);

if (mysqli_connect_errno()) {
    echo "Error al conectar con la base de datos";
    exit();
}
$sql="SELECT id_juego,titulo,front_cover,generos.nombre as generoTipo FROM juegos JOIN generos ON generos.id_genero=juegos.genero ";
// Preparar la sentencia
$pre=mysqli_prepare($conexion,$sql);

//Vincular los parámetros
if ($pre) {
    mysqli_stmt_execute($pre);
    mysqli_stmt_bind_result($pre,$id,$titulo,$front_cover,$generoTipo);
    while (mysqli_stmt_fetch($pre)) {
    $games[] = array('id' => $id ,
                    'title'=>$titulo,
                    'cover'=> $front_cover,
    				'genre'=>$generoTipo);
    }
}
mysqli_stmt_close($pre);
mysqli_close($conexion);

echo json_encode($games);

?>
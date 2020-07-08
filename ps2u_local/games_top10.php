<?php
include("../../../_db/conexion.php");


$db="ps2";

$conexion=mysqli_connect($host,$usuario,$password,$db);

$idFavs=[];

$id_usuario=$_POST["id"];
$pagina=($_POST["pagina"])*5;

if (mysqli_connect_errno()) {
    echo "Error al conectar con la base de datos";
    exit();
}


if ($id_usuario>0) {

    $sql="SELECT juegos.id_juego FROM juegos LEFT JOIN favoritos ON favoritos.id_juego=juegos.id_juego WHERE favoritos.id_usuario=? AND favoritos.favorito=true ";
    // Preparar la sentencia
    $pre=mysqli_prepare($conexion,$sql);

    //Vincular los parámetros
    if ($pre) {
        mysqli_stmt_bind_param($pre,"i",$id_usuario);
        mysqli_stmt_execute($pre);    
        mysqli_stmt_bind_result($pre,$id_juego);
        while (mysqli_stmt_fetch($pre)) {
        $idFavs[] = $id_juego;
        }
    }
    mysqli_stmt_close($pre);
}


    $sql="SELECT juegos.id_juego,juegos.titulo,juegos.front_cover,generos.nombre as generoTipo, avg(valoracion.nota) as nota, juegos.descripcion FROM juegos
            LEFT JOIN generos ON generos.id_genero=juegos.genero
            LEFT JOIN valoracion ON valoracion.id_juego=juegos.id_juego GROUP BY juegos.id_juego
            ORDER BY nota desc LIMIT ".$pagina.",5";
    // Preparar la sentencia
    $pre=mysqli_prepare($conexion,$sql);

    //Vincular los parámetros
    if ($pre) {
        mysqli_stmt_execute($pre);
        mysqli_stmt_bind_result($pre,$id,$titulo,$front_cover,$generoTipo,$nota,$descripcion);
        while (mysqli_stmt_fetch($pre)) {
            if (in_array($id, $idFavs)) {
                $games[] = array('id' => $id ,
                                'title'=>$titulo,
                                'descripcion'=>$descripcion,
                                'cover'=> $front_cover,
                                'genre'=>$generoTipo,
                                'favorito'=>1,
                                'valoracion'=>$nota
                            );
            } else {
                $games[] = array('id' => $id ,
                                'title'=>$titulo,
                                'descripcion'=>$descripcion,
                                'cover'=> $front_cover,
                				'genre'=>$generoTipo,
                                'favorito'=>0,
                                'valoracion'=>$nota
                            );
            }
        }
    }
    mysqli_stmt_close($pre);

    mysqli_close($conexion);

echo json_encode($games);

?>
<?php
include("../../../_db/conexion.php");


$db="ps2";

$conexion=mysqli_connect($host,$usuario,$password,$db);

$juegosFav=[];

$id_usuario=$_POST["id"];
$paginas=$_POST["pagina"]*6;

if (mysqli_connect_errno()) {
    echo "Error al conectar con la base de datos";
    exit();
}

if ($id_usuario>0) {

    $sql="SELECT juegos.id_juego,juegos.titulo,juegos.front_cover,generos.nombre as generoTipo, avg(valoracion.nota)
        FROM juegos
        LEFT JOIN favoritos ON favoritos.id_juego=juegos.id_juego
        LEFT JOIN generos ON generos.id_genero=juegos.genero
        LEFT JOIN valoracion ON valoracion.id_juego=juegos.id_juego
        WHERE favoritos.id_usuario=? AND favoritos.favorito=true
        GROUP BY juegos.id_juego
        ORDER BY juegos.titulo
        LIMIT ".$paginas.",6 ";
    // Preparar la sentencia
    $pre=mysqli_prepare($conexion,$sql);

    //Vincular los parámetros
    if ($pre) {
        mysqli_stmt_bind_param($pre,"i",$id_usuario);
        mysqli_stmt_execute($pre);    
        mysqli_stmt_bind_result($pre,$id_juego,$titulo,$front_cover,$generoTipo,$nota);
        while (mysqli_stmt_fetch($pre)) {
            $games[] = array('id' => $id_juego,
                            'title'=>$titulo,
                            'cover'=> $front_cover,
                            'genre'=>$generoTipo,
                            'favorito'=>1,
                            'valoracion'=>$nota
                            );
        }
    }
    mysqli_stmt_close($pre);
}

    mysqli_close($conexion);

echo json_encode($games);

?>
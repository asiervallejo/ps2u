<?php
	include("../../../_db/conexion.php");
	$db="ps2";
    if ($_POST['id']) {
        $imagen=$_POST['imagen'];
        $id=$_POST['id'];

        $conexion=mysqli_connect($host,$usuario,$password,$db);

        $sql="INSERT INTO imagenes (url_imagen,id_juego) VALUES (?,?)";

        $pre=mysqli_prepare($conexion,$sql);
        mysqli_stmt_bind_param($pre,"si",$imagen,$id);
        mysqli_stmt_execute($pre);
        mysqli_stmt_close($pre);
        mysqli_close($conexion);

    }
    echo json_encode($imagen);
?>
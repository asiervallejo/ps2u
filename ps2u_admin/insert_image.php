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
        $lastId=mysqli_insert_id($conexion);
        mysqli_close($conexion);
        $imagen=array("id"=>$lastId,
                        "url"=>$imagen
        );

    }
    echo json_encode($imagen);
?>
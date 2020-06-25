<?php
	include("../../../_db/conexion.php");
	$db="ps2";
	$id=$_POST["id"];
	$conexion=mysqli_connect($host,$usuario,$password,$db);
		if (mysqli_connect_errno()) {
		    echo "Error al conectar con la base de datos";
		    exit();
		}
	$images=[];
	$sql="SELECT url_imagen,id_imagen FROM imagenes WHERE id_juego=?";
	$pre=mysqli_prepare($conexion,$sql);
	if ($pre) {
		mysqli_stmt_bind_param($pre,"i",$id);
		mysqli_stmt_execute($pre);
		mysqli_stmt_bind_result($pre,$url_imagen,$id_imagen);
		while (mysqli_stmt_fetch($pre)) {
			$images[]=array(
				'url'=> $url_imagen,
				'id'=>$id_imagen
			);
		}	
	}
	mysqli_stmt_close($pre);
	mysqli_close($conexion);

	echo json_encode($images);
?>
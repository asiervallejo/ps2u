<?php
	include("../../../_db/conexion.php");
	if (isset($_POST["id"])) {
		$id=$_POST["id"];
		$db="ps2";
		$conexion=mysqli_connect($host,$usuario,$password,$db);
		if (mysqli_connect_errno()) {
		    echo "Error al conectar con la base de datos";
		    exit();
		}
		$sql="DELETE FROM juegos WHERE id_juego= ?";
		// Preparar la sentencia
		$pre=mysqli_prepare($conexion,$sql);
		//Vincular los parámetros
		if ($pre) {
		    mysqli_stmt_bind_param($pre,"i",$id);
		    if (mysqli_stmt_execute($pre)) {
		    	$mensaje=1;
		    } else {
			$mensaje=0;
			}
			mysqli_stmt_close($pre);
		}
		
		mysqli_close($conexion);
		echo $mensaje;	
	}


?>
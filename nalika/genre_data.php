<?php
	include("../../../_db/conexion.php");
	$db="ps2";
	$id=$_POST["id"];
	$conexion=mysqli_connect($host,$usuario,$password,$db);
		if (mysqli_connect_errno()) {
		    echo "Error al conectar con la base de datos";
		    exit();
		}
	$sql="SELECT nombre FROM generos WHERE id_genero=?";
	$pre=mysqli_prepare($conexion,$sql);
	if ($pre) {
		mysqli_stmt_bind_param($pre,"i",$id);
		mysqli_stmt_execute($pre);
		mysqli_stmt_bind_result($pre,$nombre);
		mysqli_stmt_fetch($pre);		
	}  
	$genre_data=array(
					"id_genero"=>$id,
					"nombre"=>$nombre
	);
	mysqli_close($conexion);

	echo json_encode($genre_data);
?>
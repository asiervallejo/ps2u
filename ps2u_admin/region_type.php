<?php
	include("../../../_db/conexion.php");
	$db="ps2";
	$conexion=mysqli_connect($host,$usuario,$password,$db);
		if (mysqli_connect_errno()) {
		    echo "Error al conectar con la base de datos";
		    exit();
		}
	$genres=[];
	$sql="SELECT id_region,nombre FROM region ORDER BY nombre DESC";
	$pre=mysqli_prepare($conexion,$sql);
	if ($pre) {
		mysqli_execute($pre);
		mysqli_stmt_bind_result($pre,$id_genero,$nombre);
		while (mysqli_stmt_fetch($pre)) {
			$regions[]=array(
					"id"=>$id_genero,
					"nombre"=>$nombre
			);
		}	
	}
	mysqli_stmt_close($pre);
	mysqli_close($conexion);

	echo json_encode($regions);
?>
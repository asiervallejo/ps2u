<?php
	include("../../../_db/conexion.php");
	$db="ps2";
	$id=$_POST["id"];
	$gane_data=[];
	$conexion=mysqli_connect($host,$usuario,$password,$db);
		if (mysqli_connect_errno()) {
		    echo "Error al conectar con la base de datos";
		    exit();
		}
	$sql="SELECT titulo,desarrollador,genero,descripcion,fecha,front_cover FROM juegos WHERE id_juego=?";
	$pre=mysqli_prepare($conexion,$sql);
	if ($pre) {
		mysqli_stmt_bind_param($pre,"i",$id);
		mysqli_stmt_execute($pre);
		mysqli_stmt_bind_result($pre,$titulo,$desarrollador,$genero,$descripcion,$fecha,$front_cover);
		mysqli_stmt_fetch($pre);		
	}  
	mysqli_stmt_close($pre);

	$sql="SELECT id_region FROM juegos_region WHERE id_juego=?";
	$pre=mysqli_prepare($conexion,$sql);
	if ($pre) {
		mysqli_stmt_bind_param($pre,"i",$id);
		mysqli_stmt_execute($pre);
		mysqli_stmt_bind_result($pre,$id_region);
		while (mysqli_stmt_fetch($pre)) {
			$region[]=$id_region;	
		}		
	}  
	mysqli_stmt_close($pre);

	$game_data=array(
					"titulo"=>$titulo,
					"desarrollador"=>$desarrollador,
					"genero"=>$genero,
					"descripcion"=>$descripcion,
					"region"=>$region,
					"fecha"=>$fecha,
					"front_cover"=>$front_cover
	);
	mysqli_close($conexion);

	echo json_encode($game_data);
?>
<?php
	include("../../../_db/conexion.php");
	$db="ps2";
	if (isset($_POST["id_juego"])) {
		$id_usuario=$_POST["id_usuario"];
	    $id_juego=$_POST["id_juego"];
		$conexion=mysqli_connect($host,$usuario,$password,$db);
			if (mysqli_connect_errno()) {
			    echo "Error al conectar con la base de datos";
			    exit();
			}
		$sql="SELECT nota FROM valoracion WHERE id_usuario=? AND id_juego=?";
		$pre=mysqli_prepare($conexion,$sql);
		if ($pre) {
			mysqli_stmt_bind_param($pre,"ii",$id_usuario,$id_juego);
			mysqli_stmt_execute($pre);
			mysqli_stmt_bind_result($pre,$nota);
			mysqli_stmt_fetch($pre);		
		}  
		$valoracion=$nota;
		mysqli_close($conexion);
	}
	echo ($valoracion);
?>
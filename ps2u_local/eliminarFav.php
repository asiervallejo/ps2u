<?php
    //Conectamos con la bbdd:
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
		$sql="UPDATE favoritos SET favorito=false WHERE id_usuario=? AND id_juego=?";
		// Preparar la sentencia
		$pre=mysqli_prepare($conexion,$sql);
		//Vincular los parámetros
		if ($pre) {
		    mysqli_stmt_bind_param($pre,"ii",$id_usuario,$id_juego);
		    if (mysqli_stmt_execute($pre)) {
		    	$mensaje=1;
		    } else {
				$mensaje=0;
			}
			mysqli_stmt_close($pre);
		}
		
		mysqli_close($conexion);
		
	}
	echo $mensaje;	

?>
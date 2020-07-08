<?php
	include("../../../_db/conexion.php");
	$db="ps2";
	$id=$_POST["id"];
	$conexion=mysqli_connect($host,$usuario,$password,$db);
		if (mysqli_connect_errno()) {
		    echo "Error al conectar con la base de datos";
		    exit();
		}
	$sql="SELECT nick,email FROM usuarios WHERE id_user=?";
	$pre=mysqli_prepare($conexion,$sql);
	if ($pre) {
		mysqli_stmt_bind_param($pre,"i",$id);
		mysqli_stmt_execute($pre);
		mysqli_stmt_bind_result($pre,$nick,$email);
		mysqli_stmt_fetch($pre);		
	}  
	$user_data=array(
					"id_usuario"=>$id,
					"nick"=>$nick,
					"email"=>$email
	);
	mysqli_close($conexion);

	echo json_encode($user_data);
?>
<?php
  include("../../../_db/conexion.php");

  session_start();

  $db="ps2";
  if (isset($_POST["txtEmail"])) {
	$email=$_POST["txtEmail"];
	$pass=$_POST["txtPassword"];
  $mensaje=1;
	$conexion=mysqli_connect($host,$usuario,$password,$db);
  if (mysqli_connect_errno()) {
	  echo "Error al conectar con la base de datos";
	  exit();
  };
  $sql="SELECT id_user,nick,email,password FROM usuarios WHERE email=?";
  $pre=mysqli_prepare($conexion,$sql);
  mysqli_stmt_bind_param($pre,"s",$email);
  mysqli_stmt_execute($pre);
  mysqli_stmt_bind_result($pre,$id,$nick,$email,$passwordUser);
  mysqli_stmt_fetch($pre);


  if (password_verify($pass, $passwordUser)) {

      if ($id) {
         $_SESSION["loggedin"]=true;
         $_SESSION["id_usuario"]=$id;
         $_SESSION['email']=$email;
         $_SESSION['nick']=$nick;
         $mensaje=0;
      }
      $url='games.php?msg='.$mensaje;
  } 
  else 
  {
      $url='games.php?msg='.$mensaje;
  }
  mysqli_stmt_close($pre);
  mysqli_close($conexion);

  header('Location:'.$url);

}
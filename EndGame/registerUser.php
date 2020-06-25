<?php 
    //Conectamos con la bbdd:
    include("../../../_db/conexion.php");
    $db="ps2";
    if (isset($_POST["btnIngresar"])) {
        $user=$_POST["txtUsuario"];
        $email=$_POST["txtEmail"];
        $pass=$_POST["txtPassword"];
        //Encriptamos el password
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
        $conexion=mysqli_connect($host,$usuario,$password,$db);

        if (mysqli_connect_errno()) {
            echo "Error al conectar con la base de datos";
            exit();
        }
        $sql="INSERT INTO usuarios (nick,email,password) VALUES (?,?,?)";
        // Preparar la sentencia
        $pre=mysqli_prepare($conexion,$sql);
        //Vincular los parámetros
        if ($pre) {
            mysqli_stmt_bind_param($pre,"sss",$user,$email,$hashed_password);
            mysqli_stmt_execute($pre);
            $lastId=mysqli_insert_id($conexion);  
        }
        mysqli_stmt_close($pre);
        mysqli_close($conexion);
        if ($lastId) {
            header("Location: games.php");
        }
        else
        {
            echo '<span class="alert-danger">No se ha podido insertar</span>';
        }
    }
?>
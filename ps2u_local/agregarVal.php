<?php 
    //Conectamos con la bbdd:
    include("../../../_db/conexion.php");
    $db="ps2";
    if (isset($_POST["id_juego"])) {
        $id_usuario=$_POST["id_usuario"];
        $id_juego=$_POST["id_juego"];
        $nota=$_POST["nota"];
        $conexion=mysqli_connect($host,$usuario,$password,$db);

        if (mysqli_connect_errno()) {
            echo "Error al conectar con la base de datos";
            exit();
        }

        //Comprobar que no existe un registro de ese juego y usuario (si: update; no: insert)
        $sql="SELECT count(*) FROM valoracion WHERE id_usuario=? AND id_juego=?";
        $pre=mysqli_prepare($conexion,$sql);
        if ($pre) {
            mysqli_stmt_bind_param($pre,"ii",$id_usuario,$id_juego);
            mysqli_stmt_execute($pre);
            mysqli_stmt_bind_result($pre,$filas_afectadas);
            mysqli_stmt_fetch($pre);
            mysqli_stmt_close($pre);        
        }  
        $registro=$filas_afectadas;

        if ($registro>0) {

            $sql="UPDATE valoracion SET nota=? WHERE id_usuario=? AND id_juego=?";
            $pre=mysqli_prepare($conexion,$sql);
            if ($pre) {
                mysqli_stmt_bind_param($pre,"iii",$nota,$id_usuario,$id_juego);
                if (mysqli_stmt_execute($pre)) {
                    $mensaje=1;
                } else {
                    $mensaje=0;
                }
                mysqli_stmt_close($pre);
            }


        } else {

            $sql="INSERT INTO valoracion (id_usuario,id_juego,nota) VALUES (?,?,?)";
            // Preparar la sentencia
            $pre=mysqli_prepare($conexion,$sql);
            //Vincular los parámetros
            if ($pre) {
                mysqli_stmt_bind_param($pre,"iii",$id_usuario,$id_juego,$nota);
                mysqli_stmt_execute($pre);
                $lastId=mysqli_insert_id($conexion);  
            }
            mysqli_stmt_close($pre);
            
            if ($lastId) {
                $mensaje=1;
            }
            else
            {
                $mensaje=0;
            }
        }

        mysqli_close($conexion);
    }
    echo $mensaje;
?>
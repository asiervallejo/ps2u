             <?php
                if (isset($_FILES["fichero"])) {
                  
                  $ficheroTemp=$_FILES['fichero']['tmp_name'];
                  $ficheroNombre=$_FILES['fichero']['name'];
                  $ficheroInfo=getimagesize($_FILES["fichero"]["tmp_name"]);


                  $ficheroNombreArr=explode(".",$ficheroNombre);
                  $extension=strtolower(end($ficheroNombreArr));
                  $nuevoNombre=md5(time().$ficheroNombre).'.'.$extension;

                  $extPermitidas=array('jpg','png','gif');

                  if (in_array($extension, $extPermitidas)) {
                    $directorio="../fruteria/img/";
                    $destino=$directorio.$nuevoNombre;
                    if (move_uploaded_file($ficheroTemp, $destino)) 
                    {
                      $sql="INSERT INTO productos (title, type, description, filename, height, width, price, rating) VALUES (?,?,?,?,?,?,?,?)";
                      // Preparar la sentencia
                      $pre=mysqli_prepare($conexion,$sql);

                      //Vincular los parámetros
                      if ($pre) {

                          mysqli_stmt_bind_param($pre,"sissiisi",$titulo,$tipo,$descripcion,$nuevoNombre,$ficheroHeight,$ficheroWidth,$precio,$valoracion);

                          mysqli_stmt_execute($pre);
                      
                          mysqli_stmt_close($pre);
                          mysqli_close($conexion);
                          header("Location: productos_admin.php");
                      }
                    } 
                    else 
                    {
                      $mensaje="No se ha podido subir el fichero";
                    }
                  } 
                  else 
                  {
                    $mensaje="Extension no permitida";
                  } 
                }
        ?>
        <script>

                    //Imagen previa de la imagen a subir:
            function readURL(input) {
              if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                  $('#imagen').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]);
              }
            }

            $("#fichero").change(function() {
              $('#imgDiv').removeClass('d-none');
              readURL(this);
            });
        </script>
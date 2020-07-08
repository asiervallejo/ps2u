<?php
    session_start();
    if ((!isset($_SESSION['loggedin']))||($_SESSION['id_usuario']!=6))
        header("Location: ../ps2u_local/index.php");
?>

<?php 
    include("../../../_db/conexion.php");
    $db="ps2";
    $id=$_GET["id"];
    if (isset($_GET["recarga"])) 
        $recarga=$_GET["recarga"];
    else
        $recarga=0;
?>
<?php
    if (isset($_POST["btnSave"])) {
        //Variables
        $game=$_POST["txtGame"];
        $genre=$_POST["selGenre"];
        $developer=$_POST["selDeveloper"];
        $region=$_POST["selRegion"];
        $description=$_POST["txtDescription"];
        $date=$_POST["txtDate"];
        $imageName=$_POST["txtFileName"];

        $conexion=mysqli_connect($host,$usuario,$password,$db);

        if (mysqli_connect_errno()) {
            echo "Error al conectar con la base de datos";
            exit();
        }
        //--------------INICIO SENTENCIAS--------------------
                        mysqli_autocommit($conexion, FALSE);
                        $query_success = TRUE;

                        //Primera sentencia preaprada
                        $sqlGames="UPDATE juegos SET titulo=?,genero=?,desarrollador=?,fecha=?,descripcion=? WHERE id_juego=?";

                        $pre1=mysqli_prepare($conexion,$sqlGames);

                        if ($pre1) {
                            mysqli_stmt_bind_param($pre1,"siissi",$game,$genre,$developer,$date,$description,$id);
                            if (!mysqli_stmt_execute($pre1)){
                               $query_success = FALSE; 
                            }
                        }
                        mysqli_stmt_close($pre1);
                        //Averiguar el id_juego_region:

                            $sqlJuegoRegion="SELECT id_juego_region FROM juegos_region WHERE id_juego=?";
                                $pre3=mysqli_prepare($conexion,$sqlJuegoRegion);
                            if ($pre3) {
                                mysqli_stmt_bind_param($pre3,"i",$id);
                                mysqli_stmt_execute($pre3);
                                mysqli_stmt_bind_result($pre3,$id_juego_region);
                                while (mysqli_stmt_fetch($pre3)) {
                                    $juegoRegion[]=$id_juego_region;   
                                }          
                            }  
                            mysqli_stmt_close($pre3);
                            //var_dump($juegoRegion);
                        //Segundas sentencias preparadas
                        for ($i=1; $i <= 3; $i++) {
                            

                            if (in_array($i,$region)) {
                                $value=$i;   
                            }
                            else{
                                $value=null;
                            } 
                            $sqlRegion="UPDATE juegos_region SET id_juego=?, id_region=? WHERE id_juego_region=?";
                            $pre2=mysqli_prepare($conexion,$sqlRegion);
                            if ($pre2) {
                                mysqli_stmt_bind_param($pre2,"iii",$id,$value,$juegoRegion[($i-1)]);
                                if (!mysqli_stmt_execute($pre2)){
                                        $query_success = FALSE;
                                } 
                            }   
                        }
                        mysqli_stmt_close($pre2); 

                        if ($query_success) {
                            mysqli_commit($conexion);
                            header("Location: product-list.php");
                        } else {
                            mysqli_rollback($conexion);
                            echo '<span class="alert-danger">No se pudo actualizar</span>';
                        }  
                        mysqli_close($conexion);
                        //--------------FIN SENTENCIAS--------------------

        if (isset($_FILES["inputImage"])) {
                  //------------SUBIR IMAGEN-------------
                  $ficheroTemp=$_FILES['inputImage']['tmp_name'];
                  $ficheroNombre=$_FILES['inputImage']['name'];
                  //$ficheroInfo=getimagesize($_FILES["inputImage"]["tmp_name"]);

                  $ficheroNombreArr=explode(".",$ficheroNombre);
                  $extension=strtolower(end($ficheroNombreArr));
                  $nuevoNombre=$imageName.'.'.$extension;

                  $extPermitidas=array('jpg','png','gif');

                  if (in_array($extension, $extPermitidas)) {
                    $directorio="img/covers/";
                    $destino=$directorio.$imageName;
                    if (!move_uploaded_file($ficheroTemp, $destino)) 
                    {
                      $mensaje="No se ha podido subir el fichero";
                    }
                  } 
                  else 
                  {
                    $mensaje="Extension no permitida";
                  } 
        }
        echo '<span class="alert-danger">'.$mensaje.'</span>';
    }
?>


<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Product Edit | Nalika - Material Admin Template</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
		============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- nalika Icon CSS
		============================================ -->
    <link rel="stylesheet" href="css/nalika-icon.css">
    <!-- owl.carousel CSS
		============================================ -->
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/owl.theme.css">
    <link rel="stylesheet" href="css/owl.transitions.css">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="css/normalize.css">
    <!-- meanmenu icon CSS
		============================================ -->
    <link rel="stylesheet" href="css/meanmenu.min.css">
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="css/main.css">
    <!-- morrisjs CSS
		============================================ -->
    <link rel="stylesheet" href="css/morrisjs/morris.css">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="css/scrollbar/jquery.mCustomScrollbar.min.css">
    <!-- metisMenu CSS
		============================================ -->
    <link rel="stylesheet" href="css/metisMenu/metisMenu.min.css">
    <link rel="stylesheet" href="css/metisMenu/metisMenu-vertical.css">
    <!-- calendar CSS
		============================================ -->
    <link rel="stylesheet" href="css/calendar/fullcalendar.min.css">
    <link rel="stylesheet" href="css/calendar/fullcalendar.print.min.css">
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="style.css">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- modernizr JS
		============================================ -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>

    <link rel="stylesheet" href="css/alertify.min.css"/>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <?php include("left-side-bar.html") ?>

    <!-- Start Welcome area -->
    <div class="all-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="logo-pro">
                        <a href="index.html"><img class="main-logo" src="img/logo/logo.png" alt="" /></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-advance-area">
            <!-- Header Top -->
            <?php include ("header-top-area.html") ?> 
            <!-- Mobile Menu -->
            <?php include("mobile-menu.html") ?>
            <div class="breadcome-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="breadcome-list">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="breadcomb-wp">
											<div class="breadcomb-icon">
												<i class="icon nalika-home"></i>
											</div>
											<div class="breadcomb-ctn">
												<h2>Games</h2>
												<p>Welcome to <span class="bread-ntd">PS2U</span></p>
											</div>
										</div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="breadcomb-report">
											<button data-toggle="tooltip" data-placement="left" title="Download Report" class="btn"><i class="icon nalika-download"></i></button>
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Single pro tab start-->
        <div class="single-product-tab-area mg-b-30">
            <!-- Single pro tab review Start-->
            <div class="single-pro-review-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="review-tab-pro-inner">
                                <ul id="myTab3" class="tab-review-design">
                                    <li class="active"><a href="#description"><i class="icon nalika-edit" aria-hidden="true"></i> Game Edit</a></li>
                                    <li><a id="hrefPictures" href="#pictures"><i class="icon nalika-picture" aria-hidden="true"></i> Pictures</a></li>

                                </ul>
                                <input id="txtRecarga" type="hidden" value="<?= $recarga ?>">
                                <form action="" method="POST" id="myTabContent" class="tab-content custom-product-edit" enctype="multipart/form-data">
                                    <!-- Game Menu -->
                                    <input type="hidden" name="txtId" id="txtId" value="<?=  $id ?>">
                                    <div class="product-tab-list tab-pane fade active in" id="description">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="review-content-section">
                                                    <div class="input-group mg-b-pro-edt">
                                                        <span class="input-group-addon"><i class="icon nalika-edit" aria-hidden="true"></i></span>
                                                        <input type="text" id="txtGame" name="txtGame" class="form-control" placeholder="Game Title" required>
                                                    </div>
                                                    <select name="selGenre" id="selGenre" class="form-control pro-edt-select form-control-primary mg-b-pro-edt" required>
                                                            
                                                    </select>
                                                    <select name="selDeveloper" id="selDeveloper" class="form-control pro-edt-select form-control-primary mg-b-pro-edt" required>
                                                    </select>
                                                    <div class="btn-group images-cropper-pro">
                                                        <label title="Upload Front Cover" for="inputImage" class="btn btn-primary img-cropper-cp">
                                                            <input type="file" accept="image/*" name="inputImage" id="inputImage" class="hide"> Upload Front Cover
                                                        </label>
                                                        <div id="imageDiv" name="imageDiv" class="image-crop">
                                                            <img id="image" name="image" src="img/cropper/1.jpg" alt="" style="width: 150px"><input type="hidden" name="txtFileName" id="txtFileName" value="<?= $filename ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="review-content-section">
                                                    <div class="input-group mg-b-pro-edt">
                                                        <span class="input-group-addon">Region/s</span>
                                                        <select name="selRegion[]" id="selRegion" class="form-control pro-edt-select form-control-primary custom-select" multiple size="2" required>   
                                                        </select>
                                                    </div>
                                                    <div class="input-group mg-b-pro-edt">
                                                        <span class="input-group-addon"><i class="icon nalika-favorites-button" aria-hidden="true"></i></span>
                                                        <textarea id="txtDescription" name="txtDescription" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Description of the game" required></textarea>
                                                    </div>
                                                    <div class="input-group mg-b-pro-edt">
                                                        <!-- <span class="input-group-addon"><i class="far fa-calendar-alt" area-hidden="true"></i></span> -->
                                                        <input type="date" id="txtDate" name="txtDate" max="3000-12-31" 
                                                                min="1000-01-01" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="text-center custom-pro-edt-ds">
                                                    <input type="submit" id="btnSave" name="btnSave" class="btn btn-ctl-bt waves-effect waves-light m-r-10" value="Edit">
                                                    <input  type="reset" id="btnDiscard" name="btnDiscard" class="btn btn-ctl-bt waves-effect waves-light" value="Discard">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Pictures Menu   -->                                  
                                    <div class="product-tab-list tab-pane fade" id="pictures">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="review-content-section">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                            <!-- <input type="file" name="files[]" multiple/> -->
                                                            <input name="urlImagen" id="urlImagen" type="text" class="form-control" />
                                                            <input type="button" name="btnInsertar" id="btnInsertar" value="Insert" class="btn btn-primary">
                                                            <img name="imgPre" id="imgPre" alt="picture" src="" class="img-fluid" hidden="true">

                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                                            <div class="row">
                                                              <div class="col-md-12">
                                                                <div class="mdb-lightbox no-margin" id="imgGallery" name="imgGallery">
                                                                </div>
                                                              </div>
                                                            </div>
                                                        </div>      
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer-copy-right">
                            <p>Copyright © 2018 <a href="https://colorlib.com/wp/templates/">Colorlib</a> All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- jquery
		============================================ -->
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <!-- bootstrap JS
		============================================ -->
    <script src="js/bootstrap.min.js"></script>
    <!-- wow JS
		============================================ -->
    <script src="js/wow.min.js"></script>
    <!-- price-slider JS
		============================================ -->
    <script src="js/jquery-price-slider.js"></script>
    <!-- meanmenu JS
		============================================ -->
    <script src="js/jquery.meanmenu.js"></script>
    <!-- owl.carousel JS
		============================================ -->
    <script src="js/owl.carousel.min.js"></script>
    <!-- sticky JS
		============================================ -->
    <script src="js/jquery.sticky.js"></script>
    <!-- scrollUp JS
		============================================ -->
    <script src="js/jquery.scrollUp.min.js"></script>
    <!-- mCustomScrollbar JS
		============================================ -->
    <script src="js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/scrollbar/mCustomScrollbar-active.js"></script>
    <!-- metisMenu JS
		============================================ -->
    <script src="js/metisMenu/metisMenu.min.js"></script>
    <script src="js/metisMenu/metisMenu-active.js"></script>
    <!-- morrisjs JS
		============================================ -->
    <script src="js/sparkline/jquery.sparkline.min.js"></script>
    <script src="js/sparkline/jquery.charts-sparkline.js"></script>
    <!-- calendar JS
		============================================ -->
    <script src="js/calendar/moment.min.js"></script>
    <script src="js/calendar/fullcalendar.min.js"></script>
    <script src="js/calendar/fullcalendar-active.js"></script>
    <!-- tab JS
		============================================ -->
    <script src="js/tab.js"></script>
    <!-- plugins JS
		============================================ -->
    <script src="js/plugins.js"></script>
    <!-- main JS
		============================================ -->
    <script src="js/main.js"></script>

    <script src="js/alertify.min.js"></script>

    <script>
        var glId;
        $(function(){
            var id=$("#txtId").val();
            glId=id;
            var recarga=$("#txtRecarga").val();
            if (recarga=='1')
            {
                console.log(recarga);
                $("#hrefPictures").tab('show');
            }

            //Tipos de genero:
            $.ajax({
                url:"genre_type.php",
                method:"POST",
                dataType:"json",
                data:{},
                success:function(data){
                    code='<option value="0" selected disabled>Select the genre</option>';
                    $.each(data,function(index,value){
                        code+='<option value="'+value.id+'">'+value.nombre+'</option>';
                    })
                    $("#selGenre").html(code);
                },
                error: function(error){
                    console.log(error);
                }
            });

            //Lista de desarroladores:
            $.ajax({
                url:"developer_type.php",
                method:"POST",
                dataType:"json",
                data:{},
                success:function(data){
                    code='<option value="0" selected disabled>Select the developer</option>';
                    $.each(data,function(index,value){
                        code+='<option value="'+value.id+'">'+value.nombre+'</option>';
                    })
                    $("#selDeveloper").html(code);
                },
                error: function(error){
                    console.log(error);
                }
            });

            //Lista de regiones:
            $.ajax({
                url:"region_type.php",
                method:"POST",
                dataType:"json",
                data:{},
                success:function(data){
                    //console.log(data)
                    code='';
                    $.each(data,function(index,value){
                        code+='<option value="'+value.id+'">'+value.nombre+'</option>';
                    })
                    $("#selRegion").html(code);
                },
                error: function(error){
                    console.log(error);
                }
            });
            //Lista de imagenes:
            $.ajax({
                url:"images_game.php",
                method:"POST",
                dataType:"json",
                data:{id: id},
                success:function(data){
                    console.log(data);
                    code='';
                    $.each(data,function(index,value){
                        code+=
                        '<figure class="col-md-4">'+
                                    '<a href="#" data-size="1600x1067">'+
                                        '<img onclick="eliminarImagen('+value.id+')" class="eliminar" src="img/borrar.png"></img>'+
                                    '</a>'+
                                        '<img  alt="picture" src="'+value.url+'" class="img-fluid">'+
                                    
                                '</figure>';
                    })
                    $("#imgGallery").html(code);
                },
                error: function(error){
                    console.log(error);
                }
            });
            //Insertar Imagenes:
            
            $("#btnInsertar").click(function(){
                if ($("#urlImagen").val()=="")
                    alertify.alert("You must insert an url of the image");
                else{
                var url=$("#urlImagen").val();
                $.ajax({
                    url:"insert_image.php",
                    method:"POST",
                    dataType:"json",
                    data:{imagen: url, id: id},
                    success:function(data){
                        console.log(data)
                        $("#urlImagen").val("");
                        var code='<figure class="col-md-4">'+
                                    '<a href="#" data-size="1600x1067">'+
                                        '<img onclick="eliminarImagen('+data.id+')" class="eliminar" src="img/borrar.png"></img>'+
                                    '</a>'+
                                        '<img  alt="picture" src="'+data.url+'" class="img-fluid">'+
                                    
                                '</figure>';
                        $("#imgGallery").append(code);

                    },
                    error: function(error){
                        console.log(error);
                    }
                });
                }
            })
            //Previsualizar imagen:
            $("#urlImagen").change(function(){
                $("#imgPre").attr('src',$("#urlImagen").val());
                $("#imgPre").attr('hidden',false);
            })
            //Datos de cada juego:
            $.ajax({
                url:"game_data.php",
                method:"POST",
                dataType:"json",
                data:{id: id},
                success: function(data){
                    console.log(data);
                    $("#txtGame").val(data.titulo);
                    $("#selDeveloper").val(data.desarrollador);
                    $("#selGenre").val(data.genero);
                    $("#txtDescription").val(data.descripcion);
                    $('#image').attr('src', 'img/covers/'+data.front_cover);
                    $("#txtFileName").val(data.front_cover);

                    $.each(data.region,function(index,valor){                      
                        //console.log(valor);
                        $('#selRegion option[value='+valor+']').attr("selected", "selected");
                    })
                    $("#txtDate").val(data.fecha);
                },
                error: function(error){
                    console.log(error);
                }

            })

        });
        function eliminarImagen(id){
            $.ajax({
                url:"delete_image.php",
                method:"POST",
                dataType:"json",
                data:{id: id},
                success: function(data){
                    console.log(data);
                    if (data==1){          
                        alertify.alert("Image deleting was successfuly complete", function(){
                            window.location.href="edit_game.php?id="+glId+"&recarga=1";   
                            });
                        } 
                },
                error: function(error){
                    console.log(error);
                }

            })
        }
        //Imagen previa de la imagen a subir:
        function readURL(input) {
              if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                  $('#image').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]);
              }
            }

            $("#inputImage").change(function() {
              //$('#imageDiv').removeClass('d-none');
              readURL(this);
            });
    </script>
</body>

</html>
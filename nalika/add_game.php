<?php 
    //Conectamos con la bbdd:
    include("../../../_db/conexion.php");
    $db="ps2";
    if (isset($_POST["btnSave"])) {
        //Variables
        $game=$_POST["txtGame"];
        $genre=$_POST["selGenre"];
        $developer=$_POST["selDeveloper"];
        $region=$_POST["selRegion"];
        $description=$_POST["txtDescription"];
        $date=$_POST["txtDate"];
        $arrayImagenes=$_POST['arrayImagenes'];
        $imagenes = explode(',', $arrayImagenes);

        $conexion=mysqli_connect($host,$usuario,$password,$db);

        if (mysqli_connect_errno()) {
            echo "Error al conectar con la base de datos";
            exit();
        }

        if (isset($_FILES["inputImage"])) {
                  
                  $ficheroTemp=$_FILES['inputImage']['tmp_name'];
                  $ficheroNombre=$_FILES['inputImage']['name'];
                  //$ficheroInfo=getimagesize($_FILES["inputImage"]["tmp_name"]);


                  $ficheroNombreArr=explode(".",$ficheroNombre);
                  $extension=strtolower(end($ficheroNombreArr));
                  $nuevoNombre=md5(time().$ficheroNombre).'.'.$extension;

                  $extPermitidas=array('jpg','png','gif');

                  if (in_array($extension, $extPermitidas)) {
                    $directorio="img/covers/";
                    $destino=$directorio.$nuevoNombre;
                    if (move_uploaded_file($ficheroTemp, $destino)) 
                    {
                        mysqli_autocommit($conexion, FALSE);
                        $query_success = TRUE;

                        //Primera sentencia preaprada
                        $sqlGames="INSERT INTO juegos (titulo,genero,desarrollador,front_cover,fecha,descripcion) VALUES (?,?,?,?,?,?)";

                        $pre1=mysqli_prepare($conexion,$sqlGames);

                        if ($pre1) {
                            mysqli_stmt_bind_param($pre1,"siisss",$game,$genre,$developer,$nuevoNombre,$date,$description);
                            if (!mysqli_stmt_execute($pre1)){
                               $query_success = FALSE; 
                            } else 
                            $lastId=mysqli_insert_id($conexion); 
                        }
                        mysqli_stmt_close($pre1);
                        //Segundas sentencias preparadas

                        for ($i=1; $i <= 3; $i++) {
                            if (in_array($i,$region)) {
                                $value=$i;
                                // var_dump($value);    
                            }
                            else{
                                $value=null;
                            } 
                            $sqlRegion="INSERT INTO juegos_region (id_juego, id_region) VALUES (?,?)";
                            $pre2=mysqli_prepare($conexion,$sqlRegion);
                            if ($pre2) {
                                mysqli_stmt_bind_param($pre2,"ii",$lastId,$value);
                                if (!mysqli_stmt_execute($pre2)){
                                        $query_success = FALSE;
                                } 
                            }   
                        }

                        mysqli_stmt_close($pre2); 

                        //Tercera sentencia preparada (insertar imagenes en BBDD)

                            foreach ($imagenes as $imagen) {
                                if ($imagen!="") {
                                    $sqlImagenes="INSERT INTO imagenes (id_juego, url_imagen) VALUES (?,?)";
                                    $pre3=mysqli_prepare($conexion,$sqlImagenes);
                                    if ($pre3) {
                                        mysqli_stmt_bind_param($pre3,"is",$lastId,$imagen);
                                        if (!mysqli_stmt_execute($pre3)){
                                                $query_success = FALSE;
                                        } 
                                    }  
                                }
                            }

 
                        mysqli_stmt_close($pre3); 


                        if ($query_success) {
                            mysqli_commit($conexion);
                            header("Location: product-list.php");
                        } else {
                            mysqli_rollback($conexion);
                            echo '<span class="alert-danger">No se ha podido insertar</span>';
                        }  
                        mysqli_close($conexion);
                    } 
                    else 
                    {
                      $mensaje="No se ha podido subir el fichero, debe insertar una imagen";
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
												<h2>Product Edit</h2>
												<p>Welcome to Nalika <span class="bread-ntd">Admin Template</span></p>
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
                                    <li><a href="#pictures"><i class="icon nalika-picture" aria-hidden="true"></i> Pictures</a></li>
                                    <!--   // Reviews Menu                                  
                                    <li><a href="#reviews"><i class="icon nalika-chat" aria-hidden="true"></i> Review</a></li>
                                    -->
                                </ul>
                                <form action="" method="POST" id="myTabContent" class="tab-content custom-product-edit" enctype="multipart/form-data">
                                    <!-- Game Menu -->
                                    <div class="product-tab-list tab-pane fade active in" id="description">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="review-content-section">
                                                    <div class="input-group mg-b-pro-edt">
                                                        <span class="input-group-addon"><i class="icon nalika-edit" aria-hidden="true"></i></span>
                                                        <input type="text" id="txtGame" name="txtGame" class="form-control" placeholder="Game Title">
                                                    </div>
                                                    <select name="selGenre" id="selGenre" class="form-control pro-edt-select form-control-primary mg-b-pro-edt">
                                                            
                                                    </select>
                                                    <select name="selDeveloper" id="selDeveloper" class="form-control pro-edt-select form-control-primary mg-b-pro-edt">
                                                    </select>
                                                    <div class="btn-group images-cropper-pro">
                                                        <label title="Upload Front Cover" for="inputImage" class="btn btn-primary img-cropper-cp">
                                                            <input type="file" accept="image/*" name="inputImage" id="inputImage" class="hide"> Upload Front Cover
                                                        </label>
                                                        <div id="imageDiv" name="imageDiv" class="image-crop">
                                                            <img id="image" name="image" src="img/cropper/1.jpg" alt="" class="w-25">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="review-content-section">
                                                    <div class="input-group mg-b-pro-edt">
                                                        <span class="input-group-addon">Region/s</span>
                                                        <select name="selRegion[]" id="selRegion" class="form-control pro-edt-select form-control-primary custom-select" multiple size="2">   
                                                        </select>
                                                    </div>
                                                    <div class="input-group mg-b-pro-edt">
                                                        <span class="input-group-addon"><i class="icon nalika-favorites-button" aria-hidden="true"></i></span>
                                                        <textarea id="txtDescription" name="txtDescription" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Description of the game"></textarea>
                                                    </div>
                                                    <div class="input-group mg-b-pro-edt">
                                                        <span class="input-group-addon"><i class="far fa-calendar-alt" area-hidden="true"></i></span>
                                                        <input type="date" id="txtDate" name="txtDate" max="3000-12-31" 
                                                                min="1000-01-01" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="text-center custom-pro-edt-ds">
                                                    <input type="submit" id="btnSave" name="btnSave" class="btn btn-ctl-bt waves-effect waves-light m-r-10">
                                                    <input  type="reset" id="btnDiscard" name="btnDiscard" class="btn btn-ctl-bt waves-effect waves-light">
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
                                                            <input name="urlImagen" id="urlImagen" type="url"/>
                                                            <input type="button" name="btnInsertar" id="btnInsertar" value="Insert">
                                                            <img name="imgPre" id="imgPre" alt="picture" src="" class="img-fluid" hidden="true">

                                                        </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                                            <input type="hidden" id="arrayImagenes" name="arrayImagenes">
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

                                    <!--     //Reviews Menu                           
                                    <div class="product-tab-list tab-pane fade" id="reviews">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="review-content-section">
                                                    <div class="card-block">
                                                        <div class="text-muted f-w-400">
                                                            <p>No reviews yet.</p>
                                                        </div>
                                                        <div class="m-t-10">
                                                            <div class="txt-primary f-18 f-w-600">
                                                                <p>Your Rating</p>
                                                            </div>
                                                            <div class="stars stars-example-css detail-stars">
                                                                <div class="review-rating">
                                                                    <fieldset class="rating">
                                                                        <input type="radio" id="star5" name="rating" value="5">
                                                                        <label class="full" for="star5"></label>
                                                                        <input type="radio" id="star4half" name="rating" value="4 and a half">
                                                                        <label class="half" for="star4half"></label>
                                                                        <input type="radio" id="star4" name="rating" value="4">
                                                                        <label class="full" for="star4"></label>
                                                                        <input type="radio" id="star3half" name="rating" value="3 and a half">
                                                                        <label class="half" for="star3half"></label>
                                                                        <input type="radio" id="star3" name="rating" value="3">
                                                                        <label class="full" for="star3"></label>
                                                                        <input type="radio" id="star2half" name="rating" value="2 and a half">
                                                                        <label class="half" for="star2half"></label>
                                                                        <input type="radio" id="star2" name="rating" value="2">
                                                                        <label class="full" for="star2"></label>
                                                                        <input type="radio" id="star1half" name="rating" value="1 and a half">
                                                                        <label class="half" for="star1half"></label>
                                                                        <input type="radio" id="star1" name="rating" value="1">
                                                                        <label class="full" for="star1"></label>
                                                                        <input type="radio" id="starhalf" name="rating" value="half">
                                                                        <label class="half" for="starhalf"></label>
                                                                    </fieldset>
                                                                </div>
                                                                <div class="clear"></div>
                                                            </div>
                                                        </div>
                                                        <div class="input-group mg-b-15 mg-t-15">
                                                            <span class="input-group-addon"><i class="icon nalika-user" aria-hidden="true"></i></span>
                                                            <input type="text" class="form-control" placeholder="User Name">
                                                        </div>
                                                        <div class="input-group mg-b-15">
                                                            <span class="input-group-addon"><i class="icon nalika-user" aria-hidden="true"></i></span>
                                                            <input type="text" class="form-control" placeholder="Last Name">
                                                        </div>
                                                        <div class="input-group mg-b-15">
                                                            <span class="input-group-addon"><i class="icon nalika-mail" aria-hidden="true"></i></span>
                                                            <input type="text" class="form-control" placeholder="Email">
                                                        </div>
                                                        <div class="form-group review-pro-edt mg-b-0-pt">
                                                            <button type="submit" class="btn btn-ctl-bt waves-effect waves-light">Submit
																</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    -->
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

    <script>
        $(function(){

            $("#btnSave").click(function(){
                $.each($("#selRegion").val(), function(index,value){
                    console.log(value);
                })
            });
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
                data:{},
                success:function(data){
                    console.log(data);
                    code='';
                    $.each(data,function(index,value){
                        code+='<figure class="col-md-4">'+
                                    '<a href="#" data-size="1600x1067">'+
                                        '<img alt="picture" src="'+value+'" class="img-fluid">'+
                                    '</a>'+
                                '</figure>';
                    })
                    $("#imgGallery").html(code);
                },
                error: function(error){
                    console.log(error);
                }
            });

            //Insertar Imagenes:
            //var variable='<?= $variable ?>'
            var  url_array=[];
            $("#btnInsertar").click(function(){

                var url=$("#urlImagen").val();
                url_array.push(url);
                var code='<figure class="col-md-4">'+
                            '<a href="#" data-size="1600x1067">'+
                            '<img alt="picture" src="'+url+'" class="img-fluid">'+
                            '</a>'+
                            '</figure>';
                $("#imgGallery").append(code);
                console.log(url_array);
                $("#arrayImagenes").val(url_array);
            })
            //Previsualizar imagen:
            $("#urlImagen").change(function(){
                $("#imgPre").attr('src',$("#urlImagen").val());
                $("#imgPre").attr('hidden',false);
            })

        });
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
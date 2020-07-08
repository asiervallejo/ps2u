<?php
	include("../../../_db/conexion.php");

	session_start();
	$id_usuario=$_SESSION["id_usuario"];
	$imagenes=[];
	$db="ps2";
	if ($_GET["id"]) {
		
		$id=$_GET["id"];
		$conexion=mysqli_connect($host,$usuario,$password,$db);
			if (mysqli_connect_errno()) {
			    echo "Error al conectar con la base de datos";
			    exit();
			}
		$sql="SELECT titulo,desarrolladores.nombre,front_cover,generos.nombre,descripcion,DATE_FORMAT(fecha, '%d/%m/%Y') as fecha
				FROM juegos
				JOIN desarrolladores ON juegos.desarrollador=desarrolladores.id_desarrollador
				JOIN generos ON juegos.genero=generos.id_genero
				WHERE juegos.id_juego=?";
		$pre=mysqli_prepare($conexion,$sql);
		if ($pre) {
			mysqli_stmt_bind_param($pre,"i",$id);
			mysqli_stmt_execute($pre);
			mysqli_stmt_bind_result($pre,$titulo,$desarrollador,$front_cover,$genero,$descripcion,$fecha);
			mysqli_stmt_fetch($pre);		
		}  
		mysqli_stmt_close($pre);

		$sql="SELECT region.nombre FROM juegos_region
				JOIN region ON region.id_region=juegos_region.id_region
				WHERE id_juego=?";
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

		$sql="SELECT url_imagen FROM imagenes WHERE id_juego=?";
		$pre=mysqli_prepare($conexion,$sql);
		if ($pre) {
			mysqli_stmt_bind_param($pre,"i",$id);
			mysqli_stmt_execute($pre);
			mysqli_stmt_bind_result($pre,$url_imagen);
			while (mysqli_stmt_fetch($pre)) {
				$imagenes[]=$url_imagen;	
			}		
		}  
		mysqli_stmt_close($pre);

		$game_data=array(
						"titulo"=>$titulo,
						"desarrollador"=>$desarrollador,
						"frontcover"=>$front_cover,
						"genero"=>$genero,
						"descripcion"=>$descripcion,
						"region"=>$region,
						"fecha"=>$fecha,
						"imagenes"=>$imagenes,
		);
		mysqli_close($conexion);
	}
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
	<title>PS2U Game</title>
	<meta charset="UTF-8">
	<meta name="description" content="EndGam Gaming Magazine Template">
	<meta name="keywords" content="endGam,gGaming, magazine, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Favicon -->
	<link href="img/favicon.ico" rel="shortcut icon"/>

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i,900,900i" rel="stylesheet">


	<!-- Stylesheets -->
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/font-awesome.min.css"/>
	<link rel="stylesheet" href="css/slicknav.min.css"/>
	<link rel="stylesheet" href="css/owl.carousel.min.css"/>
	<link rel="stylesheet" href="css/magnific-popup.css"/>
	<link rel="stylesheet" href="css/animate.css"/>
	<link rel="stylesheet" href="dist/star-rating.css"/>

	<!-- Main Stylesheets -->
	<link rel="stylesheet" href="css/style.css"/>


	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>
	<!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div>
	</div>

	<!-- Header section -->
	<?php include ("header_section.php") ?>
	<!-- Header section end -->

	<!-- Page top section -->
	<section class="page-top-section set-bg" data-setbg="img/page-top-bg/3.jpg">
		<div class="page-info">
			<h2>Games</h2>
			<div class="site-breadcrumb">
				<a href="index.php">Home</a>  /
				<a href="games.php">Games</a>  /
				<span><?= $game_data["titulo"] ?></span>
			</div>
		</div>
	</section>
	<!-- Page top end-->

	
	<!-- Games section -->

	<section class="games-single-page">
		<div class="container">
			<div class="m-2" id="favoritos" name="favoritos">
				<button id="btnFav" name="btnFav" class="btn btn-success"><img src="img/icons/corazonup.svg" alt=""></button>
				<button id="btnFavEliminar" name="btnFavEliminar" class="btn btn-danger"><img src="img/icons/corazondown.svg" alt=""></button>
			</div>
			<div class="row">
				<div class="col-xl-8 col-lg-7 col-md-6 game-single-content">
					<div class="game-single-preview w-50">
						<img src="../ps2u_admin/img/covers/<?= $game_data['frontcover'] ?>" alt="">
					</div>
					<div class="game-item">
						<select class="star-rating" name="selValoracion" id="selValoracion">
							<option value="">Valorar el juego</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
						</select>
<!-- 						<a href="#" id="btnValorar" name="btnValorar" class="read-more">Rate  <img src="img/icons/double-arrow.png" alt="#"/></a> -->
					</div>
				</div>
				<div class="col-xl-4 col-lg-5 col-md-6 sidebar game-page-sideber">
					<div id="stickySidebar">
						<div class="widget-item">
							<div class="rating-widget">


								<h4 class="widget-title">Details</h4>
								<ul>
									<li>Title<span><?= $game_data['titulo'] ?></span></li>
									<li>Developer<span><?= $game_data['desarrollador'] ?></span></li>
									<li>Genre<span><?= $game_data['genero'] ?></span></li>
									<li>Release Date<span><?= $game_data['fecha'] ?></span></li>
									<li>Region	
										<?php 
											$regiones=$game_data['region'];
											foreach ($regiones as $key => $value) {
										?>		
												<span><?= $value ?></span><br/>
										<?php	 	
											 } 
										?>
										
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="game-single-content">
				<h2 class="gs-title"><?= $game_data['titulo'] ?></h2>
				<h4>Description</h4>
				<p>
					<?= nl2br($game_data['descripcion']) ?>
				</p>
				<h4>Images</h4>
				<div class="row">	  
					<?php
						$packImagenes=$game_data["imagenes"];
						if ($packImagenes!=null){
							foreach ($packImagenes as $key => $image) {
						
					?>
								<div class="col-md-4">
								    <div class="thumbnail">
									    <a href="<?= $image ?>">
									    	<img src="<?= $image ?>" alt="Lights" class="w-100 mb-5">
									    </a>
									</div>
								</div>
					<?php
							}		
						}
					?>
				</div>
				<div class="geme-social-share pt-5 d-flex">
					<p>Share:</p>
					<a href="#"><i class="fa fa-pinterest"></i></a>
					<a href="#"><i class="fa fa-facebook"></i></a>
					<a href="#"><i class="fa fa-twitter"></i></a>
					<a href="#"><i class="fa fa-dribbble"></i></a>
					<a href="#"><i class="fa fa-behance"></i></a>
				</div>
			</div>
		</div>
	</section>
	<!-- Games end-->

		<!-- Footer section -->
	<?php include ("footer.html") ?>
	<!-- Footer section end -->

	<!--====== Javascripts & Jquery ======-->
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.slicknav.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.sticky-sidebar.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="dist/star-rating.min.js"></script>
	<script src="js/sweetalert2.all.min.js"></script>
	<script src="js/main.js"></script>
	<script>

		$(function () {
    		$("#mdb-lightbox-ui").load("mdb-addons/mdb-lightbox-ui.html");
    		//ESTRELLITAS
			var starRatingControls = new StarRating( '.star-rating',{
			    classname: "gl-star-rating",
			    initialText: "Rate this game"
			} );


  		//Recoger id de usuario y juego:
  		var id='<?= $id ?>';
  		var id_usuario='<?= $id_usuario ?>';

  		//Comprobamos el estado del juego ssi favorito es null/true/false y ocultamos/mostramos botones:
  		$.ajax({
			url:"estadoFav.php",
			method:"POST",
			dataType:"",
			data:{id_juego:id, id_usuario:id_usuario},
			success: function(fav){
				if (fav==false || fav==null){
					$("#btnFav").show();
					$("#btnFavEliminar").hide();
				}
				else {
					$("#btnFav").hide();
					$("#btnFavEliminar").show();
				}
			},
			error: function(error){
				console.log(error);
			}
		});
  		//Agregar a favoritos
  		$("#btnFav").click(function(){

  			console.log(id_usuario+", "+id);
				$.ajax({
				url:"agregarFav.php",
				method:"POST",
				dataType:"",
				data:{id_juego:id, id_usuario:id_usuario},
				success: function(fav){
					//console.log(fav);
					//window.location.reload();
					if (fav==1){
						$("#btnFav").hide();
						$("#btnFavEliminar").show();
					}
					else {
						$("#btnFav").show();
						$("#btnFavEliminar").hide();
					}
				},
				error: function(error){
						console.log(error);
					}
				})
  		});
  		//Eliminar de favoritos
  		$("#btnFavEliminar").click(function(){

  			console.log(id_usuario+", "+id);
				$.ajax({
				url:"eliminarFav.php",
				method:"POST",
				dataType:"",
				data:{id_juego:id, id_usuario:id_usuario},
				success: function(fav){
					//console.log(fav);
					//window.location.reload();
					if (fav==1){
						$("#btnFav").show();
						$("#btnFavEliminar").hide();
					}
					else {
						$("#btnFav").hide();
						$("#btnFavEliminar").show();
					}
					},
					error: function(error){
						console.log(error);
					}
				})
  		});

  	//-----------------VALORACION----------------
  		//Recogemos la valoracion actual del juego de dicho usuario:
  		$.ajax({
			url:"juegoVal.php",
			method:"POST",
			dataType:"",
			data:{id_juego:id, id_usuario:id_usuario},
			success: function(val){
				console.log(val)
				if (!val)
					val=0;
				$("#selValoracion").val(val);
				starRatingControls.rebuild();
			},
			error: function(error){
				console.log(error);
			}
		});
		  		//Agregar a favoritos
  		$("#selValoracion").change(function(){
				$.ajax({
				url:"agregarVal.php",
				method:"POST",
				dataType:"",
				data:{id_juego:id, id_usuario:id_usuario, nota:$("#selValoracion").val()},
				success: function(fav){
					console.log(fav);
					Swal.fire({
						position:"top-end",	
						icon: 'info',
						text: 'Game successfully rated',
						confirmButtonColor: '#501755',  
				  		width:'250px'
					})

				},
				error: function(error){
						console.log(error);
					}
				})
  		});

  	});


	</script>

	</body>
</html>

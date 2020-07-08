<?php
	session_start();
	if (isset($_GET["msg"])) {
        $msg=$_GET["msg"];
    } else {
    	$msg=-1;
 	}
 	//Capturo el id del usuario en caso de que este logeado
	if (isset($_SESSION['id_usuario']))
		$id=$_SESSION['id_usuario'];
	else
		$id=0;

?>

<!DOCTYPE html>
<html lang="zxx">
<head>
	<title>PS2U</title>
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

	<!-- Main Stylesheets -->
	<link rel="stylesheet" href="css/style.css"/>

	<!-- Alertify -->
	<link rel="stylesheet" href="css/alertify.min.css"/>

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


	<!-- Hero section -->
	<section class="hero-section overflow-hidden">
		<div class="hero-slider owl-carousel">
			<div class="hero-item set-bg d-flex align-items-center justify-content-center text-center" data-setbg="img/ps2.jpg">
				<div class="container">
					<h2>Playstation 2 you</h2>
					<p>Live in your world. Play in ours. It's time to play.</p>
				</div>
			</div>

		</div>
	</section>
	<!-- Hero section end-->

	<!-- Review section -->
	<section class="review-section">
		<div class="section-title text-white text-center mb-5">
			<h1>TOP 10 RATED GAMES</h1>
		</div>
		<div class="container" id="topGames" name="topGames" >
		</div>
		<div class="site-pagination row justify-content-center" id="pagTop" name="pagTop">
			<a onclick="paginar(0)" href="#">01.</a>
			<a onclick="paginar(1)" href="#">02.</a>
		</div>
	</section>
	<!-- Review section end-->

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
	<script src="js/alertify.min.js"></script>
	<script src="js/sweetalert2.all.min.js"></script>
	<script src="js/main.js"></script>
	<script>

		$(function(){
			paginar(0);
		});

		function paginar(pagina){
			//Activar la pagina en la que estamos
			$('#pagTop .active').removeClass("active");
			var pag=pagina+1;
			var pagClick=$("#pagTop > :nth-child("+pag+")");
			pagClick.addClass('active');

			//Id del usuario, 0 en caso de no logeado
			var id= <?= $id ?>;
			
			$.ajax({
				url:"games_top10.php",
				method:"POST",
				dataType:"json",
				data:{id:id, pagina:pagina},
				success: function(games){
					console.log(games);
					codigo="";
					$.each(games,function(i,v){
						var valoracion=v.valoracion;
						if (valoracion==null) {
							valoracion=0;
						}
						var descripcion=v.descripcion;
						descripcion=descripcion.replace(/\r?\n/g, '<br/>');
						console.log(descripcion)
						codigo+='<div class="review-item">'+
									'<div class="row">'+
										'<div class="col-lg-4">'+

											'<div class="review-pic">';
											if (v.favorito==1) 
										codigo+= '<img class="corazon" src=img/icons/corazon.png>';
										codigo+= '<img class="top5cover" src="../ps2u_admin/img/covers/'+v.cover+'" alt="">'+
											'</div>'+
										'</div>'+
										'<div class="col-lg-8">'+
											'<div class="review-content text-box text-white">'+
												'<div class="rating">'+
													'<h5><i>Rating</i>'+
													'<span>';
													if (valoracion>0)
														codigo+=valoracion.toFixed(1);
													else
														codigo+='-';
													codigo+='</span> / 10</h5>'+
												'</div>'+
												'<h3>'+v.title+'</h3>'+
												'<div class="description">'+descripcion+'</div>'+
												'<?php if (isset($_SESSION['loggedin'])) {?>'+
												'<a href="game-single.php?id='+v.id+'" class="read-more">Read More  <img src="img/icons/double-arrow.png" alt="#"/></a>'+
												'<?php } else { ?>'+
												'<a onclick="mensaje()" href="#" class="read-more">Read More  <img src="img/icons/double-arrow.png" alt="#"/></a>'+
												'<?php } ?>'+
											'</div>'+
										'</div>'+
									'</div>'+
								'</div>'
					})
					$("#topGames").html(codigo);

				},
				error: function(error){
					console.log(error);
				}

			});
		}

		function mensaje(){
			Swal.fire({
			  position:"top-end",	
			  icon: 'info',
			  text: 'You must be logged to access this content',
			  confirmButtonColor: '#501755',  
				width:'250px'
			})
		}
	</script>

	</body>
</html>


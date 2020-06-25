<?php
	session_start();
	if (isset($_GET["msg"])) {
        $msg=$_GET["msg"];
    } else {
    	$msg=-1;
 	}
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

	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/jquery.slicknav.min.js"></script>
	<script src="js/jquery.sticky-sidebar.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/alertify.min.js"></script>


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
	<section class="page-top-section set-bg" data-setbg="img/page-top-bg/1.jpg">
		<div class="page-info">
			<h2>Games</h2>
			<div class="site-breadcrumb">
				<a href="">Home</a>  /
				<span>Games</span>
			</div>
		</div>
	</section>
	<!-- Page top end-->




		<!-- Games section -->
	<section class="games-section">
		<div class="container">
			<ul id="abecedario" class="game-filter">

			</ul>
			<div class="row">
				<div class="col-xl-7 col-lg-8 col-md-7">
					<div id="games" name="games" class="row">
					</div>
					<div class="site-pagination">
						<a href="#" class="active">01.</a>
						<a href="#">02.</a>
						<a href="#">03.</a>
					</div>
				</div>
				<div class="col-xl-3 col-lg-4 col-md-5 sidebar game-page-sideber">
					<div id="stickySidebar">
						<div class="widget-item">
							<div class="categories-widget">
								<h4 class="widget-title">categories</h4>
								<ul>
									<li><a href="">Games</a></li>
									<li><a href="">Gaming Tips & Tricks</a></li>
									<li><a href="">Online Games</a></li>
									<li><a href="">Team Games</a></li>
									<li><a href="">Community</a></li>
									<li><a href="">Uncategorized</a></li>
								</ul>
							</div>
						</div>
						<div class="widget-item">
							<div class="categories-widget">
								<h4 class="widget-title">Genre</h4>
								<ul>
									<li><a href="">Online</a></li>
									<li><a href="">Adventure</a></li>
									<li><a href="">S.F.</a></li>
									<li><a href="">Strategy</a></li>
									<li><a href="">Racing</a></li>
									<li><a href="">Shooter</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Games end-->

	<!-- Newsletter section -->
	<section class="newsletter-section">
		<div class="container">
			<h2>Subscribe to our newsletter</h2>
			<form class="newsletter-form">
				<input type="text" placeholder="ENTER YOUR E-MAIL">
				<button class="site-btn">subscribe  <img src="img/icons/double-arrow.png" alt="#"/></button>
			</form>
		</div>
	</section>
	<!-- Newsletter section end -->
	<!-- Login Section -->
	<!-- Button trigger modal -->

		<!-- Modal -->
		<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLongTitle">Login</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <form id="formulario" class="form alert-info p-5 text-center" action="login.php" method="POST">
                    <div class="form-group">
                        <label for="txtEmail">Email</label>
                        <input type="email" class="form-control" id="txtEmail" name="txtEmail">
                        <span id="spUsuario" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="txtPassword">Contraseña</label>
                        <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                        <span id="spPassword" class="text-danger"></span>
                    </div>
                    <button class="btn btn-primary" type="submit" id="btnIngresar" name="btnIngresar">Ingresar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
		      </div>
		    </div>
		  </div>
		</div>


	<!-- Footer section -->
	<footer class="footer-section">
		<div class="container">
			<div class="footer-left-pic">
				<img src="img/footer-left-pic.png" alt="">
			</div>
			<div class="footer-right-pic">
				<img src="img/footer-right-pic.png" alt="">
			</div>
			<a href="#" class="footer-logo">
				<img src="./img/logo.png" alt="">
			</a>
			<ul class="main-menu footer-menu">
				<li><a href="">Home</a></li>
				<li><a href="">Games</a></li>
				<li><a href="">Reviews</a></li>
				<li><a href="">News</a></li>
				<li><a href="">Contact</a></li>
			</ul>
			<div class="footer-social d-flex justify-content-center">
				<a href="#"><i class="fa fa-pinterest"></i></a>
				<a href="#"><i class="fa fa-facebook"></i></a>
				<a href="#"><i class="fa fa-twitter"></i></a>
				<a href="#"><i class="fa fa-dribbble"></i></a>
				<a href="#"><i class="fa fa-behance"></i></a>
			</div>
			<div class="copyright"><a href="">Colorlib</a> 2018 @ All rights reserved</div>
		</div>
	</footer>
	<!-- Footer section end -->
	
	<!--====== Javascripts & Jquery ======-->
	<script src="js/main.js"></script>

	<script>
		$(function(){
			//LISTADO POR LETRA
			var abecedario=['#','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
			var codigo="";
			$.each(abecedario,function(indice,valor){
				codigo+='<li><button class="btn" onclick="gamesLetter(\'' + valor + '\')">'+valor+'</button></li>';
			});
			$("#abecedario").html(codigo);
			$.ajax({
				url:"games_list.php",
				method:"POST",
				dataType:"json",
				data:{},
				success: function(games){
					console.log(games);
					codigo="";
					$.each(games,function(i,v){
						codigo+='<div class="col-lg-4 col-md-6">'+
							'<div class="game-item">'+
								'<img src="../nalika/img/covers/'+v.cover+'" alt="#">'+				
								'<h5>'+v.title+'</h5>'+
								'<h5>'+v.genre+'</h5>'+
								'<?php if (isset($_SESSION['loggedin'])) {?>'+
								'<a href="game-single.php?id='+v.id+'" class="read-more">Read More  <img src="img/icons/double-arrow.png" alt="#"/></a>'+
								'<?php } else { ?>'+
								'<a href="#" class="read-more">Read More  <img src="img/icons/double-arrow.png" alt="#"/></a>'+
								'<?php } ?>'+
							'</div>'+
						'</div>'
					})
					$("#games").html(codigo);

				},
				error: function(error){
					console.log(error);
				}

			})

		});
			function gamesLetter(letter){
				console.log(letter);
				$.ajax({
				url:"games_letter.php",
				method:"POST",
				dataType:"json",
				data:{letter:letter},
				success: function(games){
					console.log(games);
					codigo="";
					$.each(games,function(i,v){
						codigo+='<div class="col-lg-4 col-md-6">'+
							'<div class="game-item">'+
								'<img src="../nalika/img/covers/'+v.cover+'" alt="#">'+
								'<h5>'+v.title+'</h5>'+
								'<a href="game-single.html" class="read-more">Read More  <img src="img/icons/double-arrow.png" alt="#"/></a>'+
							'</div>'+
						'</div>'
					})
					$("#games").html(codigo);

					},
					error: function(error){
						console.log(error);
					}
				})
			}
            var msg = <?= $msg ?>;
            console.log(msg);
            if (msg==1) {
                alertify
				  .alert("This is an alert dialog.", function(){
				    alertify.message('OK');
				  });
            }
	</script>
		
	</body>
</html>

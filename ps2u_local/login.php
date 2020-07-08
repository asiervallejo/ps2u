<!DOCTYPE html>
<html lang="zxx">
<head>
	<title>PS2U Login</title>
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
				<a href="index.php">Home</a>  /
				<span>Login</span>
			</div>
		</div>
	</section>


	<section class="games-single-page">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-4">
					<form id="formLogin" name="formLogin" class="form p-5 text-center" action="loginUser.php" method="POST">
	                    <div class="form-group mb-5">
	                        <label for="txtEmail" hidden>Email</label>
	                        <input type="email" class="form-control" id="txtEmail" name="txtEmail"  placeholder="Your Email" required>
	                    </div>
	                    <div class="form-group mb-5">
	                        <label for="txtPassword" hidden>Contraseña</label>
	                        <input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="password" required>
	                    </div>
	                    <button class="btn btn-primary favoritos" type="submit" id="btnIngresar" name="btnIngresar">Login</button>
	                    <button type="reset" class="btn btn-secondary">Reset</button>
	        		</form>
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
	<script src="js/main.js"></script>
	</body>
</html>

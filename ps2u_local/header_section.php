	
	<header class="header-section">
		<div class="header-warp">
			<div class="header-social d-flex justify-content-end">
				<p>Follow us:</p>
				<a href="#"><i class="fa fa-pinterest"></i></a>
				<a href="#"><i class="fa fa-facebook"></i></a>
				<a href="#"><i class="fa fa-twitter"></i></a>
				<a href="#"><i class="fa fa-dribbble"></i></a>
				<a href="#"><i class="fa fa-behance"></i></a>
			</div>
			<div class="header-bar-warp d-flex">
				<!-- site logo -->
				<a href="index.php" class="site-logo">
					<img style="height: 36px; width: 199px" src="img/ps2_logo1.png" alt="">
				</a>
				<nav class="top-nav-area w-100">
					<div class="user-panel">
						<?php
							if ((!isset($_SESSION['loggedin']))||(!$_SESSION['loggedin'])) {
						?>
								<a href="login.php">Login</a>
								 / 
						 		<a href="register.php">Register</a>
						<?php
							} else {

						?>
								<a href="#"><?= $_SESSION['nick'] ?></a><br/>
								<a href="logout.php" class="text-warning">LogOut</a>
						<?php
							}
						?>

						 
					</div>
					<!-- Menu -->
					<ul class="main-menu primary-menu">
						<li><a href="index.php">Home</a></li>
						<li><a href="games.php">Games</a></li>
						<li><a href="contact.php">Contact</a></li>
						<?php
							if ((isset($_SESSION['loggedin']))&&($_SESSION['id_usuario']==6)) {
						?>
						<li><a href="../ps2u_admin/product-list.php" target="_blank">Admin</a></li>
						<?php
							} 
						?>

					</ul>
				</nav>
			</div>
		</div>
	</header>
	
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
				<a href="home.php" class="site-logo">
					<img style="height: 36px; width: 199px" src="img/ps2_logo1.png" alt="">
				</a>
				<nav class="top-nav-area w-100">
					<div class="user-panel">
						<?php
							if ((!isset($_SESSION['loggedin']))||(!$_SESSION['loggedin'])) {
						?>
								<a href="#" data-toggle="modal" data-target="#exampleModalLong">Login</a>
								 / 
						 		<a href="register.php">Register</a>
						<?php
							} else {

						?>
								<a href=""><?= $_SESSION['email'] ?></a><br/>
								<a href="logout.php" class="text-warning">LogOut</a>
						<?php
							}
						?>

						 
					</div>
					<!-- Menu -->
					<ul class="main-menu primary-menu">
						<li><a href="index.php">Home</a></li>
						<li><a href="games.php">Games</a>
							<ul class="sub-menu">
								<li><a href="game-single.html">Game Singel</a></li>
							</ul>
						</li>
						<li><a href="review.php">Reviews</a></li>
						<li><a href="blog.php">News</a></li>
						<li><a href="contact.php">Contact</a></li>
					</ul>
				</nav>
			</div>
		</div>
	</header>
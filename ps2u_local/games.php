<?php
	session_start();
	if (isset($_GET["msg"])) {
        $msg=$_GET["msg"];
    } else {
    	$msg=-1;
 	}


 	if (isset($_GET["msgRegister"])) {
        $msgRegister=$_GET["msgRegister"];
    } else {
    	$msgRegister=-1;
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
	<title>PS2U Games</title>
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

	<!-- Page top section -->
	<section class="page-top-section set-bg" data-setbg="img/page-top-bg/1.jpg">
		<div class="page-info">
			<h2>Games</h2>
			<div class="site-breadcrumb">
				<a href="index.php">Home</a>  /
				<a href="games.php"><span>Games</span></a>
			</div>
		</div>
	</section>
	<!-- Page top end-->

		<!-- Games section -->
	<section class="games-section">
		<div class="container">
			<ul id="abecedario" class="game-filter">

			</ul>	
			<div class="newsletter-form mb-5">
				<input class="text-uppercase" type="text" id="txtGameSearch" name="txtGameSearch" placeholder="Term of search" required>
				<button id="btnGameSearch" name="btnGameSearch" class="site-btn">search <img src="img/icons/double-arrow.png" alt="#"></button>
			</div>			
			<div class="row">
				<div class="col-xl-8 col-lg-8 col-md-7">
					<div id="games" name="games" class="row">
					</div>
					<div class="site-pagination row justify-content-center" id="pagGames" name="pagGames">
					</div>
				</div>
				<div class="col-xl-3 col-lg-4 col-md-5 sidebar game-page-sideber">
					<div id="stickySidebar">
						<div class="widget-item">
							<div class="categories-widget">
								<h4 class="widget-title">LISTS</h4>
								<ul class="text-center">
									<?php
										if (isset($_SESSION["loggedin"])) {
									?>
									<li><a href="#" id="btnFavoritos" name="btnFavoritos" href="">My Favourites</a></li>
									<?php
										}
									?>
									
									<li><a href="games.php">Games List</a></li>
									<li><a href="index.php">Top Games</a></li>
								</ul>
							</div>
						</div>
						<div class="widget-item">
							<a href="#" class="add">
								<img src="./img/add.jpg" alt="">
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Games end-->


	<!-- Footer section -->
	<?php include ("footer.html") ?>
	<!-- Footer section end -->
	
	<!--====== Javascripts & Jquery ======-->
	<script src="js/alertify.min.js"></script>
	<script src="js/sweetalert2.all.min.js"></script>
	<script src="js/main.js"></script>

	<script>
		var id= <?= $id ?>;
		$(function(){
			//LISTADO POR LETRA
			var abecedario=['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
			var codigo="";
			//Id del usuario, 0 en caso de no logeado
			

			//Rellenamos las letras para ordenar por letra
			$.each(abecedario,function(indice,valor){
				codigo+='<li><button class="btn abecedario" onclick="gamesLetter(\'' + valor + '\','+id+')">'+valor+'</button></li>';
			});
			$("#abecedario").html(codigo);
			pagGames();
			paginarLista(0);


			//Lista de juegos favoritos
	        $("#btnFavoritos").click(function(){
	        	pagFav(id);
	        	paginarFav(0);
	        })


        	//Buscar por palabra:
        	$("#btnGameSearch").click(function(){ 
        		gamesSearch();
			})


		});

			//Paginas Lista Completa
			function pagGames(){
				$.ajax({
					url:"pagination.php",
					method:"POST",
					dataType:"",
					data:{},
					success: function(paginas){
						console.log(paginas)
						if (paginas>1) {
							var codigo="";
							for (var i =1 ; i <= paginas; i++) {
								codigo+='<a ';
								if (i==1)
									codigo+=' class="active" ';	
								codigo+='onclick="paginarLista('+(i-1)+')" href="#">0'+i+'.</a>';
							}
							$("#pagGames").html(codigo);
						}else {
							$("#pagGames").html("");
						}
					},
					error: function(error){

					}
				});
			}
			//Paginas Lista Favoritos
			function pagFav(id){
				$.ajax({
					url:"paginationFav.php",
					method:"POST",
					dataType:"",
					data:{id:id},
					success: function(paginas){
						console.log("Paginas favoritos: "+paginas)
						if (paginas>1) {
							var codigo="";
							for (var i =1 ; i <= paginas; i++) {
								codigo+='<a ';
								if (i==1)
									codigo+=' class="active" ';	
								codigo+='onclick="paginarFav('+(i-1)+')" href="#">0'+i+'.</a>';
							}
							$("#pagGames").html(codigo);
						} else {
							$("#pagGames").html("");
						}
					},
					error: function(error){

					}
				});
			}
			//Lista completa de los juegos
			function paginarLista(pagina){
				$('#pagGames .active').removeClass("active");
				var pag=pagina+1;
				var pagClick=$("#pagGames > :nth-child("+pag+")");
				pagClick.addClass('active');
				$.ajax({
					url:"games_list.php",
					method:"POST",
					dataType:"json",
					data:{id:id, pagina:pagina},
					success: function(games){
						console.log(games);
						codigo="";
						$.each(games,function(i,v){
							codigo+='<div class="col-lg-4 col-md-6">'+
								'<div class="game-item">';
							var valoracion;
							if (!v.valoracion)
								valoracion=0
							else
								valoracion=v.valoracion;
							if (v.favorito==1) 
								codigo+= '<img class="w-25 corazon" src=img/icons/corazon.png>';

							codigo+='<img src="../ps2u_admin/img/covers/'+v.cover+'" alt="#">';
									if (valoracion>0)									 
	    								codigo+='<div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:'+((valoracion)*10)+'%">'+(valoracion).toFixed(1)+'</div></div>';
	    							else
										codigo+='<div class="progress"><div class="progress-bar notyetscored" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:0%">Not yet scored</div></div>';
	  												
									codigo+='<h5>'+v.title+'</h5>'+
									'<div class="genero">'+v.genre+'</div>'+
									'<?php if (isset($_SESSION['loggedin'])) {?>'+
									'<a href="game-single.php?id='+v.id+'" class="read-more">Read More  <img src="img/icons/double-arrow.png" alt="#"/></a>'+
									'<?php } else { ?>'+
									'<a onclick="mensaje()" href="#" class="read-more">Read More  <img src="img/icons/double-arrow.png" alt="#"/></a>'+
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
		}
			//Lista juegos favoritos del usuario
			function paginarFav(pagina){
				$("#games").html("");
				$('#pagGames .active').removeClass("active");
				var pag=pagina+1;
				var pagClick=$("#pagGames > :nth-child("+pag+")");
				pagClick.addClass('active');	
	        	$.ajax({
					url:"games_fav.php",
					method:"POST",
					dataType:"json",
					data:{id:id, pagina:pagina},
					success: function(games){
						console.log(games);
						codigo="";
						$.each(games,function(i,v){
							var valoracion;
							if (!v.valoracion)
								valoracion=0
							else
								valoracion=v.valoracion;
							codigo+='<div class="col-lg-4 col-md-6">'+
								'<div class="game-item">'+
									'<img class="w-25 corazon" src=img/icons/corazon.png>'+
									'<img src="../ps2u_admin/img/covers/'+v.cover+'" alt="#">';

									if (valoracion>0)									 
	    								codigo+='<div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:'+((valoracion)*10)+'%">'+(valoracion).toFixed(1)+'</div></div>';
	    							else
										codigo+='<div class="progress"><div class="progress-bar notyetscored" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:0%">Not yet scored</div></div>';

									codigo+='<h5>'+v.title+'</h5>'+
									'<div class="genero">'+v.genre+'</div>'+
									'<?php if (isset($_SESSION['loggedin'])) {?>'+
									'<a href="game-single.php?id='+v.id+'" class="read-more">Read More  <img src="img/icons/double-arrow.png" alt="#"/></a>'+
									'<?php } else { ?>'+
									'<a onclick="mensaje()" href="#" class="read-more">Read More  <img src="img/icons/double-arrow.png" alt="#"/></a>'+
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
	        }

			//Listar por letra
			function gamesLetter(letter,id){
				$("#games").html("");
				$("#pagGames").html("");
				console.log(letter);
				$.ajax({
				url:"games_letters.php",
				method:"POST",
				dataType:"json",
				data:{id:id,letter:letter},
				success: function(games){
					console.log(games);
					codigo="";
					$.each(games,function(i,v){
						var valoracion;
						if (!v.valoracion)
							valoracion=0
						else
							valoracion=v.valoracion;
						codigo+='<div class="col-lg-4 col-md-6">'+
							'<div class="game-item">';
						if (v.favorito==1) 
							codigo+= '<img class="w-25 corazon" src=img/icons/corazon.png>';

						codigo+='<img src="../ps2u_admin/img/covers/'+v.cover+'" alt="#">';	

									if (valoracion>0)									 
	    								codigo+='<div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:'+((valoracion)*10)+'%">'+(valoracion).toFixed(1)+'</div></div>';
	    							else
										codigo+='<div class="progress"><div class="progress-bar notyetscored" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:0%">Not yet scored</div></div>';	

								codigo+='<h5>'+v.title+'</h5>'+
								'<div class="genero">'+v.genre+'</div>'+
								'<?php if (isset($_SESSION['loggedin'])) {?>'+
								'<a href="game-single.php?id='+v.id+'" class="read-more">Read More  <img src="img/icons/double-arrow.png" alt="#"/></a>'+
								'<?php } else { ?>'+
								'<a onclick="mensaje()" href="#" class="read-more">Read More  <img src="img/icons/double-arrow.png" alt="#"/></a>'+
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
			}

			function gamesSearch(){ 
				
        		$("#pagGames").html("");
        		if ($("#txtGameSearch").val()=="") {
        			Swal.fire({
					  position:"top-end",	
					  icon: 'warning',
					  text: 'Please insert a term of search',
					  confirmButtonColor: '#501755',  
				  	  width:'250px'
					})
        		} else {  
        			$("#games").html("");        	
		        	$.ajax({
						url:"game_search.php",
						method:"POST",
						dataType:"json",
						data:{id:id, word:$("#txtGameSearch").val()},
						success: function(games){
							console.log(games);
							codigo="";
							$.each(games,function(i,v){
								codigo+='<div class="col-lg-4 col-md-6">'+
									'<div class="game-item">';
								var valoracion;
								if (!v.valoracion)
									valoracion=0
								else
									valoracion=v.valoracion;
								if (v.favorito==1) 
									codigo+= '<img class="w-25 corazon" src=img/icons/corazon.png>';

								codigo+='<img src="../ps2u_admin/img/covers/'+v.cover+'" alt="#">';

										if (valoracion>0)									 
		    								codigo+='<div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:'+((valoracion)*10)+'%">'+(valoracion).toFixed(1)+'</div></div>';
		    							else
											codigo+='<div class="progress"><div class="progress-bar notyetscored" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:0%">Not yet scored</div></div>';

										codigo+='<h5>'+v.title+'</h5>'+
										'<div class="genero">'+v.genre+'</div>'+
										'<?php if (isset($_SESSION['loggedin'])) {?>'+
										'<a href="game-single.php?id='+v.id+'" class="read-more">Read More  <img src="img/icons/double-arrow.png" alt="#"/></a>'+
										'<?php } else { ?>'+
										'<a onclick="mensaje()" href="#" class="read-more">Read More  <img src="img/icons/double-arrow.png" alt="#"/></a>'+
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
	        	}
	        }
			//Mensaje en caso de intentar a contenido para persona logeada
			function mensaje(){
				Swal.fire({
				  position:"top-end",	
				  icon: 'info',
				  text: 'You must be logged to access this content',
				  confirmButtonColor: '#501755',  
				  width:'250px'
				})
			}

			//Mensajes al logearse
            var msg = <?= $msg ?> ;
            console.log(msg);
            if (msg==1) {
            	Swal.fire({
				  position:"top-end",	
				  icon: 'error',
				  text: 'Invalid login or password, try it again',
				  confirmButtonColor: '#501755',  
				  width:'250px'
				}).then(function(){
					window.location.href="games.php";
				});

            } else if (msg==0){
            	Swal.fire({
				  position:"top-end",	
				  icon: 'success',
				  text: 'Correctly logged',
				  confirmButtonColor: '#501755',  
				  width:'250px'
				}).then(function(){
					window.location.href="games.php";
				})
            }

            //Mensajes al registrarse
            var msgRegister = <?= $msgRegister ?> ;
            console.log(msgRegister);
            if (msgRegister==1) {
            	Swal.fire({
				  position:"top-end",	
				  icon: 'success',
				  text: 'Correctly registered, please login',
				  confirmButtonColor: '#501755',  
				  width:'250px'
				}).then(function(){
					window.location.href="games.php";
				})
            } else if (msgRegister==0){
            	Swal.fire({
				  position:"top-end",	
				  icon: 'error',
				  text: 'There were a problem during registration, please try again',
				  confirmButtonColor: '#501755',  
				  width:'250px'
				}).then(function(){
					window.location.href="games.php";
				})	
            }

	</script>
		
	</body>
</html>

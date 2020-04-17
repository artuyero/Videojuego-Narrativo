<?php
	require_once '../DB_data.php';
	require_once 'FormularioRegistro.php';
?>

<!DOCTYPE HTML>
<html lang="ES">
	
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<link rel="stylesheet" type="text/css" href="registerstyle.css">

<head>
	<title>Registrar</title>
	<meta charset="utf-8" />
</head>
	<body>

	<nav title="Menu horizontal">
        <ul class="nav justify-content-center">
            <li class="nav-item">
                <a class="nav-link" href="../inicio.php">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../inicio.php#3">Minijuegos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../inicio.php#4">Descarga</a>
            </li>
<?php
            if (isset($_SESSION['login']) && $_SESSION['login'] === true){
?>
                <li class="nav-item">
                    <a class="nav-link" href="../web/MiPerfil.php">Mi perfil</a>
                </li>
                <li>
                    <a class="nav-link" href="../Logout.php">Cerrar Sesion</a>
                </li>
<?php
            }
?>
                <li class="nav-item">
                    <a class="nav-link"  onclick="modoAltoContraste()">Modo Alto Contraste</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"  onclick="modoNormal()">Modo Normal</a>
                </li>
                
        </ul>
	</nav>


	<div class="container-fluid">
	<p>&nbsp</p>
	<p>&nbsp</p>
		<div class="row">
				<div class="col-sm-4"></div>
				<div class="col-sm-4">
				<h1>Registrar</h1>
				<label><a id="a-login" href="Login.php"/> ¿Ya tienes cuenta? Accede haciendo clic aquí</a></label>	
				<?php	
				$form = new FormRegistro();
				$form->gestiona();
				?>
				</div>
				<div class="col-sm-4"></div>
			
		</div>
		<p>&nbsp</p>
			<p>&nbsp</p>
			<p>&nbsp</p>
		<br>
		<br>
	</div>

	
<?php
    require_once __DIR__ . '../footer.html';
?>

</body>
<script>

		function modoAltoContraste(){
			//Poner el menu a contraste alto
			$(".nav").css({"background-color": "black"});
			$("a").css({"color": "yellow"});


			//Poner ela pagina a alto contraste 
			$(".container-fluid").css({"background-color": "black","color":"yellow"});

			//Poner el footer a alto contraste 
			$(".page-footer").css({"background-color": "black","color":"yellow"});
			$(".list-group-item").css({"background-color": "black","color":"yellow"});
		}

		function modoNormal(){
		//Volver a modo normal 
			$(".nav").css({"background-color": "#591D77"});
			$("a").css({"color": "#F2F1EF"});

			$(".container-fluid").css({"background-color": "#9932CC","color":"#fefefe"});

			$(".page-footer").css({"background-color": "#591D77","color":"#fefefe"});
			$(".list-group-item").css({"background-color": "#9932CC","color":"#fefefe"});
		}



</script>


</html>
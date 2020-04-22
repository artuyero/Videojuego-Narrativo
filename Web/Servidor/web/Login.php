<?php
	require_once '../DB_data.php';
	require_once 'FormularioLogin.php';
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

    <link rel="stylesheet" type="text/css" href="mystyle.css">

    <script src="./js/cookies.js"></script>


<head>
<link rel="icon" type="image/x-icon" href="./imagenes/favicon.ico" />
	<title>Login</title>
		<meta charset="utf-8" />
</head>

<body>
		

<?php
    require_once './generic/header.php';
?>
	


	
	<div class="container-fluid">
    <p>&nbsp</p>
		<div class="row">
				<div class="col-sm-4"></div>
				<div class="col-sm-4">    
				<?php	
				$form = new FormLogin();
				$form->gestiona();
                ?>
                <p>&nbsp</p>
                <p>&nbsp</p>
		</div>
		<div class="col-sm-4"></div>
        </div>
        
	</div>



<?php
    require_once __DIR__ . './generic/footer.html';
?>
 

</body>
<script>

    $( document ).ready(function() {
            if (detectCookie("accesibility")){
            modoAltoContraste();
        }
        else{
            modoNormal();
        }
        });


    function modoAltoContraste(){
        //Poner el menu a contraste alto
        $(".nav").css({"background-color": "black"});
        $("a").css({"color": "yellow"});


        //Poner ela pagina a alto contraste 
        $(".container-fluid").css({"background-color": "black","color":"yellow"});

        //Poner el footer a alto contraste 
        $(".page-footer").css({"background-color": "black","color":"yellow"});
        $(".list-group-item").css({"background-color": "black","color":"yellow"});

        $('.nav-link').css({"background-color": "black"})

        setCookie("accesibility", 1, 1);

        $('.nav-link').hover(function(){
                $(this).css({"background-color": "dimgray"});
            }, function(){
                $(this).css({"background-color": "black"});
            });
    }

    function modoNormal(){
    //Volver a modo normal 
        $(".nav").css({"background-color": "#591D77"});
        $("a").css({"color": "#F2F1EF"});

        $(".container-fluid").css({"background-color": "#9932CC","color":"#fefefe"});

        $(".page-footer").css({"background-color": "#591D77","color":"#fefefe"});
        $(".list-group-item").css({"background-color": "#9932CC","color":"#fefefe"});

        $('.nav-link').css({"background-color": "#591D77"})


        removeCookie("accesibility");

        $('.nav-link').hover(function(){
                $(this).css({"background-color": "#9932CC"});
            }, function(){
                $(this).css({"background-color": "#591D77"});
            });

            $('#mode').prop('checked', true);
    }


            $('#mode').change(function() {
            if(this.checked) { 
                console.log("change");
                modoNormal();
            }
            else{
                modoAltoContraste();
            }
        });
</script>




</html>

        function modoAltoContraste(){

            //Poner el menu a contraste alto
            $(".navbar").css({"background-color": "black"});
            $("a").css({"color": "yellow"});
        
            $("#donwload-button").css({"background-color": "yellow","border-color":"yellow"});
            $("#descarga").css({"color": "black"});

            $("#button-red").css({"background-color": "yellow","border-color":"yellow"});
            $("#button-red").css({"color": "black"});

            //Poner ela pagina a alto contraste 
            $(".container-fluid").css({"background-color": "black","color":"yellow"});
            $(".leer-mas").css({"color": "blue"});

            //Poner el footer a alto contraste 
            $(".page-footer").css({"background-color": "black","color":"yellow"});
            $(".list-group-item").css({"background-color": "black","color":"yellow"});

            $('#mode').prop('checked', false);
            $('.table').css({"color":"yellow"});
            $('.table .thead-dark th').css({"color":"yellow"});

            $('#animation1').attr("src","./imagenes/animation2.gif");


            $(".nav-link").css('background-color', 'black');

            $('.nav-link').hover(function(){
                $(this).css({"color": "yellow","background-color": "black"});
            }, function(){
                $(this).css({"color": "yellow","background-color": "black"});
            });

            $('.nav-link').focus(function(){
                $(this).css({"color": "yellow","background-color": "black"});
            }, function(){
                $(this).css({"color": "yellow","background-color": "black"});
            });

            setCookie("accesibility", 1, 1);
  
        }

        function modoNormal(){
            //Volver a modo normal 
            $(".navbar").css({"background-color": "#591D77"});
         
            $("a").css({"color": "#F2F1EF"});

            $("#descarga").css({"color": "#fefefe"});
            $("#donwload-button").css({"background-color": "#c82333","border-color":"#bd2130"});
            
            $("#button-red").css({"background-color": "#c82333","border-color":"#bd2130"});
            $("#button-red").css({"color": "#fefefe"});

            $(".container-fluid").css({"background-color": "#9932CC","color":"#fefefe"});

            $(".page-footer").css({"background-color": "#591D77","color":"#fefefe"});
            $(".list-group-item").css({"background-color": "#9932CC","color":"#fefefe"});


            $(".leer-mas").css({"color": "#9932CC"});

            $("#reg").css({"color": "black"});
            $("#a-login").css({"color": "black"});

            $('.table').css({"color":"#fefefe"});
            $('.table .thead-dark th').css({"color":"#fefefe"});

            $('#animation1').attr("src","./imagenes/animation.gif");

            $(".nav-link").css('background-color', $(".navbar").css('background-color'));

            $('.nav-link').hover(function(){
                $(this).css({"color": "#fefefe","background-color": "#9932CC"});
            }, function(){
                $(this).css({"color": "#fefefe","background-color": $(".navbar").css('background-color')});
            });

            $('.nav-link').focus(function(){
                $(this).css({"color": "#fefefe","background-color": "#9932CC"});
            });
            $('.nav-link').focusout(function(){
                $(this).css({"color": "#fefefe","background-color": $(".navbar").css('background-color')});
            });

            $('#mode').prop('checked', true);


            removeCookie("accesibility");
        }

          

/*CONTROL DEL HEADER*/
var scroll_start = 0;
var startchange = $('footer');
var offset = startchange.offset();
if (startchange.length){
$(document).scroll(function() { 

    scroll_start = $(this).scrollTop();
    if(scroll_start > offset.top) {

       $(".cartas-minijuegos").show( "slide", 1000 );

        if (detectCookie("accesibility")){
            $('.navbar').css('background-color', 'black');
        }
        else{
        $(".navbar").css('background-color', '#9932CC');
        }
    } else {


        if (detectCookie("accesibility")){
            $('.navbar').css('background-color', 'black');
        }
        else{
        $('.navbar').css('background-color', '#591D77');
        }
        
    }
});
    };
<?php 
	if(!isset($_POST['id']) || !isset($_POST['ciudad'])) {header('Location:index.html');exit();}
	ini_set('display_errors',1);
	require_once("Connections/db.php");
	require_once("Connections/funciones.php");
	if (!isset($_SESSION['n_semanas']))$_SESSION['n_semanas']=1;
	if ($_SESSION['sess_idioma']=="esp") $idiomaT = 7;
	else  $idiomaT = 8;
	$ciudad = dato_tabla('paises_ciudades','nombre','id='.$_POST['ciudad'].' AND id_idioma='.$idiomaT);
	
	$academia_nombre = dato_tabla('academias','nombre','id='.$_POST['id']);
	//Me cargo las variables de session del formulario//
	 $_SESSION['for_nombre'] 	= NULL; unset($_SESSION['for_nombre']);
	 $_SESSION['for_direccion'] = NULL; unset($_SESSION['for_direccion']);
	 $_SESSION['for_provincia'] = NULL; unset($_SESSION['for_provincia']);
	 $_SESSION['for_email'] 	= NULL; unset($_SESSION['for_email']);
	 $_SESSION['for_apellidos'] = NULL; unset($_SESSION['for_apellidos']);
	 $_SESSION['for_ciudad'] 	= NULL; unset($_SESSION['for_ciudad']);
	 $_SESSION['for_pais'] 		= NULL; unset($_SESSION['for_pais']);
	 $_SESSION['for_telefono'] 	= NULL; unset($_SESSION['for_telefono']);
	//Fin //
	
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        
        <link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Vollkorn:400italic,400' rel='stylesheet' type='text/css'>
        <!-- Stylesheets -->
        <link href="css/ui-lightness/jquery-ui-1.10.2.custom.css" rel="stylesheet">
        
        <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="royalslider/royalslider.css">
        <link rel="stylesheet" href="royalslider/skins/minimal-white/rs-minimal-white.css">
        <link rel="stylesheet" href="css/tooltipster.css">
        <link rel="stylesheet" href="css/themes/tooltipster-light.css">
        
        <!--[if IE]>
            <link rel="stylesheet" href="css/ink-ie.css" type="text/css" media="screen" title="no title" charset="utf-8">
        <![endif]-->
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        <style>
        .seccionEscuela{
			display:none;
		}
		.acordeonEscuela ul{
			margin: 0;
			padding: 0;
			list-style-type: none;
		}
		.acordeonEscuela li{
			margin: 0;
			padding: 0;
			list-style-type: none;
		}
		.contenedorEEscuela{
			padding:20px;
			display: none;
		}
		.contenedorEEscuela .campoCurso {
			display: inline-block;
			font-family: 'Oswald',sans-serif;
			font-size: 15px;
			padding: 7px;
			width: 100%;
		}
        </style>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

	
	





        <!-- Add your site or application content here -->
       <div class="opcionesSuperiores">
<div class="navbar navbar-inverse navbar-static-top">
  <div class="navbar-inner">
    <ul class="nav pull-right">
      <li><a href="#">Sobre nosotros</a></li>
      <li><a href="#">¿Eres una escuela?</a></li>
      <li><a href="#">Contacto</a></li>
      <li class="dropdown">
    <a class="dropdown-toggle"
       data-toggle="dropdown"
       href="#">
        Idioma
        <b class="caret"></b>
      </a>
    <ul class="dropdown-menu">
      <li>aEnglish</li>
      <li>Spanish</li>
    </ul>
  </li>
    </ul>
  </div>
</div>
        </div>
        <form name="frm" id="frm" action="schools.php" method="post">
        <input type="hidden" id="idioma" name="idioma"  value="<?=$_POST['idioma']?>">
        <input type="hidden" id="PaisFinal" name="PaisFinal"        value="<?=$_POST['pais']?>">
        <input type="hidden" id="CiudadFinal" name="CiudadFinal"    value="<?=$_POST['ciudad']?>">
        <input type="hidden" id="IdiomaFinal" name="IdiomaFinal"    value="<?=$_POST['idioma']?>">
        <input type="hidden" id="pais" name="pais"      value="<?=$_POST['pais']?>">
        <input type="hidden" id="ciudad" name="ciudad"  value="<?=$_POST['ciudad']?>">
        <input type="hidden" id="nsemanas" name="nsemanas"  value="<?=$_POST['nsemanas']?>">
        <input type="hidden" id="max_precio" name="max_precio" value="<?=$_POST['max_precio']?>">
        <input type="hidden" id="max_alumnos" name="max_alumnos" value="<?=$_POST['max_alumnos']?>">
        <input type="hidden" id="max_clases" name="max_clases" value="<?=$_POST['max_clases']?>">
        <input type="hidden" id="tipo" name="tipo" value="<?=$_POST['tipo']?>">
        <input type="hidden" id="ord" name="ord" value="<?=$_POST['ord']?>">
        <input type="hidden" id="id" name="id" value="<?=$_POST['id']?>">
        <input type="hidden" id="semanas" name="semanas" value="<?=$_SESSION['n_semanas']?>">
    </form>
        <div class="contenedorGeneral">
            <div class="contenedorIzquierda">
                <div class="contenedorCarteraFichas">
                    <div class="contenidoCartera">
                        <div class="itemCarteraFichasCurso">
                            
                            <div class="contenedorSliderFichas">
                                <div class="sliderFichasColumna">
                                    <span class="textoCarteraOpcionesSliders">SEMANAS</span>
                                </div>
                                <div class="sliderFichasColumna margenColumnaSlider">
                                    <div class="contenedorSlider">  
                                        <div id="sliderSemanas" class="slider sliderSemanas"></div> <!-- the Slider -->
                                    </div> 
                                     <div class="etiquetaSlider margenEtiquetaSlider">
                                        <span class="ink-label" id="toolSemanas"><?=$_SESSION['n_semanas'];?></span>
                                    </div>
                                </div>

                                
                            </div>
                        </div>
                        <div id="carrito">
                        </div>
                       
                        
                        
                    </div>
                </div>
                <div class="ticketFichas">
                    <div class="ticketArriba"></div>
                    <div class="ticketAbajo ticketLogo">
                        <img src="img/logoTicket.png" height="63" width="98" alt="">
                    </div>
                
                    <div class="ticketAbajo ticketTxt2" id="ticketCiudad2">
                        <div class="separadorTicket"></div>
                        <p class="ticketTitular">Voy a divertirme en</p>
                        <p class="ticketSeleccion"><?=$ciudad?></p>
                        <div class="separadorTicket"></div>
                        <p class="ticketTitular">Voy a estudiar en</p>
                        <p class="ticketSeleccion"><?=$academia_nombre?></p>
                        <div class="separadorTicket"></div>
                        <button class="btn btn-danger botonPeque"  onClick="frm.submit();"><i class="icon-chevron-left"></i> Cambiar</button>
                    </div>
                    
                </div>
            </div>
            <div class="contenedorDerecha" id="contenedorDatos">
              
              
             
              

            </div>
        </div>
 
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.9.3/TweenMax.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.9.3/jquery.gsap.min.js"></script>
        <script class="rs-file" src="royalslider/jquery.royalslider.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/course.js"></script>
        
                <script>
		jQuery(document).ready(function($) {
		  	 $('#sliderSemanas').slider({
                value:$('#semanas').val()
			});
			$.ajax({  
				url: 'modulos/course/datos_academia.php?id='+$('#id').val()+'&idioma='+$('#idioma').val()+'&semanas='+$('#semanas').val(),
				success: function(data) {  
					$('.contenedorDerecha').html(data);
                    //slides para las fotos 
				}  
			}); 
			$.ajax({  
				url: 'modulos/course/seleccion.php',
				success: function(data) {  
					//$('#carrito').hide(); 
					$('#carrito').html(data);
					$('#carrito').show('slow');
                    //slides para las fotos 
				}  
			});   
		});
		function Volver(){
		$.ajax({  
				type: "POST",
				url: "schools.php",
				data: { idioma: $('#idioma').val(), pais: $('#pais').val(), ciudad:$('#ciudad').val(),ord:'precio' },
				success: function(data) {  
					
				}  
			});  
		
		}
        </script>
   

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
        
    </body>
</html>

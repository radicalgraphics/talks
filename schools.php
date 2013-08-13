<?php 
	if(!isset($_POST['IdiomaFinal']) || !isset($_POST['PaisFinal']) || !isset($_POST['CiudadFinal']) || empty($_POST['IdiomaFinal']) || empty($_POST['PaisFinal']) || empty($_POST['CiudadFinal']) ) {header('Location:index.html');exit();}

	require_once("Connections/db.php");
	require_once("Connections/funciones.php");
	if ($_SESSION['sess_idioma']=="esp") $idiomaT = 7;
	else  $idiomaT = 8;
	$ciudad = dato_tabla('paises_ciudades','nombre','id='.$_POST['CiudadFinal'].' AND id_idioma='.$idiomaT);
	resetear_cesta();
	/*Valores max y minimos de los slide */
	/*
	SELECT MAX(cursos.precio) FROM academias,cursos
	WHERE academias.codigoPais=28
	AND academias.idCiudad=660
	AND cursos.idioma=3
	AND academias.id = cursos.idAcademia
	*/
	$precio_max = dato_tabla('academias,cursos','MAX(cursos.precio)','academias.codigoPais='.$_POST['PaisFinal'].' AND academias.idCiudad='.$_POST['CiudadFinal'].' AND cursos.idioma='.$_POST['IdiomaFinal'].' AND academias.id = cursos.idAcademia');
	$precio_min = dato_tabla('academias,cursos','MIN(cursos.precio)','academias.codigoPais='.$_POST['PaisFinal'].' AND academias.idCiudad='.$_POST['CiudadFinal'].' AND cursos.idioma='.$_POST['IdiomaFinal'].' AND academias.id = cursos.idAcademia AND cursos.precio!="0.00"');
	
	$clases_max = dato_tabla('academias,cursos','MAX(cursos.clases_semanales)','academias.codigoPais='.$_POST['PaisFinal'].' AND academias.idCiudad='.$_POST['CiudadFinal'].' AND cursos.idioma='.$_POST['IdiomaFinal'].' AND academias.id = cursos.idAcademia');
	$clases_min = dato_tabla('academias,cursos','MIN(cursos.clases_semanales)','academias.codigoPais='.$_POST['PaisFinal'].' AND academias.idCiudad='.$_POST['CiudadFinal'].' AND cursos.idioma='.$_POST['IdiomaFinal'].' AND academias.id = cursos.idAcademia');

	$alumnos_max = dato_tabla('academias,cursos','MAX(cursos.maximo_alumnos)','academias.codigoPais='.$_POST['PaisFinal'].' AND academias.idCiudad='.$_POST['CiudadFinal'].' AND cursos.idioma='.$_POST['IdiomaFinal'].' AND academias.id = cursos.idAcademia');
	$alumnos_min = dato_tabla('academias,cursos','MIN(cursos.maximo_alumnos)','academias.codigoPais='.$_POST['PaisFinal'].' AND academias.idCiudad='.$_POST['CiudadFinal'].' AND cursos.idioma='.$_POST['IdiomaFinal'].' AND academias.id = cursos.idAcademia');

	//$min_precio = 0;
	//$max_precio = 0;
	

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
        
        <!--[if IE]>
            <link rel="stylesheet" href="css/ink-ie.css" type="text/css" media="screen" title="no title" charset="utf-8">
        <![endif]-->
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
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
        <form name="frm" id="frm" action="course.php" method="post">
        <input type="hidden" id="idioma" name="idioma"  value="<?=$_POST['IdiomaFinal']?>">
        <input type="hidden" id="pais" name="pais"      value="<?=$_POST['PaisFinal']?>">
        <input type="hidden" id="ciudad" name="ciudad"  value="<?=$_POST['CiudadFinal']?>">
        <input type="hidden" id="nsemanas" name="nsemanas"  value="0">
        <input type="hidden" id="max_precio" name="max_precio" value="0">
        <input type="hidden" id="max_alumnos" name="max_alumnos" value="0">
        <input type="hidden" id="max_clases" name="max_clases" value="0">
        <input type="hidden" id="tipo" name="tipo" value="0">
        <input type="hidden" id="ord" name="ord" value="comision">
        <input type="hidden" id="id" name="id" value="0">
        <input type="hidden" id="tipo_curso" name="tipo_curso" value="0">
    </form>
        <div class="contenedorGeneral">
            <div class="contenedorIzquierda">
                
                
                
                <div class="contenedorCarteraFichas">
                    <div class="contenidoCartera">
                         <div class="itemCarteraFichas">
                            <div class="contenedorSliderFichas">
                            <span class="textoCarteraOpcionesSliders">TIPO DE CURSO</span>
                                <select name="tipos" id="tipos" style="width:170px">
                                </select>
                            </div>
                        </div>
                         <div class="itemCarteraFichas">
                            <div class="separadorCarteraFichas"></div>
                        </div>
                        <div class="itemCarteraFichas">
                            <span class="textoCarteraOpcionesSliders">PRECIO MAX/SEMANA</span>
                            <div class="contenedorSliderFichas">
                                <div class="sliderFichasColumna">
                                    <img src="img/slider_precio.png" height="30" width="32" alt="Precio Máximo" title="Precio Máximo">
                                </div>
                                <div class="sliderFichasColumna">
                                    <div class="contenedorSlider">  
                                        <div id="sliderPrecio" class="slider"></div> <!-- the Slider -->
                                    </div> 
                                     <div class="etiquetaSlider">
                                        <span class="ink-label" id="toolPrecio"><?=round($precio_max)?>€</span>
                                    </div>
                                </div>

                                
                            </div>
                        </div>
                        <div class="itemCarteraFichas">
                            <div class="separadorCarteraFichas"></div>
                        </div>
                        <div class="itemCarteraFichas">
                            <span class="textoCarteraOpcionesSliders">MAX ALUMNOS/CLASE</span>
                            <div class="contenedorSliderFichas">
                                <div class="sliderFichasColumna">
                                    <img src="img/slider_alumnos.png" height="30" width="32" alt="Máximo de alumnos por clase">
                                </div>
                                <div class="sliderFichasColumna">
                                    <div class="contenedorSlider">  
                                        
                                        <div id="sliderAlumnos" class="slider"></div> <!-- the Slider -->
                                        <div class="etiquetaSlider">
                                        <span class="ink-label" id="toolAlumnos"><?=$alumnos_max?></span>
                                    </div>
                                    </div> 
                                </div>
                                
                            </div>
                        </div>
                        <div class="itemCarteraFichas">
                            <div class="separadorCarteraFichas"></div>
                        </div>

                        <div class="itemCarteraFichas">
                            <span class="textoCarteraOpcionesSliders">MAX CLASES/SEMANA</span>
                            <div class="contenedorSliderFichas">
                                <div class="sliderFichasColumna">
                                    <img src="img/slider_clases.png" height="30" width="32" alt="Máximo de clases por semana">
                                </div>
                                <div class="sliderFichasColumna">
                                    <div class="contenedorSlider">  
                                        
                                        <div id="sliderClases" class="slider"></div> <!-- the Slider -->
                                        <div class="etiquetaSlider">
                                        <span class="ink-label" id="toolClases"><?=$clases_max?></span>
                                    </div>
                                    </div> 
                                </div>
                                
                            </div>
                        </div>
                        
                       <!--
                        <div class="itemCarteraFichas">
                        <button class="ink-button warning" >Aplica los filtros</a>
                        </div>
                        -->
                    </div>
                </div>
                <div class="ticketFichas">
                    <div class="ticketArriba"></div>
                    <div class="ticketAbajo ticketLogo">
                        <img src="img/logoTicket.png" height="63" width="98" alt="">
                    </div>
                
                    <div class="ticketAbajo ticketTxt2" id="ticketCiudad2">
                        <div class="separadorTicket"></div>
                        <p class="ticketTitular">Voy a estudiar en</p>
                        <p class="ticketSeleccion"><?=$ciudad?></p>
                        <div class="separadorTicket"></div>
                        <button class="btn btn-danger botonPeque" onClick="window.open('index.html','_parent');"><i class="icon-chevron-left"></i> Cambiar</button>
                    
                    
                    </div>
                    
                </div>
            </div>
            <div class="contenedorDerecha">
              <div class="contenedorCabecera">
                <div class="contadorEscuelas">
                  HEMOS ENCONTRADO <span id="total_escuelas"></span> ESCUELAS
                </div>
                <div class="ordenEscuelas">
                  <div class="contenedorOrden">
                    Ordenar por: <span class="warning" id="sel_span0" ><i class="icon-caret-down" id="sel_i0"></i> DESTACADAS</span><span class="" id="sel_span1" ><i class="" id="sel_i1"></i> PRECIO</span> <span class="" id="sel_span2"><i class="" id="sel_i2"></i> VALORACION</span> <span class="" id="sel_span3"><i class="" id="sel_i3"></i> NOMBRE</span>
                  </div>
                </div>

              </div>
              <div class="separaGrande"></div>
              <div class="fichas">
                  <!--Aqui contenido escuelas-->
                  <img src="royalslider/skins/preloaders/preloader-white.gif" height="20" width="20" alt="">
              </div>
                
              

            </div>
        </div>
 
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.9.3/TweenMax.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.9.3/jquery.gsap.min.js"></script>
        <script class="rs-file" src="royalslider/jquery.royalslider.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/schools.js"></script>
        
   

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
        <script>
		jQuery(document).ready(function($) {
		$('#tipos').change(function(){
			$('#tipo_curso').val(this.value);
			$.ajax({  
				//url: 'modulos/schools/listado.php?idioma='+$('#idioma').val()+'&pais='+$('#pais').val()+'&ciudad='+$('#ciudad').val()+'&ord=nombre',
				url: 'modulos/schools/listado.php',  
				data:$('#frm').serialize(),
				success: function(result) {  
					$('.fichas').html(result);  
				}  
			});  
		});
		$('#sliderPrecio').slider({
                //Config
                range: "min",
                min:<?=$precio_min?>,
				max:<?=$precio_max?>,
				value:<?=$precio_max?>
				
		});
		$('#sliderClases').slider({
                //Config
                range: "min",
                min:<?=$clases_min?>,
				max:<?=$clases_max?>,
				value:<?=$clases_max?>
				
		});
		$('#sliderAlumnos').slider({
                //Config
                range: "min",
                min:<?=$alumnos_min?>,
				max:<?=$alumnos_max?>,
				value:<?=$alumnos_max?>
				
		});
		$('#sel_span0').click(function(){
			$('#sel_span0').addClass('warning');
			$('#sel_span1').removeClass("warning");
			$('#sel_span2').removeClass("warning");
			$('#sel_span3').removeClass("warning");
		
			$('#sel_i0').addClass("icon-caret-down");
			$('#sel_i1').removeClass("icon-caret-down");
			$('#sel_i2').removeClass("icon-caret-down");
			$('#sel_i3').removeClass("icon-caret-down");
			
			$('#ord').val('comision');
			$.ajax({  
				//url: 'modulos/schools/listado.php?idioma='+$('#idioma').val()+'&pais='+$('#pais').val()+'&ciudad='+$('#ciudad').val()+'&ord=nombre',
				url: 'modulos/schools/listado.php',  
				data:$('#frm').serialize(),
				success: function(result) {  
					$('.fichas').html(result);  
				}  
			});  
		});
		$('#sel_span1').click(function(){
			$('#sel_span1').addClass('warning');
			$('#sel_span0').removeClass("warning");
			$('#sel_span2').removeClass("warning");
			$('#sel_span3').removeClass("warning");
		
			$('#sel_i1').addClass("icon-caret-down");
			$('#sel_i0').removeClass("icon-caret-down");
			$('#sel_i2').removeClass("icon-caret-down");
			$('#sel_i3').removeClass("icon-caret-down");
			
			$('#ord').val('precio');
			$.ajax({  
				//url: 'modulos/schools/listado.php?idioma='+$('#idioma').val()+'&pais='+$('#pais').val()+'&ciudad='+$('#ciudad').val()+'&ord=nombre',
				url: 'modulos/schools/listado.php',  
				data:$('#frm').serialize(),
				success: function(result) {  
					$('.fichas').html(result);  
				}  
			});  
		});
		$('#sel_span2').click(function(){
			$('#sel_span2').addClass('warning');
			$('#sel_span0').removeClass("warning");
			$('#sel_span1').removeClass("warning");
			$('#sel_span3').removeClass("warning");
		
			$('#sel_i2').addClass("icon-caret-down");
			$('#sel_i0').removeClass("icon-caret-down");
			$('#sel_i1').removeClass("icon-caret-down");
			$('#sel_i3').removeClass("icon-caret-down");
			$('#ord').val('puntuacion');
			$.ajax({  
				//url: 'modulos/schools/listado.php?idioma='+$('#idioma').val()+'&pais='+$('#pais').val()+'&ciudad='+$('#ciudad').val()+'&ord=nombre',
				url: 'modulos/schools/listado.php',  
				data:$('#frm').serialize(),
				success: function(result) {  
					$('.fichas').html(result);  
				}  
			});  
		});
		$('#sel_span3').click(function(){
			$('#sel_span3').addClass('warning');
			$('#sel_span0').removeClass("warning");
			$('#sel_span2').removeClass("warning");
			$('#sel_span1').removeClass("warning");
		
			$('#sel_i3').addClass("icon-caret-down");
			$('#sel_i2').removeClass("icon-caret-down");
			$('#sel_i1').removeClass("icon-caret-down");
			$('#sel_i0').removeClass("icon-caret-down");
			
			$('#ord').val('nombre');
			$.ajax({  
				//url: 'modulos/schools/listado.php?idioma='+$('#idioma').val()+'&pais='+$('#pais').val()+'&ciudad='+$('#ciudad').val()+'&ord=nombre',
				url: 'modulos/schools/listado.php',  
				data:$('#frm').serialize(),
				success: function(result) {  
					$('.fichas').html(result);  
				}  
			});  
		});
	
			//Idiomas
			$.ajax({  
				url: 'modulos/ajax/listado_tipos.php',  
				success: function(data) {  
					$('#tipos').html(data);  
				}  
			});  
			$.ajax({  
				url: 'modulos/schools/listado.php?idioma='+$('#idioma').val()+'&pais='+$('#pais').val()+'&ciudad='+$('#ciudad').val()+'&ord='+$('#ord').val(),
				success: function(data) {  
                    
					$('.fichas').html(data); 
				}  
			});  
			$.ajax({  
				url: 'modulos/schools/nschools.php?idioma='+$('#idioma').val()+'&pais='+$('#pais').val()+'&ciudad='+$('#ciudad').val()+'&ord=precio',
				success: function(data) {  
					$('#total_escuelas').html(data);
                    //slides para las fotos 
				}  
			});  
		});
		
		
        </script>
    </body>
</html>

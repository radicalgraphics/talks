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
        <link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
        <!-- Stylesheets -->
        <link href="css/ui-lightness/jquery-ui-1.10.2.custom.css" rel="stylesheet">
        <link rel="stylesheet" href="css/font-awesome.min.css">
       
        <link rel="stylesheet" href="royalslider/royalslider.css">
        <link rel="stylesheet" href="royalslider/skins/minimal-white/rs-minimal-white.css">
        <link rel="stylesheet" href="css/tooltipster.css">
        <link rel="stylesheet" href="css/themes/tooltipster-light.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        
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
            <div class="btn-group">
  <button class="btn">Left</button>
  <button class="btn">Middle</button>
  <button class="btn">Right</button>    

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

        </div>
        <div class="contenedorGeneral">
            <div class="contenedorIzquierda">
                <div class="papel papelCurso">
                    <div class="fondoPapel">
                    <img src="img/fondoPapelCiudad.png" height="160" width="224" alt="">
                </div>
                    <div class="cierrapapel"><i class="icon-remove-sign"></i></div>
                     <div class="listaPapel" id="lista_tipos">
                       <ul>
                          <!-- <li value="1">Inglaterra</li>
                           <li value="2">España</li>
                           <li value="3">Italia</li>
                           -->
                      </ul>
                     </div>
                </div>
                
                
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
                                        <span class="ink-label warning" id="toolSemanas"><?=$_SESSION['n_semanas'];?></span>
                                    </div>
                                </div>

                                
                            </div>
                        </div>
                        <div id="carrito">
                            <div class="NuevoContenedorLinea">
                                <div class="NuevoPapelera"><i class="icon-trash"></i></div>
                                <div class="NuevoContenedorDerecha">
                                  <div class="NuevoDerechaArriba">
                                    PREPARACIÓN PARA EXÁMENES
                                </div>
                                <div class="NuevoContendedorDerechaAbajo">
                                    <div class="NuevoDerechaAbajo">
                                    20 clases semanales
                                </div>  
                                <div class="NuevoDerechaPrecio">
                                    300€
                                </div>
                                </div>
                                  
                                </div>
                                
                            </div>
                            <div class="NuevoContenedorLinea2">
                                <div class="NuevoPapelera"><i class="icon-trash"></i></div>
                                <div class="NuevoContenedorDerecha">
                                  <div class="NuevoDerechaArriba2">
                                    APARTAMENTO O ESTUDIO
                                </div>
                                <div class="NuevoContendedorDerechaAbajo">
                                    <div class="NuevoDerechaAbajo">
                                    1 persona / habitación
                                </div>  
                                <div class="NuevoDerechaPrecio">
                                    300€
                                </div>
                                </div>
                                  
                                </div>
                                
                            </div>
                            <div class="NuevoContenedorLinea3">
                                <div class="NuevoL3Arriba">TOTAL RESERVA: 57€</div>
                                <div class="NuevoL3Abajo">MÁS TARDE PAGAS: 270€</div>
                            </div>
                            <div class="NuevoContenedorBoton">
                             <button class="btn btn-large btn-warning" type="button">COMPLETA TU RESERVA</button>   
                            </div>
                            
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
                        <button class="btn btn-danger"  onClick="frm.submit();"><i class="icon-chevron-left"></i> Cambiar</button>
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
   

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
        
    </body>
</html>

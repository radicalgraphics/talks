<?php 
	//if(!isset($_POST['id']) || !isset($_POST['ciudad'])) {header('Location:index.html');exit();}
	ini_set('display_errors',1);
	require_once("Connections/db.php");
	require_once("Connections/funciones.php");
	require_once("modulos/carrito/contenido.php");
	
	if ($_SESSION['sess_idioma']=="esp") $idiomaT = 7;
	else  $idiomaT = 8;
	
	$nombre_ciudad = dato_tabla('paises_ciudades','nombre','id='.$_SESSION['ciudad'].' AND id_idioma='.$idiomaT);
	$nombre_academia = dato_tabla('academias','nombre','id='.$_SESSION['id']);
	
	
	
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
        <link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
        <!-- Stylesheets -->
        <link href="css/ui-lightness/jquery-ui-1.10.2.custom.css" rel="stylesheet">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/tooltipster.css">
        <link rel="stylesheet" href="css/themes/tooltipster-light.css">
        <link rel="stylesheet" href="css/animate-custom.css">
        
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
        <div class="contenedorGeneral">
            <div class="contenedorIzquierda">
             
                
                
                <div class="contenedorCarteraCarrito">
                    <div class="contenidoCartera">
                     <div class="completa">
                         COMPLETA LOS DATOS DE TU RESERVA <br>
<i class="icon-hand-right icon-3x"></i><br><br>
<button class="btn btn-danger" onClick="frm.submit();"><i class="icon-chevron-left"></i> Cambiar</button>
                     </div>
                    </div>
                </div>
                
            </div>
            <div class="contenedorDerecha">
              <div class="contenedorCarrito">
                  <div class="carritoSuperior">
                      <img src="img/carritoSuperior.png" height="36" width="685" alt="">
                  </div>
                  <div class="carritoCuerpo">
                      <div class="carritoLogo">
                        <div class="elLogo">
                         <img src="img/logoGrande.png" height="80" width="126" alt=""> 
                        </div>
                        <div class="elSello">
                            <?=$nombre_ciudad?>
                        </div>
                          
                      </div>
                      <div class="errorCompra" <?php if (isset($_GET['error']) && $_GET['error']==1) echo "style='display:block'"; ?>>
                          <div class="alert alert-error" >
<b>ERROR CON TU PAGO:</b> por favor inténtalo de nuevo
</div>
                      </div>
                      <div class="carritoLinea">
                          <div class="carritoConceptoTitulo">TU CURSO</div>
                          <div class="carritoConceptoDetalleContenedor">
                            <div class="carritoConceptoDetalle">
                                <?=$nombre_curso?> / <?=$nombre_academia?> / <?=$nombre_ciudad?> / <?=$_SESSION['semanas']?> WEEK(S)
                            </div>
                            <div class="carritoConceptoPrecio">
                                <?=$precio?>€
                            </div>
                              
                          </div>
                      </div>
                      <?php if(trim($nombre_alojamiento)!=""){?>
                      <div class="carritoLinea">
                          <div class="carritoConceptoTitulo">TU ALOJAMIENTO</div>
                          <div class="carritoConceptoDetalleContenedor">
                            <div class="carritoConceptoDetalle">
                                <?=$nombre_alojamiento?> / <?=$nombre_ciudad?>
                            </div>
                            <dib class="carritoConceptoPrecio">
                                <?=$precio2?>€
                            </dib>
                              
                          </div>
                      </div>
                      <?php }?>
                      <div class="carritoLineaTotal">
                          TOTAL: <span class="negroTotal"><?=$total?>€</span>
                      </div>
                      <div class="sombraCarrito">
                          <img src="img/sombraCarrito.png" height="27" width="685" alt="">
                      </div>
                      	<form name="frm" id="frm" action="course.php" method="post">
                            <input type="hidden" id="idioma" name="idioma"  value="<?=$_SESSION['idioma']?>">
                            <input type="hidden" id="PaisFinal" name="PaisFinal"        value="<?=$_SESSION['pais']?>">
                            <input type="hidden" id="CiudadFinal" name="CiudadFinal"    value="<?=$_SESSION['ciudad']?>">
                            <input type="hidden" id="IdiomaFinal" name="IdiomaFinal"    value="<?=$_SESSION['idioma']?>">
                            <input type="hidden" id="pais" name="pais"      value="<?=$_SESSION['pais']?>">
                            <input type="hidden" id="ciudad" name="ciudad"  value="<?=$_SESSION['ciudad']?>">
                            <input type="hidden" id="nsemanas" name="nsemanas"  value="<?=$_SESSION['nsemanas']?>">
                            <input type="hidden" id="max_precio" name="max_precio" value="<?=$_SESSION['max_precio']?>">
                            <input type="hidden" id="max_alumnos" name="max_alumnos" value="<?=$_SESSION['max_alumnos']?>">
                            <input type="hidden" id="max_clases" name="max_clases" value="<?=$_SESSION['max_clases']?>">
                            <input type="hidden" id="tipo" name="tipo" value="<?=$_SESSION['tipo']?>">
                            <input type="hidden" id="ord" name="ord" value="<?=$_SESSION['ord']?>">
                            <input type="hidden" id="id" name="id" value="<?=$_SESSION['id']?>">
                            <input type="hidden" id="semanas" name="semanas" value="<?=$_SESSION['semanas']?>">
                        </form>
                    <form class="ink-form block" name="frm_for" id="frm_for" method="post" action="modulos/carrito/enviar_a_paypal.php">
                      <div class="datosUsuario">
                        <div class="datosUsuarioC1">
                            <fieldset>
                              <div class="control">
                                <label for="for_nombre">Nombre</label>
                                <input name="for_nombre" type="text" id="for_nombre" value="<?=$_SESSION['for_nombre']?>">
                                </div>
                          </fieldset>
                                <fieldset>
                                <div class="control">
                                  <label for="for_direccion">Dirección</label>
                                  <input name="for_direccion" type="text" id="for_direccion" value="<?=$_SESSION['for_direccion']?>">
                                </div>
                              </fieldset>
                                <fieldset>
                                <div class="control">
                                  <label for="for_provincia">Provincia</label>
                                  <input name="for_provincia" type="text" id="for_provincia" value="<?=$_SESSION['for_provincia']?>"></input>
                                </div>
                              </fieldset>
                                 <fieldset>
                                <div class="control">
                                  <label for="for_email">Email</label>
                                  <input name="for_email" type="text" id="for_email" value="<?=$_SESSION['for_email']?>"></input>
                                </div>
                              </fieldset>
                                                    </div>
                                                    <div class="datosUsuarioC2">
                                                        <fieldset>
                                <div class="control">
                                  <label for="for_apellidos">Apellidos</label>
                                  <input name="for_apellidos" type="text" id="for_apellidos" value="<?=$_SESSION['for_apellidos']?>">
                                </div>
                              </fieldset>
                                <fieldset>
                                <div class="control">
                                  <label for="for_ciudad">Ciudad</label>
                                  <input name="for_ciudad" type="text" id="for_ciudad" value="<?=$_SESSION['for_ciudad']?>">
                                </div>
                              </fieldset>
                            
                                                        <fieldset>
                                <div class="control">
                                  <label for="for_pais">País</label>
                                  <input name="for_pais" type="text" id="for_pais" value="<?=$_SESSION['for_pais']?>">
                                </div>
                              </fieldset>
                                 <fieldset>
                                <div class="control">
                                  <label for="inputId">Telefono
                                    <input name="for_telefono" type="text" id="for_telefono" value="<?=$_SESSION['for_telefono']?>">
                                  </label>
                                  </input>
                                </div>
                              </fieldset>
                                                    </div>
                                                  </div>
                              </form>
                                              <div class="compra">
                                                <div class="condicionesCarrito">
                                                    <label class="checkbox">
                                  <input type="checkbox" name="acepto" id="acepto" value="1"> Acepto las condiciones y la política de privacidad
                                </label>
                    </div>
                      <div class="botonCompra">
                          <button class="btn btn-success btn-large" id="enviar_a_paypal">PAGAR <?=$apagar?>€ DE RESERVA CON TARJETA O PAYPAL</button>
                      </div>
                      <div class="restoCompra">
                          LOS RESTANTES <?=$falta?>€ SE LO PAGARÁS DIRECTAMENTE A LA ESCUELA
                          <br>
                          <!-- PayPal Logo --><table border="0" cellpadding="10" cellspacing="0" align="center"><tr><td align="center"></td></tr><tr><td align="center"><a href="https://www.paypal.com/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;"><img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_SbyPP_mc_vs_dc_ae.jpg" border="0" alt="PayPal Acceptance Mark"></a></td></tr></table><!-- PayPal Logo -->
                          <br>
                          <br>
                      </div>
                  </div>
                  </div>
              </div>
              <div class="carritoInferior">
                      <img src="img/carritoInferior.png" height="36" width="685" alt="">
                  </div>
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
        <script src="js/carrito.js"></script>
        

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
        <script>
			jQuery(document).ready(function($) {
				 $('#enviar_a_paypal').click(function() {
					 
					if ( $('#for_nombre').val()=="" || $('#for_apellidos').val()=="" || $('#for_direccion').val()=="" || $('#for_email').val()=="" || $('#for_telefono').val()=="" || $('#for_provincia').val()=="" || $('#for_ciudad').val()=="" || $('#for_pais').val()=="" ){
						alert('Rellene todos los campos');
					}else if ( $('#acepto:checked').val()!=1){
						alert('Debe aceptar las condiciones y politica de privacidad');
					}else{
						frm_for.submit();
					}
				});
			});
        
        
        
        </script>
        
    </body>
</html>

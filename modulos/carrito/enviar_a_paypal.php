<?php 
	session_start();
	require_once("../../Connections/db.php");
	require_once("../../Connections/funciones.php");
	 $_SESSION['for_nombre'] = $_POST['for_nombre'];
	 $_SESSION['for_direccion'] = $_POST['for_direccion'];
	 $_SESSION['for_provincia'] = $_POST['for_provincia'];
	 $_SESSION['for_email'] = $_POST['for_email'];
	 $_SESSION['for_apellidos'] = $_POST['for_apellidos'];
	 $_SESSION['for_ciudad'] = $_POST['for_ciudad'];
	 $_SESSION['for_pais'] = $_POST['for_pais'];
	 $_SESSION['for_telefono'] = $_POST['for_telefono'];

	$codigo = date('Ymd - hi - s');
	$url_ok ="http://www.talkandtrips.com/preproduccion/carrito_ok.php";
    $url_ko ="http://www.talkandtrips.com/preproduccion/carrito.php?error=1";
	if ($_SESSION['sess_idioma']=="esp") $idiomaT = 7;
	else  $idiomaT = 8; 
	
    $_SESSION['sess_codigo'] = $codigo;
	
	$idTipo = dato_tabla("cursos",'tipo',"id=".$_SESSION['id_curso']);
	
	$nombre_ciudad = dato_tabla('paises_ciudades','nombre','id='.$_SESSION['ciudad'].' AND id_idioma='.$idiomaT);
	
	if (!empty($_SESSION['id_alojamiento'])){
		$idTipo2 = dato_tabla("alojamientos","tipo","id=".$_SESSION['id_alojamiento']); 
		$nombre_alojamiento = trim(dato_tabla("alojamientos_tipos",$_SESSION['sess_idioma'],"id=".$idTipo2)); 
	}
	$nombre_academia = dato_tabla('academias','nombre','id='.$_SESSION['id']);
	$nombre_curso = dato_tabla("cursos_tipos",$_SESSION['sess_idioma'],"id=".$idTipo);
	

?>
<html>
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
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/font-awesome.min.css">
        <link rel="stylesheet" href="../../css/main.css">
        
        <!--[if IE]>
            <link rel="stylesheet" href="css/ink-ie.css" type="text/css" media="screen" title="no title" charset="utf-8">
        <![endif]-->
        <link rel="stylesheet" href="css/main.css">
    </head>
<body onLoad="document.frm_paypal.submit();">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="frm_paypal" >
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="jorge@talkandtrips.com">
    <input type="hidden" name="lc" value="ES">
                                                   
    <input type="hidden" name="item_name" value="<?=$_SESSION['for_nombre']?> <?=$_SESSION['for_apellidos']?>/<?=$nombre_curso?> / <?=$nombre_academia?> / <?=$nombre_ciudad?> / <?=$_SESSION['semanas']?>/<?=$nombre_alojamiento?> ">
    <input type="hidden" name="item_number" value="1">
    <input type="hidden" name="amount" value="<?=$_SESSION['sess_apagar']?>">
    <input type="hidden" name="currency_code" value="EUR">
    <input type="hidden" name="button_subtype" value="services">
    <input type="hidden" name="return" value="<?=$url_ok?>"> 
    <input type="hidden" name="cancel_return" value="<?=$url_ko?>"> 
    <input type="hidden" name="no_note" value="0">
    <input type="hidden" name="bn" value="PP-ShopCartBF:boton_s_paso.jpg:NonHostedGuest">

</form>
<div class="cargandoPaypal">
	<p>Contectando con paypal de forma segura</p>
	<div class="progress progress-striped active">
  <div class="bar" style="width: 0%;"></div>
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
        
<script>
jQuery(document).ready(function($) {
	$('.bar').animate({
    width: '100%'
  }, 5000, function() {

  });// Stuff to do as soon as the DOM is ready;
});

</script>
</body>
</html>
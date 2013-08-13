jQuery(document).ready(function($) {



var sIdioma=0;
var sPais=0;
var sCiudad=0;
//MENU
function activarMenu(){

//OVERS
	$('#menuIdioma').mouseenter(function(){
		TweenLite.to($(this), 0.3, {x:+10});
		TweenLite.to($('.papelIdioma'), 0.3, {x:+10, rotation:3});
	});

	$('#menuIdioma').mouseleave(function(){
		TweenLite.to($(this), 0.3, {x:0});
		TweenLite.to($('.papelIdioma'), 0.3, {x:0, rotation:0});
	});

	$('#menuPais').mouseenter(function(){
		TweenLite.to($(this), 0.3, {x:+10});
		TweenLite.to($('.papelPais'), 0.3, {x:+10, rotation:3});
	});

	$('#menuPais').mouseleave(function(){
		TweenLite.to($(this), 0.3, {x:0});
		TweenLite.to($('.papelPais'), 0.3, {x:0, rotation:0});
	});

	$('#menuCiudad').mouseenter(function(){
		TweenLite.to($(this), 0.3, {x:+10});
		TweenLite.to($('.papelCiudad'), 0.3, {x:+10, rotation:3});
	});

	$('#menuCiudad').mouseleave(function(){
		TweenLite.to($(this), 0.3, {x:0});
		TweenLite.to($('.papelCiudad'), 0.3, {x:0, rotation:0});
	});

//CLICKS

	$('#menuIdioma').click(function(){
		$(this).parent().css('background-image','url(./img/fondoMenu.png)');
		TweenLite.to($(this), 0.3, {x:+10});
		TweenLite.to($('.papelIdioma'), 0.3, {x:+200});
		$('.contenidoItem').unbind('mouseleave');
		$('.contenidoItem').unbind('mouseenter');
		$('.contenidoItem').unbind('click');
	});

	$('#menuPais').click(function(){
		$(this).parent().css('background-image','url(./img/fondoMenu.png)');
		TweenLite.to($(this), 0.3, {x:+10});
		TweenLite.to($('.papelPais'), 0.3, {x:+200});
		$('.contenidoItem').unbind('mouseleave');
		$('.contenidoItem').unbind('mouseenter');
		$('.contenidoItem').unbind('click');

	});

	$('#menuCiudad').click(function(){
		$(this).parent().css('background-image','url(./img/fondoMenu.png)');
		TweenLite.to($(this), 0.3, {x:+10});
		TweenLite.to($('.papelCiudad'), 0.3, {x:+200});
		$('.contenidoItem').unbind('mouseleave');
		$('.contenidoItem').unbind('mouseenter');
		$('.contenidoItem').unbind('click');

	});
}



//CLICKS PAPEL

$('.cierrapapel').click(function(){
$('.itemCarteraHome').css('background-image','none');
	TweenLite.to($('.contenidoItem'), 0.3, {x:0});
	TweenLite.to($(this).parent(), 0.3, {x:0, rotation:0});
	activarMenu();
});

$('.listaPapel ul>li').click(function(){
$('.itemCarteraHome').css('background-image','none');
	TweenLite.to($('.contenidoItem'), 0.3, {x:0});
	TweenLite.to($(this).parent().parent().parent(), 0.3, {x:0, rotation:0});
	activarMenu();

	if ($(this).parent().parent().parent().hasClass('papelIdioma')){
		$('#lista2').html('<div class="preloaderlista1"><img src="royalslider/skins/preloaders/preloader.gif" height="20" width="20" alt=""></div>');
		$('#ticketIdioma .ticketSeleccion').html($(this).html());
		$('#IdiomaFinal').val($(this).attr('valor'));
		$('#lista3').html('');
		var actual=$(this).attr('valor');
		function cargaPaises(){
			$.ajax({  
				url: 'modulos/ajax/pais_seleccionado.php?idioma='+actual,  
				success: function(data) {  
					$('#lista2').html(data);  
				}  
			}); 
		}
		$('#ticketIdioma').slideDown("slow", cargaPaises);
		
		
	}

	if ($(this).parent().parent().parent().hasClass('papelPais')){
		$('#lista3').html('<div class="preloaderlista1"><img src="royalslider/skins/preloaders/preloader.gif" height="20" width="20" alt=""></div>');
		$('#ticketPais .ticketSeleccion').html($(this).html());
		$('#PaisFinal').val($(this).attr('valor'));
		var actual=$(this).attr('valor');
		function cargaCiudades(){
			$.ajax({  
				url: 'modulos/ajax/ciudad_seleccionada.php?idioma='+$('#IdiomaFinal').val()+'&pais='+actual,  
				success: function(data) {  
					$('#lista3').html(data);  
				}  
			}); 
		}
		$('#ticketPais').slideDown("slow", cargaCiudades);
		

		
		 
	}

	if ($(this).parent().parent().parent().hasClass('papelCiudad')){
		$('#ticketCiudad').slideDown("slow");
		$('#ticketCiudad .ticketSeleccion').html($(this).html());
		$('#CiudadFinal').val($(this).attr('valor'));
	}
});

//ACCIONES INICIALES
//Maneja el fondo de la página
$.backstretch("./img/fondo1.jpg");

activarMenu();


});

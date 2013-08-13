jQuery(document).ready(function($) {


var seccionActual=1;
var fotosOcultas=0;
//ACCIONES INICIALES
//Maneja el fondo de la página
$.backstretch("./img/fondo.jpg");
$('.tooltiptalk').tooltipster({
  theme: '.tooltipster-light'
});

$('.acordeonCursos').find('.contenedorCCurso:first').slideToggle();
$('.acordeonAloja').find('.contenedorAAloja:first').slideToggle();
$('.acordeonEscuela').find('.contenedorEEscuela:first').slideToggle();
//acordeon de cursos
$('.cabeceraCurso').each(function(){
  var $content = $(this).closest('li').find('.contenedorCCurso');
  $(this).click(function(e){
    e.preventDefault();
    $content.not(':animated').slideToggle();
  });
});

$('.cabeceraAloja').each(function(){
  var $content = $(this).closest('li').find('.contenedorAAloja');
  $(this).click(function(e){
    e.preventDefault();
    $content.not(':animated').slideToggle();
  });
});
//slider fotos
 $('.paginaCursosFotos').royalSlider({
    autoScaleSlider: true,
    loop: false,
    imageScaleMode: 'fill',
    navigateByClick: true,
    numImagesToPreload:5,
    arrowsNav:true,
    arrowsNavAutoHide: true,
    arrowsNavHideOnTouch: true,
    keyboardNavEnabled: true,
    fadeinLoadedSlide: true,
    usePreloader:true,
    controlNavigation:'none'
  });

 //comportamientos menu

$('#menuCursos').click(function(){
$(this).find('span').addClass('warning');

	if (seccionActual==2){
		$('#menuOpiniones').find('span').removeClass('warning');
		$('.seccionOpiniones').toggle();
		$('.seccionCursos').toggle();
	}
	
	if (seccionActual==3){
		$('#menuAlojamientos').find('span').removeClass('warning');
		$('.seccionAlojamientos').toggle();
		$('.seccionCursos').toggle();
	}
	if (seccionActual==4){
		$('#menuEscuela').find('span').removeClass('warning');
		$('.seccionEscuela').toggle();
		$('.seccionCursos').toggle();
	}
	
	seccionActual=1;

});

$('#menuOpiniones').click(function(){
	$(this).find('span').addClass('warning');
	
	if (seccionActual==1){
		$('#menuCursos').find('span').removeClass('warning');
		$('.seccionCursos').toggle();
		$('.seccionOpiniones').toggle();
	}
	
	if (seccionActual==3){
		$('#menuAlojamientos').find('span').removeClass('warning');
		$('.seccionAlojamientos').toggle();
		$('.seccionOpiniones').toggle();
	}
	if (seccionActual==4){
		$('#menuEscuela').find('span').removeClass('warning');
		$('.seccionEscuela').toggle();
		$('.seccionOpiniones').toggle();
	}
	
	seccionActual=2;

});

$('#menuAlojamientos').click(function(){
	$(this).find('span').addClass('warning');
	
	if (seccionActual==1){
		$('#menuCursos').find('span').removeClass('warning');
		$('.seccionCursos').toggle();
		$('.seccionAlojamientos').toggle();
	}
	
	if (seccionActual==2){
		$('#menuOpiniones').find('span').removeClass('warning');
		$('.seccionOpiniones').toggle();
		$('.seccionAlojamientos').toggle();
	}
	if (seccionActual==4){
		$('#menuEscuela').find('span').removeClass('warning');
		$('.seccionEscuela').toggle();
		$('.seccionAlojamientos').toggle();
	}
	
	seccionActual=3;

});

$('#menuEscuela').click(function(){
	$(this).find('span').addClass('warning');
	
	if (seccionActual==1){
		$('#menuCursos').find('span').removeClass('warning');
		$('.seccionCursos').toggle();
		$('.seccionEscuela').toggle();
		
	}
	
	if (seccionActual==2){
		$('#menuOpiniones').find('span').removeClass('warning');
		$('.seccionOpiniones').toggle();
		$('.seccionEscuela').toggle();
	}
	
	if (seccionActual==3){
		$('#menuAlojamientos').find('span').removeClass('warning');
		$('.seccionAlojamientos').toggle();
		$('.seccionEscuela').toggle();
	}
	
	seccionActual=4;

});

            //SLIDER DE SEMANAS
            $('#sliderSemanas').slider({
                //Config
                range: "min",
                min: 1,
                max:15,

                start: function(event,ui) {
                    //$('#toolPrecio').fadeIn('fast');
                },

                //Slider Event
                slide: function(event, ui) { //When the slider is sliding

                    var value  = $('#sliderSemanas').slider('value');
                 

                    $('#toolSemanas').text(ui.value);  //Adjust the tooltip accordingly


                },

                stop: function(event,ui) {
                    //$('#toolPrecio').fadeOut('fast');
           			var value  = $('#sliderSemanas').slider('value');

					 $('#semanas').val(ui.value);
					
					 $.ajax({  
						url: 'modulos/course/datos_academia.php?id='+$('#id').val()+'&idioma='+$('#idioma').val()+'&semanas='+$('#semanas').val(),
						success: function(data) {  
							$('.contenedorDerecha').html(data);
							//slides para las fotos 
						}  
					});
					
					$.ajax({  
						url: 'modulos/course/seleccion.php?semanas='+$('#semanas').val(),
						success: function(data) {  
							$('#carrito').hide();
							$('#carrito').html(data);
							$('#carrito').show('slow');
							//slides para las fotos 
						} 
						
					});
					$(this).value= $('#semanas').val();
					 
             
                },
            });


//OCULTAR SLIDER FOTOS
$('.desplegar').click(function(){
$('.paginaCursosFotos').slideToggle();
if(fotosOcultas==0){
$(this).html('<i class="icon-chevron-down"></i>');
fotosOcultas=1;
} else {
$(this).html('<i class="icon-chevron-up"></i>');
fotosOcultas=0;
}
});






});
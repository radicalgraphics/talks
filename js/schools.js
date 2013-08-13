jQuery(document).ready(function($) {



//ACCIONES INICIALES
//Maneja el fondo de la página
$.backstretch("./img/fondo1.jpg");
$( "#spinner" ).spinner({
      spin: function( event, ui ) {
        if ( ui.value > 50 ) {
          $( this ).spinner( "value", 0 );
          return false;
        } else if ( ui.value < 0 ) {
          $( this ).spinner( "value", 50 );
          return false;
        }
      }
    });

//rollover precio

var precioActual;
$('.fichaEscuelaLinea4').mouseenter(function(){
var divPrecio=$( this ).find( '.contenedorFichaPrecio' );
precioActual=divPrecio.html();
TweenLite.to(divPrecio, 0.2, {css:{width:"327px"},onComplete:cambiaTexto});
function cambiaTexto(){
divPrecio.html('Seleccionar academia'); 
}

});
$('.fichaEscuelaLinea4').mouseleave(function(){
$( this ).find( '.contenedorFichaPrecio' ).html(precioActual);
TweenLite.to($( this ).find( '.contenedorFichaPrecio' ), 0.2, {css:{width:"0px"}});

});

//slides para las fotos
 $('.fichaEscuelaLinea3').royalSlider({
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

//sliders selectores

            //SLIDER DE PRECIO
            $('#sliderPrecio').slider({
                //Config
                /*range: "min",
                min: 0,
				max:1000, 
                value: 0,*/

                start: function(event,ui) {
                    //$('#toolPrecio').fadeIn('fast');
                },

                //Slider Event
                slide: function(event, ui) { //When the slider is sliding

                    var value  = $('#sliderPrecio').slider('value');
                 

                    $('#toolPrecio').text(ui.value +'€');  //Adjust the tooltip accordingly


                },

                stop: function(event,ui) {
                    //$('#toolPrecio').fadeOut('fast');
					 var value  = $('#sliderPrecio').slider('value');
					 $('#max_precio').val(ui.value);
					 $.ajax({  
						//url: 'modulos/schools/listado.php?idioma='+$('#idioma').val()+'&pais='+$('#pais').val()+'&ciudad='+$('#ciudad').val()+'&ord=nombre',
						url: 'modulos/schools/listado.php',  
						data:$('#frm').serialize(),
						success: function(result) {  
							$('.fichas').html(result);  
						}  
					});
					$.ajax({  
						url: 'modulos/schools/nschools.php',  
						data:$('#frm').serialize(),
						success: function(result) {  
							$('#total_escuelas').html(result); 
							 
						}  
					});
					 
                },
            });

            //SLIDER DE ALUMNOS
            $('#sliderAlumnos').slider({
                //Config
                range: "min",
                min: 1,
               /*value: 0,*/

                start: function(event,ui) {
                   // $('#toolAlumnos').fadeIn('fast');
                },

                //Slider Event
                slide: function(event, ui) { //When the slider is sliding

                    var value  = $('#sliderAlumnos').slider('value');
                 

                    $('#toolAlumnos').text(ui.value);  //Adjust the tooltip accordingly


                },

                stop: function(event,ui) {
                    //$('#toolAlumnos').fadeOut('fast');
					var value  = $('#sliderAlumnos').slider('value');
					 $('#max_alumnos').val(ui.value);
							 $.ajax({  
						//url: 'modulos/schools/listado.php?idioma='+$('#idioma').val()+'&pais='+$('#pais').val()+'&ciudad='+$('#ciudad').val()+'&ord=nombre',
						url: 'modulos/schools/listado.php',  
						data:$('#frm').serialize(),
						success: function(result) {  
							$('.fichas').html(result);  
						}  
					});
					$.ajax({  
						url: 'modulos/schools/nschools.php',  
						data:$('#frm').serialize(),
						success: function(result) {  
							$('#total_escuelas').html(result);  
						}  
					});  

                },
            });

            //SLIDER DE CLASES
            $('#sliderClases').slider({
                //Config
                range: "min",
                min: 1,
                /*value: 0,*/

                start: function(event,ui) {
                   // $('#toolClases').fadeIn('fast');
                },

                //Slider Event
                slide: function(event, ui) { //When the slider is sliding

                    var value  = $('#sliderClases').slider('value');
                 

                    $('#toolClases').text(ui.value);  //Adjust the tooltip accordingly


                },

                stop: function(event,ui) {
                    //$('#toolClases').fadeOut('fast');
					 var value  = $('#sliderClases').slider('value');
					 $('#max_clases').val(ui.value);
					 $.ajax({  
						//url: 'modulos/schools/listado.php?idioma='+$('#idioma').val()+'&pais='+$('#pais').val()+'&ciudad='+$('#ciudad').val()+'&ord=nombre',
						url: 'modulos/schools/listado.php',  
						data:$('#frm').serialize(),
						success: function(result) {  
							$('.fichas').html(result);  
						}  
					});
					$.ajax({  
						url: 'modulos/schools/nschools.php',  
						data:$('#frm').serialize(),
						success: function(result) {  
							$('#total_escuelas').html(result);  
						}  
					});  

                },
            });

            //SLIDER DE SEMANAS
            $('#sliderSemanas').slider({
                //Config
                range: "min",
                min: 1,
                /*value: 0,*/

                start: function(event,ui) {
                    $('#toolSemanas').fadeIn('fast');
                },

                //Slider Event
                slide: function(event, ui) { //When the slider is sliding

                    var value  = $('#sliderSemanas').slider('value');
                 

                    $('#toolSemanas').text('Semanas: '+ui.value);  //Adjust the tooltip accordingly


                },

                stop: function(event,ui) {
                    $('#toolSemanas').fadeOut('fast');
					var value  = $('#sliderSemanas').slider('value');
					$('#nsemanas').val(ui.value);
					$.ajax({  
						//url: 'modulos/schools/listado.php?idioma='+$('#idioma').val()+'&pais='+$('#pais').val()+'&ciudad='+$('#ciudad').val()+'&ord=nombre',
						url: 'modulos/schools/listado.php',  
						data:$('#frm').serialize(),
						success: function(result) {  
							$('.fichas').html(result);  
						}  
					});
					$.ajax({  
						url: 'modulos/schools/nschools.php?idioma='+$('#idioma').val()+'&pais='+$('#pais').val()+'&ciudad='+$('#ciudad').val()+'&ord=precio',
						success: function(data) {  
							$('#total_escuelas').html(data);  
						}  
					});  

                },
            });

//HOVER TIPO CURSO
$('#menuCurso').mouseenter(function(){
        TweenLite.to($(this), 0.3, {x:+10});
        TweenLite.to($('.papelCurso'), 0.3, {x:+10, rotation:3});
    });

$('#menuCurso').mouseleave(function(){
        TweenLite.to($(this), 0.3, {x:0});
        TweenLite.to($('.papelCurso'), 0.3, {x:0, rotation:0});
    });


//CLICK CURSO
$('#menuPais').click(function(){
        $(this).parent().css('background-image','url(./img/fondoMenu.png)');
        TweenLite.to($(this), 0.3, {x:+10});
        TweenLite.to($('.papelCurso'), 0.3, {x:+200});
        $('.contenidoItem').unbind('mouseleave');
        $('.contenidoItem').unbind('mouseenter');
        $('.contenidoItem').unbind('click');

    });
});

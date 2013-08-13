<?php //print_r($_GET)
	
	session_start();
	require_once("../../Connections/db.php");
	require_once("../../Connections/funciones.php");
	//print_r($_SESSION);
	if (isset($_GET['accion']) && $_GET['accion']=="eliminar_curso") unset($_SESSION['id_curso'] );
	if (isset($_GET['accion']) && $_GET['accion']=="eliminar_alojamiento") unset($_SESSION['id_alojamiento'] );
	if ($_GET['apartado']=="curso" && !empty($_GET['id'])) $_SESSION['id_curso'] = $_GET['id'];
	elseif ($_GET['apartado']=="alojamiento" && !empty($_GET['id'])) $_SESSION['id_alojamiento'] = $_GET['id'];
	
	if (isset($_GET['semanas'])&& !empty($_GET['semanas'])) $_SESSION['n_semanas'] = $_GET['semanas'];
	
if (isset($_SESSION['id_curso']) || isset($_SESSION['id_alojamiento'])){
	
	if (!empty($_SESSION['id_curso'])){
		$idTipo = dato_tabla("cursos",'tipo',"id=".$_SESSION['id_curso']);
		$nombre = dato_tabla("cursos_tipos",$_SESSION['sess_idioma'],"id=".$idTipo);
		$comision = dato_tabla("cursos","comision","id=".$_SESSION['id_curso']); 
		$clases_semanales = dato_tabla("cursos","clases_semanales","id=".$_SESSION['id_curso']); 
		
		$precio = $_SESSION['n_semanas']*dato_tabla("cursos",'precio',"id=".$_SESSION['id_curso']);
		
		$precio_descuento = dato_tabla('cursos_descuentos','precio','cursosId='.$_SESSION['id_curso'].' AND semanas = '.$_SESSION['n_semanas']);
		if (!empty($precio_descuento) && is_numeric($precio_descuento)&&$precio_descuento!="0.00")$precio = $precio_descuento;
		
		$apagar1 = ($precio*$comision)/100;
	
	}
	if (!empty($_SESSION['id_alojamiento'])){
		
		$idTipo2 = dato_tabla("alojamientos","tipo","id=".$_SESSION['id_alojamiento']); 
		$nombre2 = trim(dato_tabla("alojamientos_tipos",$_SESSION['sess_idioma'],"id=".$idTipo2)); 
		$precio2 = $_SESSION['n_semanas']*dato_tabla("alojamientos",'precio',"id=".$_SESSION['id_alojamiento']);
		$personas_habitacion= dato_tabla("alojamientos","personas_habitacion","id=".$_SESSION['id_alojamiento']);
		$comision2 = dato_tabla("alojamientos","comision","id=".$_SESSION['id_alojamiento']); 
		
		$apagar2 = ($precio2*$comision2)/100;
	
	}
	$total = $precio+$precio2;
	$apagar = $apagar1+$apagar2;
	$falta = $total-$apagar;
	
?>
<?php if(trim($nombre)!=""){?>
                            <div class="NuevoContenedorLinea">
                                <div class="NuevoPapelera"><i class="icon-trash"  id="eliminar_curso"></i></div>
                                <div class="NuevoContenedorDerecha">
                                  <div class="NuevoDerechaArriba">
                                    <?=$nombre?>
                                </div>
                                <div class="NuevoContendedorDerechaAbajo">
                                    <div class="NuevoDerechaAbajo">
                                    <?=$clases_semanales?> clases semanales
                                </div>  
                                <div class="NuevoDerechaPrecio"><?=$precio?>€</div>
                                </div>
                                </div>
                                
                            </div>
<?php }?>
<?php if(trim($nombre2)!=""){?>
                            <div class="NuevoContenedorLinea2">
                                <div class="NuevoPapelera"><i class="icon-trash" id="eliminar_alojamiento"></i></div>
                                <div class="NuevoContenedorDerecha">
                                  <div class="NuevoDerechaArriba2">
                                    <?=$nombre2?>
                                </div>
                                <div class="NuevoContendedorDerechaAbajo">
                                    <div class="NuevoDerechaAbajo">
                                    <?=$personas_habitacion?> persona(s) / habitación
                                </div>  
                                <div class="NuevoDerechaPrecio"><?=$precio2?>€</div>
                                </div>
                                </div>
                                
                            </div>
<?php }?>
<?php if(trim($nombre)!="" || trim($nombre2)!=""){?>
                            <div class="NuevoContenedorLinea3">
                                <div class="NuevoL3Arriba">TOTAL RESERVA: <?=$apagar?>€</div>
                                <div class="NuevoL3Abajo">MÁS TARDE PAGAS: <?=$falta?>€</div>
                            </div>
<?php }?>
<?php if(trim($nombre)!="" ){?>
                            <div class="NuevoContenedorBoton">
                             <button class="btn btn-large btn-warning" type="button" id="enviar_reserva">COMPLETA TU RESERVA</button>   
                            </div>
<?php }?>   
                            


































<? }?>



<?php if(trim($nombre)=="" && trim($nombre2)=="" ){?>
<img src="img/addcurso.png" style="margin:40px;">
<?php }?>
<script>
$('#enviar_reserva').click(function(){
	$('#frm').attr('action','carrito.php');
	frm.submit();
	$('#frm').attr('action','schools.php');
});
$('#eliminar_curso').click(function(){
		
		$.ajax({  
				url: 'modulos/course/seleccion.php?accion=eliminar_curso',
				success: function(data) {  
					$('#carrito').html(data);
					$('#carrito').show();
                    //slides para las fotos 
				}  
		});  
		$('.ink-button-curso').removeClass('disabled');
		$('.ink-button-curso').addClass('success');
		
		
    });
$('#eliminar_alojamiento').click(function(){
		
		$.ajax({  
				url: 'modulos/course/seleccion.php?accion=eliminar_alojamiento',
				success: function(data) {  
					$('#carrito').html(data);
					$('#carrito').show();
                    //slides para las fotos 
				}  
		}); 
		$('.ink-button-alojamiento').removeClass('disabled');
		$('.ink-button-alojamiento').addClass('success'); 
		
		
		
    });
</script>

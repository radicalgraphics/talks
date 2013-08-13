<?php 

	session_start();	
	if (isset($_POST) && !empty($_POST['id'])){
		$_SESSION['idioma'] = $_POST['idioma'];
		$_SESSION['PaisFinal'] = $_POST['PaisFinal'];
		$_SESSION['CiudadFinal'] = $_POST['CiudadFinal'];
		$_SESSION['IdiomaFinal'] = $_POST['IdiomaFinal'];
		$_SESSION['pais'] = $_POST['pais'];
		$_SESSION['ciudad'] = $_POST['ciudad'];
		$_SESSION['nsemanas'] = $_POST['nsemanas'];
		$_SESSION['max_precio'] = $_POST['max_precio'];
		$_SESSION['max_alumnos'] = $_POST['max_alumnos'];
		$_SESSION['max_clases'] = $_POST['max_clases'];
		$_SESSION['tipo'] = $_POST['tipo'];
		$_SESSION['ord'] = $_POST['ord'];
		$_SESSION['id'] = $_POST['id'];
		$_SESSION['semanas'] = $_POST['semanas'];

	}
		
if (isset($_SESSION['id_curso']) || isset($_SESSION['id_alojamiento'])){
	
	if (!empty($_SESSION['id_curso'])){
		$idTipo = dato_tabla("cursos",'tipo',"id=".$_SESSION['id_curso']);
		$nombre_curso = dato_tabla("cursos_tipos",$_SESSION['sess_idioma'],"id=".$idTipo);
		$comision = dato_tabla("cursos","comision","id=".$_SESSION['id_curso']); 
		$clases_semanales = dato_tabla("cursos","clases_semanales","id=".$_SESSION['id_curso']); 
		
		$precio = $_SESSION['n_semanas']*dato_tabla("cursos",'precio',"id=".$_SESSION['id_curso']);
		
		$precio_descuento = dato_tabla('cursos_descuentos','precio','cursosId='.$_SESSION['id_curso'].' AND semanas = '.$_SESSION['n_semanas']);
		if (!empty($precio_descuento) && is_numeric($precio_descuento)&&$precio_descuento!="0.00")$precio = $precio_descuento;
		
		$apagar1 = ($precio*$comision)/100;
	
	}
	if (!empty($_SESSION['id_alojamiento'])){
		
		$idTipo2 = dato_tabla("alojamientos","tipo","id=".$_SESSION['id_alojamiento']); 
		$nombre_alojamiento = trim(dato_tabla("alojamientos_tipos",$_SESSION['sess_idioma'],"id=".$idTipo2)); 
		$precio2 = $_SESSION['n_semanas']*dato_tabla("alojamientos",'precio',"id=".$_SESSION['id_alojamiento']);
		$personas_habitacion= dato_tabla("alojamientos","personas_habitacion","id=".$_SESSION['id_alojamiento']);
		$comision2 = dato_tabla("alojamientos","comision","id=".$_SESSION['id_alojamiento']); 
		
		$apagar2 = ($precio2*$comision2)/100;
	
	}
	$total = $precio+$precio2;
	$apagar = $apagar1+$apagar2;
	$falta = $total-$apagar;
	$_SESSION['sess_total'] = $total;
	$_SESSION['sess_apagar'] = $apagar;
}
?>
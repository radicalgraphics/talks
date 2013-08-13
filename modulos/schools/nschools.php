<?php
require_once("../../Connections/db.php");
require_once("../../Connections/funciones.php");
mysql_select_db($database_db, $db);
	if ($_SESSION['sess_idioma']=="esp") $idiomaT = 7;
	else  $idiomaT = 8;
	//Se tienen que `poner las mismas consultas que en listado.php para que cuadre.
	$consulta_precio ="";
	if (isset($_GET['max_precio']) && $_GET['max_precio']>0){
		$consulta_precio = "AND cursos.precio<=".$_GET['max_precio'];
	}
	$consulta_max_alumnos ="";
	if (isset($_GET['max_alumnos']) && $_GET['max_alumnos']>0){
		$consulta_max_alumnos = "AND cursos.maximo_alumnos<=".$_GET['max_alumnos'];
	}
	$consulta_max_clases ="";
	if (isset($_GET['max_clases']) && $_GET['max_clases']>0){
		$consulta_max_clases = "AND cursos.clases_semanales<=".$_GET['max_clases'];
	}
	$query_rsListado = sprintf("SELECT DISTINCT cursos.idAcademia as id FROM academias,cursos
								WHERE academias.codigoPais = '%s' 
								AND academias.idCiudad='%s'
								AND cursos.idioma = '%s'
								AND academias.id = cursos.idAcademia
								%s
								%s
								%s
								ORDER BY cursos.precio DESC",$_GET['pais'],$_GET['ciudad'],$_GET['idioma'],
								$consulta_max_clases,
								$consulta_precio,
								$consulta_max_alumnos
								);
	
	$rsListado = mysql_query($query_rsListado, $db) or die(mysql_error());
	$row_rsListado = mysql_fetch_assoc($rsListado);
	$totalRows_rsListado = mysql_num_rows($rsListado);

	echo $totalRows_rsListado;

?>
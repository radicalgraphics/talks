<script src="js/home.js"></script>
<?php
require_once("../../Connections/db.php");
require_once("../../Connections/funciones.php");
$valores="";
$idiomas = array();
	mysql_select_db($database_db, $db);
	$query_rsListado = sprintf("SELECT  DISTINCT idioma FROM cursos 
								ORDER BY ROUND(idioma) ASC ");
	
	/*$query_rsListado = sprintf("SELECT  DISTINCT idioma FROM cursos, idiomas
								cursos.ROUND(idioma) = idiomas.id
								ORDER BY idiomas.esp ASC ");
*/


	$rsListado = mysql_query($query_rsListado, $db) or die(mysql_error());
	$row_rsListado = mysql_fetch_assoc($rsListado);
	$totalRows_rsListado = mysql_num_rows($rsListado);


		if ($totalRows_rsListado > 0)
		{
			do
			{
            	
			if (is_numeric($row_rsListado['idioma'])){
				mysql_select_db($database_db, $db);
				$query_rsListado2 = sprintf("SELECT id,%s FROM idiomas WHERE id='%s'",$_SESSION['sess_idioma'],$row_rsListado['idioma']);
				$rsListado2 = mysql_query($query_rsListado2, $db) or die(mysql_error());
				$row_rsListado2 = mysql_fetch_assoc($rsListado2);
				$totalRows_rsListado2 = mysql_num_rows($rsListado2);
				$idiomas []=array(	"id" => $row_rsListado2['id'] ,
									"nombre" =>$row_rsListado2[$_SESSION['sess_idioma']] 
								);
					
				//$valores.='<li valor="'.$row_rsListado2['id'].'">'.$row_rsListado2[$_SESSION['sess_idioma']].'</li>';
			}
			/*
			$array_listado_clasificacion[] = array(
											   "id"         => $row_rsListado['id'],
									           "titulo"    	=>  $row_rsListado['piloto'],
											   "puntuacion"    	=> $row_rsListado['puntuacion'],
											   "marca"    	=> $row_rsListado['marca'],
											   "activo_front"   => $row_rsListado['activo_front']
											   );
		 	*/
			}
			while ($row_rsListado = mysql_fetch_assoc($rsListado));
		}
		$idiomas=orderMultiDimensionalArray ($idiomas, 'nombre');
	
		for ($i=0;$i<count($idiomas);$i++){
			$valores.='<li valor="'.$idiomas[$i]['id'].'">'.$idiomas[$i]['nombre'].'</li>';
		}
	mysql_free_result($rsListado);
echo "<ul>".$valores."</ul>";
?>
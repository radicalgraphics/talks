<script src="js/home.js"></script>
<?php
require_once("../../Connections/db.php");
$valores="";
	mysql_select_db($database_db, $db);
	if ($_SESSION['sess_idioma']=="esp") $idiomaT = 7;
	else  $idiomaT = 8;
	$query_rsListado = sprintf("SELECT DISTINCT academias.idCiudad, paises_ciudades.id as id, paises_ciudades.nombre as nombre
								FROM cursos,academias, paises, paises_ciudades
								WHERE cursos.idioma = '%s' 
								AND cursos.idAcademia=academias.id 
								AND academias.codigoPais = '%s'
								AND academias.idCiudad = paises_ciudades.id
								AND paises.id = academias.codigoPais 
								AND paises.id = paises_ciudades.id_pais
								AND paises_ciudades.id_idioma='%s'
								 
								ORDER BY paises_ciudades.nombre",$_GET['idioma'],$_GET['pais'],$idiomaT);

	$rsListado = mysql_query($query_rsListado, $db) or die(mysql_error());
	$row_rsListado = mysql_fetch_assoc($rsListado);
	$totalRows_rsListado = mysql_num_rows($rsListado);


		if ($totalRows_rsListado > 0)
		{
			do
			{
            	
			
				$valores.='<li valor="'.$row_rsListado['id'].'">'.$row_rsListado['nombre'].'</li>';
			
			}
			while ($row_rsListado = mysql_fetch_assoc($rsListado));
		}

	mysql_free_result($rsListado);
echo "<ul>".$valores."</ul>";
?>
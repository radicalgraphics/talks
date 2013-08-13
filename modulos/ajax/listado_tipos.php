<script src="js/schools.js"></script>
<?php
require_once("../../Connections/db.php");
$valores="";
	mysql_select_db($database_db, $db);
	$query_rsListado = sprintf("SELECT  id,%s as nombre FROM cursos_tipos
								ORDER BY %s ",$_SESSION['sess_idioma'],$_SESSION['sess_idioma']);

	$rsListado = mysql_query($query_rsListado, $db) or die(mysql_error());
	$row_rsListado = mysql_fetch_assoc($rsListado);
	$totalRows_rsListado = mysql_num_rows($rsListado);

$valores.='<option value="0">Todos los cursos</option>';
		if ($totalRows_rsListado > 0)
		{
			do
			{
           	
				//$valores.='<li valor="'.$row_rsListado['id'].'">'.$row_rsListado['nombre'].'</li>';
				$valores.='<option value="'.$row_rsListado['id'].'">'.$row_rsListado['nombre'].'</option>';
			
			}
			while ($row_rsListado = mysql_fetch_assoc($rsListado));
		}

	mysql_free_result($rsListado);
//echo "<ul>".$valores."</ul>";
echo $valores;
?>
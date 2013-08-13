<?php 
	//dato_tabla('noticias','titular','id=3')
	function resetear_cesta(){
		session_start();
		unset($_SESSION['id_curso']);
		unset($_SESSION['id_alojamiento']);
		$_SESSION['n_semanas']=1;
			
	}
	function truncateMod($str, $length, $trailing='...')
	{
	/*
	** $str -cadena a truncar
	** $length - longitud a truncar
	** $trailing - el fin de la nueva cadena, por defecto: "..."
	*/
		  // take off chars for the trailing
		  $length-=mb_strlen($trailing);
		  if (mb_strlen($str)> $length)
		  {
			 // la cadena excede la longitud, entonces añade los puntos suspensivos
			 return mb_substr($str,0,$length).$trailing;
		  }
		  else
		  {
			 // si la cadena ya es lo suficientemente corta, devuelve la cadena
			 $res = $str;
		  }
		  return $res;
	}
	function orderMultiDimensionalArray ($toOrderArray, $field, $inverse = false) {  
        $position = array();  
        $newRow = array();  
        foreach ($toOrderArray as $key => $row) {  
                $position[$key]  = $row[$field];  
                $newRow[$key] = $row;  
        }  
        if ($inverse) {  
            arsort($position);  
        }  
        else {  
            asort($position);  
        }  
        $returnArray = array();  
        foreach ($position as $key => $pos) {       
            $returnArray[] = $newRow[$key];  
        }  
        return $returnArray;  
    }  
	function dato_tabla($tabla,$registro,$id){
		global $db;
		$array_listado=array();
		$array_dato=array();
		if ($condicion!='') $condicion = 'WHERE '.$condicion;
		$query_rsListado = "SELECT $registro from $tabla WHERE ".$id;
		
		$rsListado = mysql_query($query_rsListado, $db) or die(mysql_error());
		$row_rsListado = mysql_fetch_assoc($rsListado);
		$totalRows_rsListado = mysql_num_rows($rsListado);
				
		return $row_rsListado[$registro];
		
	}
	function datos_tabla($tabla,$condicion=''){
		global $db;
		$array_listado=array();
		$array_dato=array();
		if ($condicion!='') $condicion = 'WHERE '.$condicion;
		$query_rsListado = 'select * from '.$tabla.' '.$condicion;
		
		$rsListado = mysql_query($query_rsListado, $db) or die(mysql_error());
		$row_rsListado = mysql_fetch_assoc($rsListado);
		$totalRows_rsListado = mysql_num_rows($rsListado);
		
		
		$total_columnas = mysql_num_fields($rsListado);
		if ($totalRows_rsListado > 0)
		{
			
				$cadena = "";
				for ($i=0;$i<$total_columnas;$i++)
				{
						$nombre = mysql_field_name($rsListado, $i);
						$dato = $row_rsListado[$nombre];
						if ($i!=$total_columnas-1){
						$cadena .= $nombre.' => '.$dato.',';
						}else{
						$cadena .= $nombre.' => '.$dato.'';
						}
						$array_dato[$nombre] = $dato;
				}
		}
		
		
		
		return $array_dato;
		
	}
	function galeria($idAcademia){
		
		global $db;
		$imagenes= array();
		$query_rsListado = "SELECT nombre from imagenes WHERE academiaId = ".$idAcademia." ORDER BY perfil DESC, id ASC";
		$rsListado = mysql_query($query_rsListado, $db) or die(mysql_error());
		$row_rsListado = mysql_fetch_assoc($rsListado);
		$totalRows_rsListado = mysql_num_rows($rsListado);
		$carpeta =dato_tabla('academias','carpeta',"id=".$idAcademia);
		//print_r($_SERVER);
		if ($totalRows_rsListado > 0)
		{
			do
			{
				
				//echo "http://www.talkandtrips.com/upload/".$carpeta."/".$row_rsListado['nombre']."<br>";
				if (file_exists($_SERVER['DOCUMENT_ROOT']."/upload/".$carpeta."/".$row_rsListado['nombre'])){
					if (!file_exists($_SERVER['DOCUMENT_ROOT']."/upload/".$carpeta."/thumb_".$row_rsListado['nombre'])){
						$rutaurlimagen = "/upload/".$carpeta."/".str_replace(" ","%20",$row_rsListado['nombre']);
						copy('http://www.talkandtrips.com/preproduccion/includes/clases/phpThumb/phpThumb.php?src='.$rutaurlimagen.'&w=337&h=161&zc=1',$_SERVER['DOCUMENT_ROOT'].'/upload/'.$carpeta.'/thumb_'.$row_rsListado['nombre']);
					}
					if (!file_exists($_SERVER['DOCUMENT_ROOT']."/upload/".$carpeta."/big_".$row_rsListado['nombre'])){
						$rutaurlimagen = "/upload/".$carpeta."/".str_replace(" ","%20",$row_rsListado['nombre']);
						copy('http://www.talkandtrips.com/preproduccion/includes/clases/phpThumb/phpThumb.php?src='.$rutaurlimagen.'&w=685&h=343&zc=1',$_SERVER['DOCUMENT_ROOT'].'/upload/'.$carpeta.'/big_'.$row_rsListado['nombre']);
					}
					$imagenes[] = array(
						"nombre"			=> "thumb_".$row_rsListado['nombre']
					); 
				}
			}
			while ($row_rsListado = mysql_fetch_assoc($rsListado));
		}

		mysql_free_result($rsListado);
		return $imagenes;
		
	
	}
	function galeria_ficha($idAcademia){
		
		global $db;
		$imagenes= array();
		$query_rsListado = "SELECT nombre from imagenes WHERE academiaId = ".$idAcademia." ORDER BY perfil DESC, id ASC";
		$rsListado = mysql_query($query_rsListado, $db) or die(mysql_error());
		$row_rsListado = mysql_fetch_assoc($rsListado);
		$totalRows_rsListado = mysql_num_rows($rsListado);
		$carpeta =dato_tabla('academias','carpeta',"id=".$idAcademia);
		//print_r($_SERVER);
		if ($totalRows_rsListado > 0)
		{
			do
			{
				
				if (file_exists($_SERVER['DOCUMENT_ROOT']."/upload/".$carpeta."/big_".$row_rsListado['nombre'])){
					
					$imagenes[] = array(
						"nombre"			=> '/upload/'.$carpeta.'/big_'.$row_rsListado['nombre']
					); 
				}
			}
			while ($row_rsListado = mysql_fetch_assoc($rsListado));
		}

		mysql_free_result($rsListado);
		return $imagenes;
		
	
	}
	function curso_menor_precio($idAcademia){
		
		global $db;
		$imagenes= array();
		$query_rsListado = "SELECT tipo,clases_semanales,precio FROM cursos WHERE idAcademia = ".$idAcademia." ORDER BY precio ASC LIMIT 1";
		$rsListado = mysql_query($query_rsListado, $db) or die(mysql_error());
		$row_rsListado = mysql_fetch_assoc($rsListado);
		$totalRows_rsListado = mysql_num_rows($rsListado);
		
		if ($totalRows_rsListado > 0)
		{
			do
			{
				$tipo_curso = dato_tabla('cursos_tipos',$_SESSION['sess_idioma'],'id='.$row_rsListado['tipo']);
				$curso = array(
									"tipo" => $tipo_curso,
									"nclases" => $row_rsListado['clases_semanales'],
									"precio" => $row_rsListado['precio'],
									
				); 
			}
			while ($row_rsListado = mysql_fetch_assoc($rsListado));
		}

		mysql_free_result($rsListado);
		return $curso;
		
	
	}
	function mayor_comision($idAcademia){
		
		global $db;
		$imagenes= array();
		$query_rsListado = "SELECT comision FROM cursos WHERE idAcademia = ".$idAcademia." ORDER BY comision DESC LIMIT 1";
		$rsListado = mysql_query($query_rsListado, $db) or die(mysql_error());
		$row_rsListado = mysql_fetch_assoc($rsListado);
		$totalRows_rsListado = mysql_num_rows($rsListado);
		
		if ($totalRows_rsListado > 0)
		{
			do
			{
				$comision = $row_rsListado['comision'];
			}
			while ($row_rsListado = mysql_fetch_assoc($rsListado));
		}

		mysql_free_result($rsListado);
		return $comision;
		
	
	}
	function dameNiveles($idCurso,$idioma){
		
		global $db;
		$imagenes= array();
		$query_rsListado = "SELECT Distinct idNivel  FROM cursos_niveles WHERE idCurso = ".$idCurso." ORDER BY idNivel ASC";
		$rsListado = mysql_query($query_rsListado, $db) or die(mysql_error());
		$row_rsListado = mysql_fetch_assoc($rsListado);
		$totalRows_rsListado = mysql_num_rows($rsListado);
		
		$primero = 0;
		$niveles="";
		
		if ($totalRows_rsListado > 0)
		{
			do
			{
				$nivel = dato_tabla('niveles',$idioma,"id=".$row_rsListado['idNivel']);
				
				if ($primero!=0) $niveles.= ", ".$nivel;
				else {$niveles.= $nivel;$primero++;}
			}
			while ($row_rsListado = mysql_fetch_assoc($rsListado));
		}

		mysql_free_result($rsListado);
		return $niveles;
		
	
	}
	function curso_seleccionado($idAcademia,$tipo){
		
		global $db;
		$imagenes= array();
		$query_rsListado = "SELECT tipo,clases_semanales,precio FROM cursos WHERE idAcademia = ".$idAcademia." AND tipo = ".$tipo." ORDER BY precio ASC LIMIT 1";
		$rsListado = mysql_query($query_rsListado, $db) or die(mysql_error());
		$row_rsListado = mysql_fetch_assoc($rsListado);
		$totalRows_rsListado = mysql_num_rows($rsListado);
		
		if ($totalRows_rsListado > 0)
		{
			do
			{
				$tipo_curso = dato_tabla('cursos_tipos',$_SESSION['sess_idioma'],'id='.$row_rsListado['tipo']);
				$curso = array(
									"tipo" => $tipo_curso,
									"nclases" => $row_rsListado['clases_semanales'],
									"precio" => $row_rsListado['precio'],
									
				); 
			}
			while ($row_rsListado = mysql_fetch_assoc($rsListado));
		}

		mysql_free_result($rsListado);
		return $curso;
		
	
	}
	
	function listado_tabla($tabla,$condicion=''){
		global $db;
		$array_listado=array();
		$array_dato=array();
		if ($condicion!='' && substr($condicion,0,1)!="*") $condicion = 'WHERE '.$condicion;
		$condicion = str_replace("*","",$condicion);
		$query_rsListado = 'select * from '.$tabla.' '.$condicion;
		//echo $query_rsListado; 
		$rsListado = mysql_query($query_rsListado, $db) or die(mysql_error());
		$row_rsListado = mysql_fetch_assoc($rsListado);
		$totalRows_rsListado = mysql_num_rows($rsListado);
		
		
		$total_columnas = mysql_num_fields($rsListado);
		if ($totalRows_rsListado > 0)
		{
			do
			{
				$cadena = "";
				
				for ($i=0;$i<$total_columnas;$i++)
				{
						$nombre = mysql_field_name($rsListado, $i);
						$dato = $row_rsListado[$nombre];
						if ($i!=$total_columnas-1){
						$cadena .= $nombre.' => '.$dato.',';
						}else{
						$cadena .= $nombre.' => '.$dato.'';
						}
						$array_dato[$nombre] = $dato;
				 //array_push($array_dato,array($nombre => $dato));
				
				}
				//$array_dato;
				array_push($array_listado,$array_dato);
			}while ($row_rsListado = mysql_fetch_assoc($rsListado));
		}
		
		
		
		return $array_listado;
		//echo $array_listado[5];
		//echo mysql_field_name($res, 0) . "\n";
		//echo mysql_field_name($res, 2);
	}
	function dibujarEstrellas($valor){
		if(!is_numeric($valor) || empty($valor)) $valor=0;
		$cadena = '';
		for($i=1;$i<=5;$i++){
			if ($valor>=$i) $cadena.='<div class="estrellaficha"> <i class=" icon-star"></i> </div>';
            else $cadena.='<div class="estrellaficha"> <i class=" icon-star-empty"></i> </div>';
		}
		$cadena.='';
		return $cadena;
	}

?>

        <script src="js/schools.js"></script>

<?php
require_once("../../Connections/db.php");
require_once("../../Connections/funciones.php");
mysql_select_db($database_db, $db);
	if ($_SESSION['sess_idioma']=="esp") $idiomaT = 7;
	else  $idiomaT = 8;
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
	if (isset($_GET['tipo_curso']) && $_GET['tipo_curso']!=0){
		$consulta_tipo_curso = "AND cursos.tipo =".$_GET['tipo_curso'];
	}
	$query_rsListado = sprintf("SELECT DISTINCT cursos.idAcademia as id FROM academias,cursos
								WHERE academias.codigoPais = '%s' 
								AND academias.idCiudad='%s'
								AND cursos.idioma = '%s'
								AND academias.id = cursos.idAcademia
								%s
								%s
								%s
								%s
								ORDER BY cursos.comision DESC",$_GET['pais'],$_GET['ciudad'],$_GET['idioma'],
								$consulta_max_clases,
								$consulta_precio,
								$consulta_max_alumnos,
								$consulta_tipo_curso
								);
	//mail("ign_iguane@hotmail.com",'consulta',$query_rsListado);
	$rsListado = mysql_query($query_rsListado, $db) or die(mysql_error());
	$row_rsListado = mysql_fetch_assoc($rsListado);
	$totalRows_rsListado = mysql_num_rows($rsListado);


		if ($totalRows_rsListado > 0)
		{
			do
			{
				$id_academia = $row_rsListado['id']; 
				$imagenes = galeria($id_academia);
				$datos_academia = datos_tabla('academias','id='.$id_academia);
				$ciudadx = dato_tabla('paises_ciudades','nombre','id='.$datos_academia['idCiudad']);
				$paisx = dato_tabla('paises','nombre','id='.$datos_academia['codigoPais']." AND id_idioma=7");
				if (isset($_GET['tipo_curso']) && $_GET['tipo_curso']!=0){
					$curso = curso_seleccionado($id_academia,$_GET['tipo_curso']);
				}else{
					$curso = curso_menor_precio($id_academia);
				}
				$comision = mayor_comision($id_academia);
				//$tipo_curso = dato_tabla('cursos_tipos',$_SESSION['sess_idioma'],'id='.$datos_academia['tipo']);
				$comentarios = listado_tabla('comentarios','idAcademia='.$row_rsListado['id'].' ORDER BY fecha DESC'); 
				$puntuacion = 0;
				for($p=0;$p<count($comentarios);$p++){
					$puntuacion+=$comentarios[$p]['instalaciones']+$comentarios[$p]['ubicacion']+$comentarios[$p]['ensenanza']+$comentarios[$p]['diversion'];
				}
				$puntuacion = round($puntuacion/(count($comentarios)*4));
				$datos[] = array(
								  "id"			=> $row_rsListado['id'],
								  "nombre"		=> $datos_academia['nombre'],
								  "direccion"   => $datos_academia['direccion'],
								  "carpeta"   => $datos_academia['carpeta'],
								  "precio" 		=> $curso['precio'],
								  "tipo"		=> $curso['tipo'],
								  "nclases"		=> $curso['nclases'],
								  "imagenes"	=> $imagenes,
								  "comentarios" => count($comentarios),
								  "puntuacion"  => $puntuacion,
								  "comision"	=> $comision
				
				
				); 
            
			
			}
			while ($row_rsListado = mysql_fetch_assoc($rsListado));
		}

	mysql_free_result($rsListado);
	//print_r($datos);
	$orden = false;
	if (isset($_GET['ord']) && $_GET['ord']=="puntuacion" ) $orden = true;
	if (isset($_GET['ord']) && $_GET['ord']=="comision" ) $orden = true;
	if (isset($_GET['ord'])) $datos = orderMultiDimensionalArray ($datos, $_GET['ord'], $orden);
?>
<?php if (count($datos)==0){?>
	<div class="alert alert-error">No se encuentran resultados con estos criterios</div>
<?php }?> 
<?php for($i=0;$i<count($datos);$i++){?>
<div class="fichaEscuela">
                    <div class="fichaEscuelaLinea1">
                        <div class="nombreEscuela">
                            <?=truncateMod($datos[$i]['nombre'],40)?>
                        </div>
                        <div class="direccionEscuela">
                            <?=truncateMod($datos[$i]['direccion'],50)?>
                        </div>
                    </div>
                    <div class="fichaEscuelaLinea2">
                        <div class="fichaPuntuaciones">
                        	<div class="estrellasFicha">
                            <?=dibujarEstrellas($datos[$i]['puntuacion'])?>
                            </div>
                            <div class="fichaComentarios">
                                    <?=$datos[$i]['comentarios'];?> comentarios
                            </div>
                        </div>
                        <div class="fichaMapa">
                            <div class="separaMapa"></div>
                            <div class="iconoMapa"> <a href="https://maps.google.com/maps?q=<?=str_replace(" ","+",$datos[$i]['direccion'])?>+<?=$ciudadx?>+<?=$paisx?>" target="_blank"><i class="icon-map-marker icon-large"></i></a> </div>
                        </div>
                    </div>
                    <div class="fichaEscuelaLinea3 rsMinW">
                    	<?php for($x=0;$x<count($datos[$i]['imagenes']);$x++){?>
                        <img class="rsImg" data-rsBigImg="../upload/<?=$datos[$i]['carpeta']?>/<?=$datos[$i]['imagenes'][$x]['nombre']?>" src="../upload/<?=$datos[$i]['carpeta']?>/<?=$datos[$i]['imagenes'][$x]['nombre']?>"  alt="">
                        <?php }?>
                        <?php if (count($datos[$i]['imagenes'])==0) echo '<img src="img/demo_okadelle.jpg" height="161" width="337" alt="">';?>
                        
                    </div>
                    <div class="fichaEscuelaLinea4" onclick="$('#id').val('<?=$datos[$i]['id']?>');frm.submit();">
                        <div class="fichaCurso">
                            <?=truncateMod($datos[$i]['tipo'],22)?> <span class="fichaclases"><?=$datos[$i]['nclases']?> clases/semana</span>
                        </div>
                        <div class="contenedorFichaPrecio">
                            <?=$datos[$i]['precio']?>€
                        </div>
                    </div>
                  </div>
                  
<?php }?>                  
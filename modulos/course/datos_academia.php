<?php 
	ini_set("display_erros","1");
	require_once("../../Connections/db.php");
	require_once("../../Connections/funciones.php");
	require_once("../../Connections/fechas.inc.php");
	
	$cursos = listado_tabla('cursos','idAcademia='.$_GET['id'].' AND idioma='.$_GET['idioma'].' AND activo_front=1 ORDER BY precio'); 
	$alojamientos = listado_tabla('alojamientos','idAcademia='.$_GET['id'].' ORDER BY precio'); 
	$comentarios = listado_tabla('comentarios','idAcademia='.$_GET['id'].' ORDER BY fecha DESC'); 
	
	$academia_nombre = dato_tabla('academias','nombre','id='.$_GET['id']);
	$academia_direccion = dato_tabla('academias','direccion','id='.$_GET['id']);
	
	$academia_idDescripcion = dato_tabla('academias','idDescripcion','id='.$_GET['id']);
	$academia_descripcion = dato_tabla('academias_descripcion',$_SESSION['sess_idioma'],'id='.$academia_idDescripcion);
	
	$imagenes = galeria_ficha($_GET['id']);
	
	$puntuacion = 0;
	for($p=0;$p<count($comentarios);$p++){
		$puntuacion+=$comentarios[$p]['instalaciones']+$comentarios[$p]['ubicacion']+$comentarios[$p]['ensenanza']+$comentarios[$p]['diversion'];
	}
	$puntuacion = round($puntuacion/(count($comentarios)*4));
  if (empty($academia_descripcion)) {
    $academia_descripcion="Esta academia aún no tiene una descripción.";
}
?>

<script src="js/course.js"></script>
<div class="contenedorPaginaCursos">
                  <div class="paginaCursosFotos rsMinW">
                  	  <?php for ($i=0;$i<count($imagenes);$i++){?>
                      <img class="rsImg" src="<?=$imagenes[$i]['nombre']?>" height="329" width="685" alt="">
                      <?php }?>
                      <!--<img class="rsImg" src="img/fotocurso.jpg" height="329" width="685" alt="">-->
                  </div>
                  <div class="paginaCursosLinea2">
                    <div class="desplegar">
                        <i class="icon-chevron-up"></i>
                    </div>
                    <div class="escuelaCursos">
                      <div class="nombreEscuelaCursos">
                            <?=$academia_nombre?>
                        </div>
                        <div class="direccionEscuelaCursos">
                          <? echo(truncateMod($academia_direccion,55)); ?>
                           
                        </div>
                    </div>
                    <div class="escuelaMenu">
                        <ul>
                            <li id="menuCursos" class="elementoMenu"><span class="warning">CURSOS</span></li>
                            <li id="menuOpiniones" class="elementoMenu"><span>OPINIONES</span></li>
                            <li id="menuAlojamientos" class="elementoMenu"><span>ALOJAMIENTOS</span></li>
                            <li id="menuEscuela" class="elementoMenu"><span>ESCUELA</span></li>
                        </ul>
                    </div>
                  </div>

                  


<div class="paginaCursosLinea3">
                      <div class="contenedorColumnaIzquierda">
                        <div class="fichaEscuelaLinea2">
                        <div class="fichaPuntuacionesCurso">
                        	<div class="estrellasFicha">
                            <?=dibujarEstrellas($puntuacion)?>
                            </div>
                            <div class="fichaComentarios">
                                    <?=count($comentarios);?> comentarios
                            </div>
                        </div>
                        <div class="fichaMapa">
                            <div class="separaMapaCursos"></div>
                            <div class="iconoMapaCursos"> <i class="icon-map-marker icon-large"></i> </div>
                        </div>
                    </div>
                    <div class="descripcionEscuela">
                        <?=$academia_descripcion?></div>
                      </div>
                      <div class="contenedorColumnaDerecha">
                          <div class="seccionCursos">
                              <div class="acordeonCursos">
                                  <ul>
                                  	 <?php 
									 for($i=0;$i<count($cursos);$i++){
									 $id = $cursos[$i]['id'];	
									
									 $nombre = trim(dato_tabla("cursos_nombre",$_SESSION['sess_idioma'],"id=".$cursos[$i]['idNombre'])); 	
									 $descripcion = dato_tabla("cursos_nombre",$_SESSION['sess_idioma'],"id=".$cursos[$i]['idDescripcion']); 	

									 
									 $tipo = dato_tabla("cursos_tipos",$_SESSION['sess_idioma'],"id=".$cursos[$i]['tipo']); 	
									 if ($cursos[$i]['tipo']==20 && !empty($nombre)) $tipo = $nombre;
									 /**/
									 $clases_semanales = $cursos[$i]['clases_semanales']; 	
									 $horario = $cursos[$i]['horario'];
									 $horario2 = $cursos[$i]['horario2'];
									 if ($_SESSION['sess_idioma']=="esp")$abreviatura = array("L","M","X","J","V","S","D");
									 else $abreviatura = array("M","T","W","TH","F","SA","SU");
									 $primero = 0;
									 for ($x=0;$x<7;$x++){
									 	if (substr($cursos[$i]['dias'],$x,1)==1){
											if ($primero ==0) {$dias = $abreviatura[$x];$primero=1;}
											else {$dias.=",".$abreviatura[$x];}
									 	}
									 }
									 if($primero==0)$dias = "-";
									 
									 $matricula = $cursos[$i]['matricula']; 	
									 $duracion_clase = $cursos[$i]['duracion_clase']; 	
									 $certificado = $cursos[$i]['certificado']; 	
									 $idNiveles = $cursos[$i]['idNiveles']; 	
									 $edad_minima = $cursos[$i]['edad_minima']; 	
									 $edad_maxima = $cursos[$i]['edad_maxima']; 
									 $edad_media = $cursos[$i]['edad_media']; 		
									 $maximo_alumnos = $cursos[$i]['maximo_alumnos']; 	
									 $media_alumnos = $cursos[$i]['media_alumnos']; 	
									 $material = $cursos[$i]['material']; 	
									 $precio = $cursos[$i]['precio']*$_GET['semanas']; 	
									 $comision = $cursos[$i]['comision']; 	
									 $examen = $cursos[$i]['examen']; 	
									 $plazas = $cursos[$i]['plazas'];
									 
									 $niveles = dameNiveles($id,$_SESSION['sess_idioma']);
									 
									 /**/
									 //Compruebo si esta academia con estos datos tiene descuento por semanas 	
									 
									 $precio_descuento = dato_tabla('cursos_descuentos','precio','cursosId='.$cursos[$i]['id'].' AND semanas = '.$_GET['semanas']);
									 if (!empty($precio_descuento) && is_numeric($precio_descuento)&&$precio_descuento!="0.00")$precio = $precio_descuento;

									 
									 ?>
                                      <li>
                                      <div class="cabeceraCurso">
                                        <div class="fichaCursoCurso">
                            				<?=$tipo?><span class="fichaclases"> <?=$clases_semanales?> clases/semana</span>
                        				</div>
                                        <div class="contenedorFichaPrecioCurso">
                                            <?=$precio?> €
                                        </div>
                                      </div>
                                      <div class="contenedorCCurso">
                                        <div class="cursoL1">
                                            <div class="bloqueL1 tooltiptalk" title="Alumnos por clase">
                                                <div class="bloqueIcono"><img src="img/slider_alumnos.png" height="30" width="32" alt=""></div>
                                                <div class="bloqueTxtIconosCursos">
                                                    <?=$maximo_alumnos?>
                                                </div>
                                            </div>
                                            <div class="bloqueL1 tooltiptalk" title="Clases por semana">
                                                <div class="bloqueIcono"><img src="img/slider_clases.png" height="30" width="32" alt=""></div>
                                                <div class="bloqueTxtIconosCursos">
                                                    <?=$clases_semanales?>
                                                </div>
                                            </div>
                                            <div class="bloqueL1">
                                                <div class="bloqueIcono tooltiptalk" title="Edad mínima"><img src="img/icono_bebe.png" height="26" width="19" alt=""></div>
                                                <div class="bloqueTxtIconosCursos">
                                                    <?=$edad_minima?>
                                                </div>
                                            </div>
                                            <div class="bloqueL1">
                                                <div class="bloqueIcono">
                                                <a class="btn btn-success btnpeque <?php if (isset($_SESSION['id_curso'])){ echo 'disabled';} else {echo 'success';}?> ink-button-curso" id_="<?=$id?>" apartado="curso"><i class="icon-shopping-cart icon-large"></i>AÑADIR ESTE CURSO</a></div>
                                            </div>
                                        </div>
                        
                                        <div class="bloqueL2">
                                            <?=$descripcion?>                                        
                                        </div>
                                        <div class="separadorCurso"></div>
                                        <div class="bloqueL3">
                                            <div class="campoCurso">
                                                <!--<p class="tituloCampo">Duración:</p>
                                                <p class="valorCampo">2 semanas</p>
                                                <div class="separadorCampos"></div>-->
                                                <p class="tituloCampo">Precio matricula:</p>
                                                <p class="valorCampo"><?php if($matricula!="0.00") echo $matricula."€"; else echo "-";?></p>
                                                <div class="separadorCampos"></div>
                                                <p class="tituloCampo">Precio material:</p>
                                                <p class="valorCampo"><?php if($material!="0.00") echo $material."€"; else echo "-";?></p>
                                                <div class="separadorCampos"></div>
                                                <p class="tituloCampo">Horario:</p>
                                                <p class="valorCampo"><?php if(!empty($horario)) echo $horario; else echo "-";?></p>
                                                <div class="separadorCampos"></div>
                                                <p class="tituloCampo">Horario2:</p>
                                                <p class="valorCampo"><?php if(!empty($horario2)) echo $horario2; else echo "-";?></p>
                                                <div class="separadorCampos"></div>
                                                <p class="tituloCampo">Dias apertura:</p>
                                                <p class="valorCampo"><?=$dias?></p>
                                            </div>
                                            <div class="campoCurso">
                                                
                                                <p class="tituloCampo">Precio materiales:</p>
                                                <p class="valorCampo"><?php if($material!="0.00") echo $material."€";  else echo "-";?></p>
                                                <div class="separadorCampos"></div>
                                                <p class="tituloCampo">Certificado:</p>
                                                <p class="valorCampo"><?php if(!empty($certificado)) echo "Si"; else echo "No";?></p>
                                                <div class="separadorCampos"></div>
                                                <p class="tituloCampo">Examen de nivel:</p>
                                                <p class="valorCampo"><?php if(!empty($examen)) echo "Si"; else echo "No";?></p>
                                                <div class="separadorCampos"></div>
                                                <p class="tituloCampo">Maximo alumnos:</p>
                                                <p class="valorCampo"><?php if(!empty($maximo_alumnos)) echo $maximo_alumnos; else echo "-";?></p>
                                                <div class="separadorCampos"></div>
                                                <p class="tituloCampo">Media alumnos:</p>
                                                <p class="valorCampo"><?php if(!empty($media_alumnos)) echo $media_alumnos; else echo "-";?></p>

                                                
                                            </div>
                                            <div class="campoCurso">
                                                 <p class="tituloCampo">Edad mínima:</p>
                                                 <p class="valorCampo"><?php if(!empty($edad_minima)) echo $edad_minima; else echo "-";?></p>
                                                 <div class="separadorCampos"></div>
                                                 <p class="tituloCampo">Edad maxima:</p>
                                                <p class="valorCampo"><?php if(!empty($edad_maxima)) echo $edad_maxima; else echo "-";?></p>
                                                <div class="separadorCampos"></div>
                                                 <p class="tituloCampo">Edad media:</p>
                                                <p class="valorCampo"><?php if(!empty($edad_media)) echo $edad_media; else echo "-";?></p>
                                            </div>
                                            <div class="campoCurso">
            
                                                <p class="tituloCampo">Niveles:</p>
                                                <p class="valorCampo"><?=$niveles?></p>
                                                <div class="separadorCurso"></div>
                                               
                                                
                                            </div>
                                            
                                            
                                        </div>
                                      </div>
                                    </li>
                                    
                                     <?php }?>
                                    
                                  </ul>
                              </div>
                              <?php if (count($cursos)==0){?>
                                    <div class="alert alert-info">Esta escuela aún no tiene cursos</div>
                              <?php }?>
                          </div>
                          <div class="seccionOpiniones">
                            <div class="contenedorOpiniones">
                              <?php if (count($comentarios)==0){?>
                                <div class="alert alert-info">Esta escuela aún no tiene opiniones</div>
                                <?php }?>
                                <?php for($i=0;$i<count($comentarios);$i++){?>
                                <div class="opinion">
                                    <div class="opinionL1">
                                        <?=$comentarios[$i]['nombre']?>, <span class="fechaPuntuacion"><?=mysql2fecha($comentarios[$i]['fecha'])?></span>
                                    </div>
                                    <div class="separadorOpiniones"></div>
                                    <div class="columnaPuntos">
                                    <div class="contenedorPuntos1">
                                        <div class="tituloPuntuacion">Instalaciones</div>
                                        <div class="contenedorValoracion">
                                        <div class="valoracion">
                                            <?=dibujarEstrellas($comentarios[$i]['instalaciones'])?>
                                        </div>
                                 </div>       
                                    </div>
                                    <div class="contenedorPuntos1">
                                        <div class="tituloPuntuacion">Enseñanza</div>
                                        <div class="contenedorValoracion">
                                        <div class="valoracion">
                                			<?=dibujarEstrellas($comentarios[$i]['ensenanza'])?>
                                        </div>
                                 </div>       
                                    </div>
                                 </div>
                                 <div class="columnaPuntos2">
                                    <div class="contenedorPuntos1">
                                        <div class="tituloPuntuacion">Ubicación</div>
                                        <div class="contenedorValoracion">
                                        <div class="valoracion">
                                            
                                		<?=dibujarEstrellas($comentarios[$i]['ubicacion'])?>
                                        </div>
                                 </div>       
                                    </div>
                                    <div class="contenedorPuntos1">
                                        <div class="tituloPuntuacion">Diversión</div>
                                        <div class="contenedorValoracion">
                                        <div class="valoracion">
                                		<?=dibujarEstrellas($comentarios[$i]['diversion'])?>
                                        </div>
                                 </div>       
                                    </div>
                                 </div> 
                                 <div class="descripcionOpinion">
                                    <?=$comentarios[$i]['comentarios']?>
                                 </div> 
                                 
                                </div>
								<?php }?>
                                
                            </div>
							
                          </div>
                          <div class="seccionAlojamientos">
                              <div class="acordeonAloja">
                                  <ul>
                                  	  <?php for($i=0;$i<count($alojamientos);$i++){
									 $id = $alojamientos[$i]['id'];	
									 $tipo = trim(dato_tabla("alojamientos_tipos",$_SESSION['sess_idioma'],"id=".$alojamientos[$i]['tipo'])); 	
									 $regimen = dato_tabla("alojamientos_regimenes",$_SESSION['sess_idioma'],"id=".$alojamientos[$i]['regimen']);
									 $nombre = nl2br(trim(dato_tabla("alojamientos_nombre",$_SESSION['sess_idioma'],"id=".$alojamientos[$i]['idNombre']))); 	
									 $descripcion = nl2br(dato_tabla("alojamientos_descripcion",$_SESSION['sess_idioma'],"id=".$alojamientos[$i]['idDescripcion']));
									 $precio =  $alojamientos[$i]['precio'];	
									 
									 
									 $personas_habitacion =  $alojamientos[$i]['personas_habitacion'];
									 $personas_bano =  $alojamientos[$i]['personas_bano'];
									 $personas_habitacion_obligatorio =  $alojamientos[$i]['personas_habitacion_obligatorio'];
									 $distancia =  $alojamientos[$i]['distancia'];
									 $transporte =  $alojamientos[$i]['transporte'];
									 $tiempo =  $alojamientos[$i]['tiempo'];
									 
									 $edad_desde =  $alojamientos[$i]['edad_desde'];
									 $edad_hasta =  $alojamientos[$i]['edad_hasta']; 	
									 $comision =  $alojamientos[$i]['comision']; 
									 $fechas_apertura =  $alojamientos[$i]['fechas_apertura'];
									 $stock =  $alojamientos[$i]['stock'];
									  	
									   	
									 $distancia_centro = nl2br(dato_tabla("alojamientos_distancia",$_SESSION['sess_idioma'],"id=".$alojamientos[$i]['idDistancia']));
									 $instalaciones = nl2br(dato_tabla("alojamientos_instalacion",$_SESSION['sess_idioma'],"id=".$alojamientos[$i]['idInstalacion']));
									 	
									 $dia_entrada = nl2br(dato_tabla("dias_semana",$_SESSION['sess_idioma'],"id=".$alojamientos[$i]['dia_entrada']));
									 $dia_salida = nl2br(dato_tabla("dias_semana",$_SESSION['sess_idioma'],"id=".$alojamientos[$i]['dia_salida']));
									 					 	
									  	
									 
									 
		

									 ?>
                                      <li>
                                      <div class="cabeceraAloja">
                                        <div class="fichaAlojaAloja">
                            				<?=$tipo?><span class="fichadesayuno"> <?=$regimen?></span>
                                        </div>
                                        <div class="contenedorFichaPrecioAloja">
                                            <?=$precio?>€
                                        </div>
                                      </div>
                                      <div class="contenedorAAloja">
                                        <div class="alojaNombre">
                                            <?=$nombre?>
                                        </div>
                                        <div class="separadorCurso"></div>
                                        <div class="cursoL1">
                                            <div class="bloqueL1">
                                                <div class="bloqueIcono"><img src="img/icn_aloja_persona.png" height="21" width="32" alt=""></div>
                                                <div class="bloqueTxtIconosCursos">
                                                    <?php if (!empty($personas_habitacion)) echo $personas_habitacion; else echo "-";?>
                                                </div>
                                            </div>
                                            <div class="bloqueL1">
                                                <div class="bloqueIcono"><img src="img/icn_aloja_tiempo.png" height="26" width="23" alt=""></div>
                                                <div class="bloqueTxtIconosCursos">
                                                   <?php if (!empty($tiempo)) echo $tiempo; else echo "-";?> 
                                                </div>
                                            </div>
                                            <div class="bloqueL1">
                                                <div class="bloqueIcono"><img src="img/icn_aloja_distancia.png" height="28" width="31" alt=""></div>
                                                <div class="bloqueTxtIconosCursos">
                                                    <?php if (!empty($distancia)) echo $distancia; else echo "-";?>
                                                </div>
                                            </div>
                                            <div class="bloqueL1">
                                                <div class="bloqueIcono">
                                                <a class="btn btn-success btnpeque <?php if (isset($_SESSION['id_alojamiento'])){ echo 'disabled';} else{echo 'success';}?> ink-button-alojamiento" id_="<?=$id?>" apartado="alojamiento"><i class="icon-shopping-cart icon-large"></i>AÑADIR ALOJAMIENTO</a></div>
                                            </div>
                                        </div>
                                        <div class="separadorCurso"></div>
                                        <div class="bloqueL2">
                                           <?=$descripcion?>                                        
                                        </div>
                                        <div class="separadorCurso"></div>
                                        <div class="bloqueL3">
                                            <div class="campoCurso">
                                                <p class="tituloCampo">Personas por habitacion:</p>
                                                <p class="valorCampo"><?php if (!empty($personas_habitacion)) echo $personas_habitacion; else echo "-";?> personas</p>
                                                <div class="separadorCampos"></div>
                                                <p class="tituloCampo">Distancia desde escuela:</p>
                                                <p class="valorCampo"><?php if (!empty($distancia)) echo $distancia; else echo "-";?>&nbsp;</p>
                                                <div class="separadorCampos"></div>
                                                <p class="tituloCampo">Transporte:</p>
                                                <p class="valorCampo"><?php if (!empty($transporte)) echo $transporte; else echo "-";?>&nbsp;</p>
                                            </div>
                                            <div class="campoCurso">
                                                <p class="tituloCampo">Tiempo trayecto:</p>
                                                <p class="valorCampo"><?php if (!empty($tiempo)) echo $tiempo; else echo "-";?></p>
                                                <div class="separadorCampos"></div>
                                                <p class="tituloCampo">Día entrada:</p>
                                                <p class="valorCampo"><?php if (!empty($dia_entrada)) echo $dia_entrada; else echo "-";?></p>
                                                <div class="separadorCampos"></div>
                                                <p class="tituloCampo">Dia salida:</p>
                                                <p class="valorCampo"><?php if (!empty($dia_salida)) echo $dia_salida; else echo "-";?></p>
                                            </div>
                                            <div class="campoCurso">
                                                <p class="tituloCampo">Obligatorio:</p>
                                                <p class="valorCampo">Si&nbsp;</p>
                                                <div class="separadorCampos"></div>
                                                 <p class="tituloCampo">Distancia centro:</p>
                                                <p class="valorCampo"><?php if (!empty($distancia_centro)) echo $distancia_centro; else echo "-";?></p>
                                            </div>
                                            <div class="campoCurso">
            
                                                <p class="tituloCampo">Instalaciones:</p>
                                                <p class="valorCampo"><?php if (!empty($instalaciones)) echo $instalaciones; else echo "-";?></p>
                                               
                                                
                                            </div>
                                            
                                            
                                        </div>
                                      </div>

                                    </li>
                                    <?php }?>
                                  </ul>
                                  
                              </div>
							  <?php if (count($alojamientos)==0){?>
                                    <div class="alert alert-info">Esta escuela aún no tiene alojamientos</div>
                              <?php }?>
                          </div>
                          <div class="seccionEscuela">
                              <div class="acordeonEscuela">
                                  <ul>
                                  	 <?php 
									 
									 $datosx = listado_tabla('academias','id='.$_GET['id']); 
									 $datos=$datosx[0];
									 $cantidad_aulas= $datos['cantidad_aulas']; // =&gt; 12
									 $examen_inicial= $datos['examen_inicial']; // =&gt; 0
									 $aeropuerto_cercano= $datos['aeropuerto_cercano']; // =&gt; 
									 $distancia_aeropuerto= $datos['distancia_aeropuerto']; // =&gt; 
									 $ano_inauguracion= $datos['ano_inauguracion']; // =&gt; 2003
										$horario= $datos['horario']; // =&gt; 10:00 14:00
										$idAeropuerto1= $datos['idAeropuerto1']; // =&gt; 1
										$idAeropuerto2= $datos['idAeropuerto2']; // =&gt; 2
										$idDistancia= $datos['idDistancia']; // =&gt; 1
										$idInstalacion= $datos['idInstalacion']; // =&gt; 1
										$idInfoalumno= $datos['idInfoalumno']; // =&gt; 1
										$idTerminos= $datos['idTerminos']; // =&gt; 1
										$transfer= $datos['transfer']; // =&gt; 0
										$enviamos_informacion= $datos['enviamos_informacion']; // =&gt; 1
										$enviamos_carta= $datos['enviamos_carta']; // =&gt; 0
										$aeropuerto1= $datos['aeropuerto1']; // =&gt; Aeropuerto 1
										$aeropuerto2= $datos['aeropuerto2']; // =&gt; Aeropuerto 2
										$precio_aeropuerto1= $datos['precio_aeropuerto1']; // =&gt; 15.00
										$precio_aeropuerto2= $datos['precio_aeropuerto2']; // =&gt; 25.00
										
									 
									 //Compruebo si esta academia con estos datos tiene descuento por semanas 	
									 /*
									 
									 */
									 
									 
									 ?>
                                     
                                  	 
                                      <li>
                                      <div class="cabeceraCurso">
                                        <div class="fichaCursoCurso">
                            				Otros datos de la escuela
                        				</div>
                                        
                                      </div>
                                      <div class="contenedorEEscuela">
                                        
                                        <div class="bloqueL3">
                                           
                                            
                                            
                                            <!--Datos-->
                                            <div class="bloqueL3">
                                            <?php 
											if (!empty($cantidad_aulas)){ // =&gt; 12
									 		
											?>
                                            <div class="campoCurso">
            									<p class="tituloCampo">Cantidad de aulas:</p>
                                                <p class="valorCampo"><?=$cantidad_aulas?></p>
                                                
                                            </div>
                                            <?php }?>
                                            <?php if (!empty($examen_inicial)){ // =&gt; 0
												if ($examen_inicial==1) $examen_inicial="Si";
												else $examen_inicial="No";?>
                                            <div class="campoCurso">
            									<p class="tituloCampo">Examen inicial:</p>
                                                <p class="valorCampo"><?=$examen_inicial?></p>
                                                
                                            </div>
                                            <?php }?>
                                            <?php if (!empty($ano_inauguracion)){ // =&gt; 2003?>
                                            <div class="campoCurso">
            									<p class="tituloCampo">Año inauguracion:</p>
                                                <p class="valorCampo"><?=$ano_inauguracion?></p>
                                                
                                            </div>
                                            <?php }?>
                                            <?php 
											
											if (!empty($horario)){ // =&gt; 10:00 14:00
											
											?>
                                            <div class="campoCurso">
            									<p class="tituloCampo">Horario:</p>
                                                <p class="valorCampo"><?=$horario?></p>
                                                <div class="separadorCurso"></div>
                                            </div>
                                            <?php }?>
                                            
                                            <?php 
											
											if (!empty($enviamos_informacion)){ // =&gt; 1
											if ($enviamos_informacion==1) $enviamos_informacion="Si";
											else $enviamos_informacion="No";?>
                                            <div class="campoCurso">
            									<p class="tituloCampo">Enviamos informacion:</p>
                                                <p class="valorCampo"><?=$enviamos_informacion?></p>
                                            </div>
                                            <?php }?>
                                            <?php 
											
											if (!empty($enviamos_carta)){ // =&gt; 0
											if ($enviamos_carta==1) $enviamos_carta="Si";
												else $enviamos_carta="No";?>
                                            <div class="campoCurso">
            									<p class="tituloCampo">Enviamos visa:</p>
                                                <p class="valorCampo"><?=$enviamos_carta?></p>
                                            </div>
                                            <?php }?>
											<?php 
											
											if (!empty($transfer)){ // =&gt; 0
												if ($transfer==1) $transfer="Si";
												else $transfer="No";?>
											
                                            <div class="campoCurso">
            									<p class="tituloCampo">Transfer:</p>
                                                <p class="valorCampo"><?=$transfer?></p>
                                            </div>
                                             
													<?php if (!empty($aeropuerto1)){ // =&gt; Aeropuerto 1 ?>
													<div class="campoCurso">
														<p class="tituloCampo">Aeropuerto 1:</p>
														<p class="valorCampo"><?=$aeropuerto1?></p>
													</div>
													<?php }?>
													<?php if (!empty($precio_aeropuerto1)){ // =&gt; 15.00?>
													<div class="campoCurso">
														<p class="tituloCampo">Precio:</p>
														<p class="valorCampo"><?=$precio_aeropuerto1?></p>
														
													</div>
													<?php }?>
													<?php if (!empty($aeropuerto2)){ // =&gt; Aeropuerto 2?>
													<div class="campoCurso">
														<p class="tituloCampo">Aeropuerto 2:</p>
														<p class="valorCampo"><?=$aeropuerto2?></p>
													</div>
													<?php }?>
													<?php 
													
													if (!empty($precio_aeropuerto2)){
													?>
													<div class="campoCurso">
														<p class="tituloCampo">Precio:</p>
														<p class="valorCampo"><?=$precio_aeropuerto2?></p>
													</div>
													<?php }?>
											<?php }?>
                                            <div class="campoCurso">
            									<div class="separadorCurso"></div>
                                            </div>
                                            <?php 
											
											if (!empty($idAeropuerto1)){ // =&gt; 1
												$distancia_aeropuerto1 = dato_tabla('academias_aeropuerto1',$_SESSION['sess_idioma'],'id='.$idAeropuerto1);
											
											}
											if (!empty($distancia_aeropuerto1)){
											?>
                                            <div class="campoCurso">
            									<p class="tituloCampo">Distancia Aeropuerto 1:</p>
                                                <p class="valorCampo"><?=$distancia_aeropuerto1?></p>
                                                
                                            </div>
                                            <?php }?>
                                            <?php 
											if (!empty($idAeropuerto2)){ // =&gt; 1
												$distancia_aeropuerto2 = dato_tabla('academias_aeropuerto2',$_SESSION['sess_idioma'],'id='.$idAeropuerto2);
											
											}
											if (!empty($distancia_aeropuerto2)){
											
											?>
                                            <div class="campoCurso">
            									<p class="tituloCampo">Distancia Aeropuerto 2:</p>
                                                <p class="valorCampo"><?=$distancia_aeropuerto2?></p>
                                            </div>
                                            <?php }?>
                                            <?php 
											
											if (!empty($idDistancia)){ // =&gt; 1
												$distancia = dato_tabla('academias_distancia',$_SESSION['sess_idioma'],'id='.$idDistancia);
											
											}
											if (!empty($distancia)){
											
											?>
                                            <div class="campoCurso">
            									<p class="tituloCampo">Distancia al centro:</p>
                                                <p class="valorCampo"><?=$distancia?></p>
                                            </div>
                                            <?php }?>
                                            <?php 
											
											if (!empty($idInstalacion)){ // =&gt; 1
												$instalaciones = dato_tabla('academias_instalacion',$_SESSION['sess_idioma'],'id='.$idInstalacion);
											
											}
											if (!empty($instalaciones)){
											?>
                                            <div class="campoCurso">
            									<p class="tituloCampo">Instalaciones:</p>
                                                <p class="valorCampo"><?=$instalaciones?></p>
                                            </div>
                                            <?php }?>
                                            <?php 
											
											if (!empty($idInfoalumno)){ // =&gt; 1
												$infoalumno = dato_tabla('academias_infoalumno',$_SESSION['sess_idioma'],'id='.$idInfoalumno);
											
											}
											if (!empty($infoalumno)){
											?>
                                            <div class="campoCurso">
            									<p class="tituloCampo">Informacion alumno:</p>
                                                <p class="valorCampo"><?=$infoalumno?></p>
                                               
                                            </div>
                                            <?php }?>
                                            <?php 
											
											if (!empty($idTerminos)){ // =&gt; 1
												$terminos = dato_tabla('academias_terminos',$_SESSION['sess_idioma'],'id='.$idTerminos);
											
											}
											if (!empty($terminos)){
											?>
                                            <div class="campoCurso">
            									<p class="tituloCampo">Terminos y condiciones generales:</p>
                                                <p class="valorCampo"><?=$terminos?></p>
                                                <div class="separadorCurso"></div>
                                            </div>
                                            <?php }?>
                                            
                                            
                                            
                                            
                                            
                                        </div>
                                      </div>
                                            
                                            <!--Fin datos -->
                                            
                                            
                                        </div>
                                      </div>
                                    </li>
                                    
                                    
                                  </ul>
                              </div>
                             
                          </div>
                      </div>
                      </div>
                  </div>              

</div>
 <script>
 
 $('.ink-button-curso').click(function(){
		if($(this).hasClass('success')){
		$.ajax({  
				url: 'modulos/course/seleccion.php?id='+$(this).attr('id_')+'&apartado='+$(this).attr('apartado')+'&semanas='+$('#semanas').val(),
				success: function(data) {  
					//$('#carrito').hide();
					$('#carrito').html(data);
					$('#carrito').slideDown();
                    //slides para las fotos 
				}  
		});  
		$('.ink-button-curso').removeClass('success');
		$('.ink-button-curso').addClass('disabled');
		}
		
    });
 $('.ink-button-alojamiento').click(function(){
		if($(this).hasClass('success')){
		$.ajax({  
				url: 'modulos/course/seleccion.php?id='+$(this).attr('id_')+'&apartado='+$(this).attr('apartado')+'&semanas='+$('#semanas').val(),
				success: function(data) {  
					//$('#carrito').hide();
					$('#carrito').html(data);
					$('#carrito').slideDown();
                    //slides para las fotos 
				}  
		});  
		$('.ink-button-alojamiento').removeClass('success');
		$('.ink-button-alojamiento').addClass('disabled');
		}
		
    });
 
		
</script>
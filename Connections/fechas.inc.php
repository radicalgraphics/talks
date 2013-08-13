<?
function compara_fechas($fecha1,$fecha2)
            

{
            

      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha1))
            

              list($dia1,$mes1,$año1)=split("/",$fecha1);
            

      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))
            

              list($dia1,$mes1,$año1)=split("-",$fecha1);
        if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha2))
            

              list($dia2,$mes2,$año2)=split("/",$fecha2);
            

      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha2))
            

              list($dia2,$mes2,$año2)=split("-",$fecha2);
        $dif = mktime(0,0,0,$mes1,$dia1,$año1) - mktime(0,0,0, $mes2,$dia2,$año2);
        return ($dif);                         
            

}

	/*****************************************************************
    *                                                                *
    * Función: fecha2mktime                                          *
    * Descripción: Pasa un fecha a formato UNIX                      *
	* La fecha ha de tener el siguiente formato: YYYY-mm-dd HH:mm:ss *
    *                                                                *
    ******************************************************************/

	function fecha2mktime ($fecha){

		list($date, $horas)            = explode(" ", $fecha);

		list($anyo, $mes, $dia)        = explode("-", $date);

		list($hora, $minuto, $segundo) = explode(":", $horas);


		return mktime($hora, $minuto, $segundo, $mes, $dia, $anyo);

	}




    /***************************************************************************
    *                                                                          *
    * Función: mktime2fecha                                                    *
    * Descripción: Pasa una fecha en formato UNIX a formato timestamp de MySQL *
	* La fecha ha de tener el siguiente formato: YYYY-mm-dd HH:mm:ss           *
    *                                                                          *
    ***************************************************************************/

	function mktime2fecha ($mk_fecha){

		$dt_fecha = getdate($mk_fecha);


		$anyo     = $dt_fecha['year'];

		$mes      = $dt_fecha['mon'];

		$dia      = $dt_fecha['mday'];

		$hora     = $dt_fecha['hours'];

		$minutos  = $dt_fecha['minutes'];

		$segundos = $dt_fecha['seconds'];
		
		
		return $anyo . "-" . $mes . "-" . $dia . " " . $hora . ":" . $minutos . ":" . $segundos;

	}



	/*********************************************************
    *                                                        *
	* Función: fecha2mysql                                   *
	* Entrada: fecha con el formato dd-mm-YYYY               *
	* Los delimitadores pueden ser: -, /, . ó :              *
	* Salida:  formato mysql de la fecha, es decir, YYYYmmdd *
    *                                                        *
    *********************************************************/
    function fecha2mysql($date){
	
		$date = trim($date);

		list($dia, $mes, $anno) = split('[-/.:]', $date);

		$fecha = $anno."-".$mes."-".$dia;

		return $fecha;
    }
    
    /*********************************************************
    *                                                        *
	* Función: fecha2datetime                                *
	* Entrada: fecha con el formato dd-mm-YYYY H:M:S         *
	* Los delimitadores pueden ser: -, /, . ó :              *
	* Salida:  formato mysql de la fecha, es decir, YYYYmmdd *
    *                                                        *
    *********************************************************/
    function fecha2datetime($date){

		list($dia, $mes, $anno, $hora, $min, $sec) = split('[ -/.:]', $date);
		
		$fecha = "$anno-$mes-$dia $hora:$min:$sec";

		return $fecha;
    }


	/*****************************************************************************************              
	*                                                                                        *
    * Función: mysql2fecha                                                                   *
	* Entrada: fecha del tipo mysql. Trabaja con el tipo DATE de mysql, es decir, YYYY-mm-dd *
    * Salida: devolverá la fecha en formato dd-mm-YYYY                                       *
    *                                                                                        *
    *****************************************************************************************/
    function mysql2fecha($date, $separador='-'){

		list ($anno, $mes, $dia) = split('[-/.]', trim($date));

		list ($dia, $hora) = split(' ', $dia); // Para la eventualidad de un DATETIME

		$fecha = $dia . $separador . $mes . $separador . $anno . " " . $hora;

		return $fecha;
    }


    
    
	/******************************************************************************************************
	*                                                                                        			  *
    * Función: datetime		                                                                 			  *
	* Entrada: fecha del tipo mysql. Trabaja con el tipo DATETIME de mysql, es decir, YYYY-mm-dd HH:mm:ss *
    * Salida: devolverá la fecha y hora en un array 	                                       			  *
    *                                                                                        			  *
    ******************************************************************************************************/
       function datetime($date){

		list ($anno, $mes, $dia) = explode('-', $date);

		list ($dia, $hora) = explode(' ', $dia);
		
		list ($hora, $minuto, $segundo) = explode(':', $hora);

		$output = array("dia"=>$dia, "mes"=>$mes, "anyo"=>$anno, "hora"=>$hora, "minuto"=>$minuto, "segundo"=>$segundo);

		return $output;
    }
	
	/**********************************************************
	*                                                         *
    * Función: dias_mes                                       *
	* Entrada: ordinal de un mes (1->Enero, 2->Febrero, etc.) *
    * Salida: devuelve el numero de dias de un mes concreto   *
    *                                                         *
    **********************************************************/
	function dias_mes($mes, $anyo=""){
	
		$anyo_actual = ($anyo == "") ? date('Y'):$anyo;

		switch ($mes){

			case 1:
			case 3:
			case 5:
			case 7:
			case 8:
			case 10:
			case 12: $dias = 31; break;

			case 4:
			case 6:
			case 9:
			case 11: $dias = 30; break;

			default: // Febrero
			
				if ( ((($anyo_actual % 4) == 0) && (($anyo_actual % 100) != 0)) || (($anyo_actual % 400) == 0) )
					
					$dias  = 29;

				else

					$dias = 28;


		}


		return $dias;

	}




	/**********************************************************
	*                                                         *
    * Función: numero_dias                                    *
	* Entrada: 2 fechas en formato europeo: dd-mm-YYYY        *
    * Salida: devuelve el numero de dias entre esas 2 fechas  *
    *                                                         *
    **********************************************************/
	function numero_dias($hoy, $destino)
	{

		$numero_dias = 0;

		list($dia_actual, $mes_actual, $ano_actual)    = split("[-/.:]", $hoy);
		list($dia_destino, $mes_destino, $ano_destino) = split("[-/.:]", $destino);


		while (1)
		{
			if ((intval($dia_actual) == intval($dia_destino)) && (intval($mes_actual) == intval($mes_destino)) && (intval($ano_actual) == intval($ano_destino)))
			{
				break;
			}
			$numero_dias++;
			
			list($dia_actual, $mes_actual, $ano_actual) = sumar_dia($dia_actual, $mes_actual, $ano_actual);
		}


		return $numero_dias;

	}	
	
	
	
	function sumar_dia ($dia, $mes, $anyo, $sumar=1)
	{
		if ($sumar)
		{
			if ($dia == dias_mes($mes, $anyo))
			{
				$dia = 1;
				if ($mes == 12)
				{
					$mes = 1;
					$anyo++;
				}
				else 
				{
					$mes++;
				}
			}
			else 
			{
				$dia++;
			}
		}
		else
		{
			if ($dia != 1)
			{
				$dia--;
			}
			else
			{
				if ($mes != 1)
				{
					$mes--;
				}
				else
				{
					$mes = 12;
					$anyo--;
				}
				$dia = dias_mes($mes);
			}
		}
					
		$output = array($dia, $mes, $anyo);
		
		return $output;
		
	}



/********************************************************************************
*                                                                               *
* Función: fecha_hoy                                                            *
* Entrada:                                                                      * 
* Salida: devuelbe la fecha de hoy en el formato $dia." de ".$mes." de ".$anno; *
*                                                                               *
*********************************************************************************/
	
function fecha_hoy(){
 // Dia del mes
  $dia=date("d");
 
 // Mes del año 
  $mes=date("m");
  switch ($mes) {
   case 1:
       $mes="Enero";
       break;
   case 2:
       $mes="Febrero";
       break;
   case 3:
       $mes="Marzo";
       break;
   case 4:
       $mes="Abril";
       break;
   case 5:
       $mes="Mayo";
       break;
   case 6:
       $mes="Junio";
       break;
   case 7:
       $mes="Julio";
       break;
   case 8:
       $mes="Agosto";
       break;
   case 9:
       $mes="Septiembre";
       break;
   case 10:
       $mes="Octubre";
       break;
   case 11:
       $mes="Noviembre";
       break;
   case 12:
       $mes="Diciembre";
       break;

   }
   
   // Año actual
  $anno=date("Y");
  
  $fecha=$dia." de ".$mes." de ".$anno;
  return $fecha;
  
}		
	

/******************************************************************************************
*                                                                                         *
* Función: fecha_legible                                                                   *
* Entrada: fecha del tipo mysql. Trabaja con el tipo DATE de mysql, es decir, YYYY-mm-dd  * 
* Salida: devuelbe la fecha introducida en el formato $dia." de ".$mes." de ".$anyo;      *
*                                                                                         *
*******************************************************************************************/
	
function fecha_legible($fecha){

list ($anyo, $mes, $dia) = split('[-/.]', trim($fecha));
	
 
 // Mes del año 
  switch ($mes) {
   case "01":
       $mes="Enero";
       break;
   case "02":
       $mes="Febrero";
       break;
   case "03":
       $mes="Marzo";
       break;
   case "04":
       $mes="Abril";
       break;
   case "05":
       $mes="Mayo";
       break;
   case "06":
       $mes="Junio";
       break;
   case "07":
       $mes="Julio";
       break;
   case "08":
       $mes="Agosto";
       break;
   case "09":
       $mes="Septiembre";
       break;
   case "10":
       $mes="Octubre";
       break;
   case "11":
       $mes="Noviembre";
       break;
   case "12":
       $mes="Diciembre";
       break;

   }
   
  
  $fecha=$dia." de ".$mes." de ".$anyo;
  return $fecha;
  
}				
?>

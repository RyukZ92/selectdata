<?php
        /**
         * 
         * @param type $string (el estring a encriptar)
         * @param type $key (la llave utilizada para encritar)
         * @return type string
         */
        function encrypt($string, $key) {
           $result = '';
           $key = md5($key) . date('Y');
           for($i=0; $i<strlen($string); $i++) {
              $char = substr($string, $i, 1);
              $keychar = substr($key, ($i % strlen($key))-1, 1);
              $char = chr(ord($char)+ord($keychar));
              $result.=$char;
           }
           return base64_encode($result);
        }

        /**
         * 
         * @param type $string (el string que se va a desencriptar)
         * @param type $key (la llave que se utilizó para encriptar)
         * @return type string
         */
        function decrypt($string, $key) {
           $result = '';
           $key = md5($key) . date('Y');
           $string = base64_decode($string);
           for($i=0; $i<strlen($string); $i++) {
              $char = substr($string, $i, 1);
              $keychar = substr($key, ($i % strlen($key))-1, 1);
              $char = chr(ord($char)-ord($keychar));
              $result.=$char;
           }
           return $result;
        }
        function generarCadenaAleatoria($longitudString = 10) {
            $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
            $longitudCadena = strlen($cadena);

            $string = "";

            for($i=0; $i < $longitudString; $i++) {
                $pos = rand(0, $longitudCadena - 1);                
                $string .= substr($cadena, $pos, 1);
            }
            return $string;
        }
        function limpiarCampo($campo) {
                $campo = htmlspecialchars(trim(addslashes(stripslashes(strip_tags($campo)))));
                $campo = str_replace(chr(160), '', $campo);
                return $campo;
            }
	
	function cadenas(){
		return 'TfhhFCtJYY';	
	}
	####formato de dinero
	function formato($valor){
		return number_format($valor,2,",",".");
	}
	#####fechas
	function fecha($fecha){
		$meses = array("ENE","FEB","MAR","ABR","MAY","JUN","JUL","AGO","SEP","OCT","NOV","DIC");
		$a=substr($fecha, 0, 4); 	
		$m=substr($fecha, 5, 2); 
		$d=substr($fecha, 8);
		return $d." / ".$meses[$m-1]." / ".$a;
	}
	#####formato de estados
	function obtenerEstatus($estado){
		if($estado == 1){
			return '<span class="label label-success">Activo</span>';
		}else{
			return '<span class="label label-important">No Activo</span>';
		}
	}
	function obtenerEstatusPostulacion($estado){
		if($estado == 'Seleccionado'){
                    return "<span class='label label-success'>$estado</span>";
                } else if ($estado == 'No Seleccionado') {
                    return "<span class='label label-important'>$estado</span>";
                } else if ($estado == 'Pre Seleccionado') {
                    return "<span class='label label-warning'>$estado</span>";
                }else{
                    return "<span class='label label-default'>$estado</span>";
		}
	}
	function cambiarEstatusDeSelecccion($estado){
		if($estado=='Seleccionado'){
			return '<span class="label label-success">Seleccionado</span>';
		}else{
			return '<span class="label label-important">No seleccionado</span>';
		}
	}
	
	function mensajes($mensaje,$tipo){
		if($tipo=='verde'){
			$tipo='alert alert-success';
		}elseif($tipo=='rojo'){
			$tipo='alert alert-error';
		}elseif($tipo=='azul'){
			$tipo='alert alert-info';
		}
		return '<div class="'.$tipo.'" align="center">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>'.$mensaje.'</strong>
            </div>';
	}
	function notificacion($mensaje, $tipo, $icono = "check"){
		if(strtolower($tipo) == 'success'){
			$tipoAlerta='success';
                        $tipo = "";
		}elseif(strtolower($tipo) =='danger'){
			$tipoAlerta='danger';
                        $tipo = "";
		}elseif(strtolower($tipo) =='info'){
			$tipoAlerta='info';
                        $tipo = "";
		}	
                
                return  '<div class="alert alert-'.$tipoAlerta.' alert-dismissible" role="alert">
                            <!--<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                            <i class="fa fa-'.$icono.'"></i><strong>'.$tipo.'</strong> '.$mensaje.'
                        </div>';
	}     
	
	
	function estado_actividad($codigo){
		$hoy=date('Y-m-d');
		$paa=mysql_query("SELECT * FROM actividad WHERE id='$codigo' and apertura<='$hoy' and cierre>='$hoy'");				
		if($re=mysql_fetch_array($paa)){
			return 's';
		}else{
			return 'n';	
		}
	}
    function formatoFecha($fecha) {        
        $nueva_fecha = explode('-', $fecha);
        return $nueva_fecha = $nueva_fecha[2] . "-" . $nueva_fecha[1] . "-" . $nueva_fecha[0];
    }
    function obtenerMesPorNombre($mes) {
        $mes = (int) $mes;
            switch ($mes) {
                case 1:
                    return 'Enero';
                break;
                case 2:
                    return 'Febrero';
                break;
                case 3:
                    return 'Marzo';
                break;
                case 4:
                    return 'Abril';
                break;
                case 5:
                    return 'Mayo';
                break;
                case 6:
                    return 'Junio';
                break;
                case 7:
                    return 'Julio';
                break;
                case 8:
                    return 'Agosto';
                break;
                case 9:
                    return 'Septiembre';
                break;
                case 10:
                    return 'Octubre';
                break;
                case 11:
                    return 'Noviembre';
                break;
                case 12:
                    return 'Diciembre';
                break;
            }
    }
    function calcularEdad($fecha) {
       list($Y,$m,$d) = explode("-", $fecha);
       return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
    }
	
?>
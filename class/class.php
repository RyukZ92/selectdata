<?php
include_once('funciones.php');
class Consultar_Alumno{
	
	private $consulta;
	private $fetch;
	
	function __construct($codigo){
		$this->consulta = mysql_query("SELECT * FROM postulantes WHERE nit='$codigo' or nombre='$codigo' or apellido='$codigo'");
		$this->fetch = mysql_fetch_array($this->consulta);
	}
	
	function consultar($campo){
		return $this->fetch[$campo];
	}
}
class Consultar_tCarrera{
	
	private $consulta;
	private $fetch;
	
	function __construct($codigo){
		$this->consulta = mysql_query("SELECT * FROM tcarrera WHERE id='$codigo' or nombre='$codigo'");
		$this->fetch = mysql_fetch_array($this->consulta);
	}
	
	function consultar($campo){
		return $this->fetch[$campo];
	}
}
class Consultar_Carrera{
	
	private $consulta;
	private $fetch;
	
	function __construct($codigo){
		$this->consulta = mysql_query("SELECT * FROM carreras WHERE id='$codigo' or nombre='$codigo' or tipo='$codigo'");
		$this->fetch = mysql_fetch_array($this->consulta);
	}
	
	function consultar($campo){
		return $this->fetch[$campo];
	}
}
class Consultar_Profesor{
	
	private $consulta;
	private $fetch;
	
	function __construct($codigo){
		$this->consulta = mysql_query("SELECT * FROM profesor WHERE nit='$codigo' or nombre='$codigo' or usu='$codigo'");
		$this->fetch = mysql_fetch_array($this->consulta);
	}
	
	function consultar($campo){
		return $this->fetch[$campo];
	}
}
class Consultar_Cursos{
	
	private $consulta;
	private $fetch;
	
	function __construct($codigo){
		$this->consulta = mysql_query("SELECT * FROM cursos WHERE id='$codigo' or nombre='$codigo'");
		$this->fetch = mysql_fetch_array($this->consulta);
	}
	
	function consultar($campo){
		return $this->fetch[$campo];
	}
}

class Consultar_Materias{
	
	private $consulta;
	private $fetch;
	
	function __construct($codigo){
		$this->consulta = mysql_query("SELECT * FROM materias WHERE id='$codigo' or director='$codigo' or nombre='$codigo'");
		$this->fetch = mysql_fetch_array($this->consulta);
	}
	
	function consultar($campo){
		return $this->fetch[$campo];
	}
}
############################################################################################################################################
class Proceso_Postulante{
	private $id;		
        private $nit;		
        private $nombre;	
        private $apellido;		
        private $genero;
	private $correo;	
        private $con;		
        private $carrera;
        private $fechaNatal;
	
	function __construct($id, $nit, $nombre, $apellido, $genero, $correo, $con, $carrera, $fechaNatal){
		$this->id=$id;				
                $this->nit=$nit; 			
                $this->nombre=$nombre;		
                $this->apellido=$apellido;
		$this->genero=$genero;		
                $this->correo=$correo;		
                $this->con=$con;			
                $this->carrera=$carrera;
                $this->fechaNatal = $fechaNatal;
	}
	
	function crear(){
		$nit=$this->nit;			
                $nombre=$this->nombre;		
                $apellido=$this->apellido;		
                $correo=$this->correo;		
                $con=$this->con;			
                $estado='s';					
                $tipo='alumno';			
		$carrera = $this->carrera;
		mysql_query("INSERT INTO postulantes (nit, nombre, apellido, genero, correo, con, tipo, estado, carrera, fecha_natal, fecha_postulacion) 
		VALUES ('$nit','$nombre','$apellido','".$this->genero."','$correo','$con','$tipo','$estado','$carrera', '".$this->fechaNatal."', '".date('Y-m-d')."')");
	}
	function actualizar(){
		$nit=$this->nit;			
                $nombre=$this->nombre;		
                $apellido=$this->apellido;		
                $correo=$this->correo;
		$genero=$this->genero;		
                $con=$this->con;			
                $id=$this->id;					
                $carrera=$this->carrera;
		mysql_query("UPDATE postulantes SET nombre='$nombre',
                            apellido='$apellido',
                            correo='$correo',
                            genero='$genero',
                            carrera='$carrera',
                            fecha_natal = '".$this->fechaNatal."'
                    WHERE id=$id");
	}
	
}

class Proceso_Profesor{
	var $id;		var $nit;		var $nombre;	var $localidad;		var $correo;
	var $celular;	var $usu;		var $con;		var $tipo;
	
	function __construct($id, $nit, $nombre, $localidad, $correo, $celular, $usu, $con, $tipo){
		$this->id=$id;				$this->nit=$nit; 			$this->nombre=$nombre;		$this->localidad=$localidad;
		$this->celular=$celular;	$this->usu=$usu;			$this->con=$con;			$this->correo=$correo;
		$this->tipo=$tipo;
	}
	
	function crear(){
		$nit=$this->nit;			$nombre=$this->nombre;		$localidad=$this->localidad;	$correo=$this->correo;
		$celular=$this->celular;	$usu=$this->usu;			$con=$this->con;				$tipo=$this->tipo;			
		#proteger variables
		$estado='s';	$tipo=$tipo;
		mysql_query("INSERT INTO profesor (nit, nombre, localidad, correo, celular, estado, tipo, usu, con) 
		VALUES ('$nit','$nombre','$localidad','$correo','$celular','$estado','$tipo','$usu','$con')");
	}
	function actualizar(){
		$nombre=$this->nombre;		$localidad=$this->localidad;	$correo=$this->correo;	$nit=$this->nit;
		$celular=$this->celular;	$id=$this->id;					$tipo=$this->tipo;
		$tipo=$tipo;
		mysql_query("UPDATE profesor SET 	nombre='$nombre',
											localidad='$localidad',
											correo='$correo',
											celular='$celular',
											tipo='$tipo'
										WHERE id=$id");
	}
	
}

class Proceso_Cursos{
	var $nombre;	var $encargado;	var $materia;	var $id;
	
	function __construct($nombre, $materia, $encargado, $id){
		$this->nombre = $nombre; 		$this->encargado = $encargado;	$this->materia=$materia;	$this->id = $id;
	}
	
	function crear(){
		$nombre=$this->nombre;		$encargado=$this->encargado;	$materia=$this->materia;	
		mysql_query("INSERT INTO cursos (nombre, materia, encargado, estado) VALUES ('$nombre','$materia','$encargado','s')");
	}
	
	function actualizar(){
		$nombre=$this->nombre;	$encargado=$this->encargado;	$materia=$this->materia;	$id=$this->id;
		mysql_query("Update cursos Set nombre='$nombre', materia='$materia', encargado='$encargado' Where id=$id");
	}	
}

class Proceso_Carrera{
	var $nombre;	var $tipo;	var $id;
	
	function __construct($nombre, $tipo, $id){
		$this->nombre = $nombre; 		$this->tipo = $tipo;	$this->id = $id;
	}
	
	function crear(){
		$nombre=$this->nombre;		$tipo=$this->tipo;
		mysql_query("INSERT INTO carreras (nombre, tipo, estado) VALUES ('$nombre','$tipo','s')");
	}
	
	function actualizar(){
		$nombre=$this->nombre;	$tipo=$this->tipo;	$id=$this->id;
		mysql_query("Update carreras Set nombre='$nombre', tipo='$tipo' Where id=$id");
	}	
}

class Proceso_Materias{
	var $nombre;	var $director;	var $id; var $credito;	var $valor;
	
	function __construct($nombre, $director, $credito, $id, $valor){
		$this->nombre = $nombre; 		$this->director = $director;	$this->credito = $credito;		$this->id = $id;
		$this->valor = $valor;
	}
	
	function crear(){
		$nombre=$this->nombre;	$director=$this->director;	$credito=$this->credito;	$valor=$this->valor;
		mysql_query("INSERT INTO materias (nombre, director, creditos, valor, estado) VALUES ('$nombre','$director','$credito','$valor','s')");
	}
	
	function actualizar(){
		$nombre=$this->nombre;	$director=$this->director;	$credito=$this->credito;	$id=$this->id;	$valor=$this->valor;
		mysql_query("Update materias Set nombre='$nombre', director='$director', creditos='$credito', valor='$valor' Where id=$id");
	}	
}

?>


<?php
/* @Descripcion: Libreria CRUD para Manejar las rutinas contra la Base datos (insertar, leer, Actualizar)
 * @Author: Jeison Varilla
 * @Version: 0.1 Beta
 * @Licencia: Libre uso GNU-GPL 
 * @E-Mail:keypherc@gamil.com 
 * @Website:www.keyphercom.com
 */

class Crud 
{
    private $pdo;
    protected function getConnect() 
    {
        $this->pdo = new DbPdo();
        return $this->pdo->connectPdo();        
    }
    protected function getDisconnect() 
    {
        return $this->pdo->disconnectPdo();        
    }
    public function guardar($tabla, $datos, $condicion = null, $id = null)
    {
        if ($condicion == null) {
            $interactor = new ArrayIterator ($datos);

            $sql="INSERT INTO $tabla (";
            while($interactor->valid()) {
                $sql .= "" . $interactor->key() . ", ";
                $interactor->next();
                }

                $sql = substr($sql, 0, -2);
                $sqlName = $sql . ")";
                $sql .=") VALUES (";
                for($i = 0; $i < $interactor->count(); $i++) {
                    $sql .= "?, ";
                }
                    $sql = substr($sql, 0, -2);
                    $sql.= ");";
                $stm = $this->getConnect()->prepare($sql);

                $i = 1;
                $sqlValue = " VALUES (";
                foreach ($interactor as $valor) {
                    $stm->bindValue($i, $valor);
                    $i++;   
                    $sqlValue .= "'$valor', ";
                }
                
                $sqlValue = substr($sqlValue, 0, -2);   #Esto es para pruebas
                $sqlValue .= ");";                      #Esto es para pruebas
                #echo $sqlCompleto = $sqlName . " " . $sqlValue ."<BR>";   #Descomentar para ver errores de SQL.
        } else {
            $sql = "UPDATE $tabla SET";
            foreach ($datos as $llave => $valor) {
                    $sql .= " $llave = '$valor', ";
            }
            $sqlName = $sql . ")";
            $sql = substr($sql, 0, -2);
            $where = trim($condicion);
            $sql .= " WHERE $condicion;";
            $stm = $this->getConnect()->prepare($sql);
            #echo $sql . "<br>";
        }       
        
        
        $result =  $stm->execute(); 
        if($id != null ) {
            $stm = $this->getConnect()->query("SELECT max(id) FROM $tabla;");
                $ultimoId = $stm->fetch(PDO::FETCH_NUM);
                $ultimoId = $ultimoId[0];				
            return $ultimoId;
        } else {
            return  $result;
        }

        $this->getDisconnect();
        return  $result;
    }
    public function contarFilas($tabla, $condicion) 
    {
        if ($condicion == null) {
            $sql = "SELECT * FROM $tabla;";
        } 
        else {
             $sql = "SELECT * FROM $tabla WHERE $condicion;";
        }
        $filas = $this->getConnect()->query($sql)->rowCount();
        $this->getDisconnect();
        //echo $sql . "<br>";
        return $filas;
    }	
    public function consultar($tabla, $datos = null, $condicion = null, $orden = null, $agrupar = null)
    {
            $constructor = new ArrayObject();
            if($datos == null) {
                $sql="SELECT * FROM $tabla";
            }else {
                $sql="SELECT";
                foreach($datos as $valor) {
                    $sql .=" $valor, ";
                }
                $sql = substr($sql, 0, -2);
                $sql .=" FROM $tabla";
            }
            if ($orden != null && $condicion == null)
                $sql .=" ORDER BY $orden;";
            elseif ($orden!=null && $condicion != null)
                $sql .=" WHERE $condicion ORDER BY $orden;";
            elseif($condicion != null)
                $sql .=" WHERE $condicion;";
            else
                $sql .=";";
            #echo $sql . "<br>";
            $stm = $this->getConnect()->query($sql);            
            while($filas=$stm->fetch(PDO::FETCH_ASSOC)) {
                $constructor->append($filas);
             }
            $this->getDisconnect();
            return $constructor;
        }
    public function eliminar($tabla, $condicion) 
    {
        if ($condicion == null) {
            $sql = "DELETE FROM $tabla;";
        } 
        else {
             $sql = "DELETE FROM $tabla WHERE $condicion;";
        }
        $filas = $this->getConnect()->query($sql)->rowCount();
        $this->getDisconnect();
        #echo $sql . "<br>";
        return $filas;
    }
}
?>

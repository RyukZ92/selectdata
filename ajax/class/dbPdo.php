<?php
/**
 * ===============================================
 * @Descripcion: Libreria de conexion a base de datos PDO
 * @compartida : Andres Guzman
 * @Licencia: Libre uso GNU-GPL
 * @Version 2.0
 * ===============================================
 */


define(DB_DNS, $config['manager']
                . ":host=" . $config['host'] . ";"
                . "dbname=" . $condig['db']);
define(DB_USERNAME, $config['user']);
define(DB_PASSWORD, $config['pass']);


class DbPdo
{
    private $pdo;
    private $dns = DB_DNS;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;

    public function connectPdo()
    {        
        try {
         $this->pdo = new PDO($this->dns, $this->username, $this->password);
         $this->pdo->exec("SET CHARACTER SET utf8");
         return $this->pdo;
         
        } catch(PDOException $e){
         echo '<B>¡Error!</b> no se puede conectar a la base de datos.<b><br>Detalle:</b> ' . $e->getMessage();
         die();
        }
    }
   public function disconnectPdo() {
      $this->pdo = null;
   }
}
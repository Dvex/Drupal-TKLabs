<?php

Class BaseDeDatos{
    private $_connec;
    const SERVER = "server"; 
    const USER = "user";
    const PASS = "pass";
    const DB = "data_base";

    function __construct() {
        try{
            $this->_connec = mysql_connect(self::SERVER, self::USER, self::PASS);
            if(!$this->_connec){
                throw new Exception("Can't connect to Server");
            }
            $db = mysql_select_db(self::DB, $this->_connec);
            if(!$db){
                throw new Exception("Can't selected DB");
            }
            
        }  catch (Exception $exc){
            error_log($exc->getMessage(), 3, "../log/error.log");
            throw $exc;
        }
    }
    
   private function executeSQL($query="", $tipo="") {
       TRY{
           $rows = mysql_query($query, $this->_connec);
           if(mysql_errno($this->_connec) != 0){
              throw new Exception(mysql_error($this->_cn));    
           }
           if($tipo == 1) {
              while ($row = mysql_fetch_array($rows, MYSQL_ASSOC)) {
                 $resultados[] = $row;
              }
              mysql_free_result($rows);
              return $resultados;
            }
       }CATCH(Exception $exc){
           error_log($exc->getMessage(), 3, "../log/error.log");
           error_log("Query Error:$query", 3, "../log/error.log");
           throw $exc;
       }
   }
   
   function extractHoteles() {
       $query = "SELECT * FROM {external_table_1}";
       $resultados = $this->executeSQL($query, 1);
       return $resultados;
   }
   
   function extractReservas() {
       $query = "SELECT * FROM {external_table_2}";
       $resultados = $this->executeSQL($query, 1);
       return $resultados;
   }
   
   function extractHotelFromReservas($value) {
       $query = "SELECT nombre FROM {external_table_1} h JOIN {external_table_2} r ON h.id = r.id WHERE r.{campo_tabla} = '$value'";
       $resultado = $this->executeSQL($query, 1);
       
       foreach ($resultado as $val) {
           $nombre = $val['name'];
       }
       
       return $nombre;
   }
}

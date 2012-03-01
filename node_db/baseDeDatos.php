<?php

Class BaseDeDatos{
    private $_connec;
    const SERVER = "localhost"; 
    const USER = "root";
    const PASS = "root";
    const DB = "syn_ordinary_db";

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
   
   function wereUpdating($rows) {
       return $rows;
   }
   
   function extractHoteles() {
       $query = "SELECT * FROM Hoteles";
       $resultados = $this->executeSQL($query, 1);
       return $resultados;
   }
   
   function extractReservas() {
       $query = "SELECT * FROM Reservas";
       $resultados = $this->executeSQL($query, 1);
       return $resultados;
   }
   
   function extractHotelFromReservas($reserva) {
       $query = "SELECT nombre FROM Hoteles h JOIN Reservas r ON h.hotel_id = r.hotel_id WHERE r.cliente = '$reserva'";
       $resultado = $this->executeSQL($query, 1);
       
       foreach ($resultado as $val) {
           $nombre = $val['nombre'];
       }
       
       return $nombre;
   }
}

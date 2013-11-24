<?php

error_reporting(0);

class Dal {
    // Acesso à base de dados
    private $servername = 'localhost';
    private $dbname = 'scare_ShippingAll';
    private $username = 'scare_check';
    private $pass = '123987';
    private $conn;

    public function __construct() {
        
    }

    public function __destruct() {
        
    }

    function db_connect()
    {
        $this->conn = mysql_connect($this->servername, $this->username, $this->pass) or die("Could not make connection to MySQL");
        mysql_select_db($this->dbname) or die ("Could not open database: ". $this->dbname);        
    }

    function db_close() {
        mysql_close();
    }
	
	

    function execute_query($query)
        {
            if(!isset($this->conn)) $this->db_connect();
            $result = mysql_query($query, $this->conn) or die("Error: ". mysql_error());
            //$returnArray = array();
            //$i=0;
            //while ($row = mysql_fetch_array($result, MYSQL_BOTH))
            //    if ($row)
			//		$returnArray[$i++]=$row;
			//mysql_free_result($result);
            //return $returnArray;
			return $result;
		}
}

?>

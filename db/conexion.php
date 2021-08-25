<?php
	include("adodb5/adodb-exceptions.inc.php");
	include("adodb5/adodb.inc.php");
	
	$db = ADONewConnection('odbc_mssql'); 
	
	function conectarDB()
	{
		global $db;
		$myUser = "lugosoft_tiempoviajar";
		$myPass = "Domola8405*";
		
		if(!$db->IsConnected())
        {
			$db = ADONewConnection('odbc_mssql');
			$db->Connect("tiempoviajar",$myUser,$myPass); //Datasource "lordpierre" creado previamente	
		}
    //$db->setCharset('utf8');
		return $db;
	}

	function desconectarDB($c)
	{
		//No se desconectara de la base de datos, se reutilizara la misma conexion
		// La base de datos se encarga de cerrar la conexion despues de tener tiempo sin usarse
		
		//$c->Close();
		//$c = null;
	}
	
	function desconectarFinDB()
	{
		global $db;
		$db->Close();
	}

?>

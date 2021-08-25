<?php 
include "conexion.php";
$nroErrorDB = "";
$msgErrorDB = ""; 

function mssql_fetch_all ($result, $num_columns, $nomConsulta = '')
{	
	$rows = array();
	$row = array();

	while (!$result->EOF)
	{
		for ($i=0; $i < $num_columns; $i++) {
			//$row[$i] = $result->fields[$i];
			$row[$i] = utf8_encode($result->fields[$i]);
		}
		$rows[] = $row;
		$row = array();
		$result->MoveNext();
	}
	
	if($nomConsulta != ''){
		$_SESSION[$nomConsulta] = array();
		$_SESSION[$nomConsulta] = $rows;
	}
	
	return $rows;	
}


// Función para consultar en MySql
function queryDB($pSql, $nomConsulta = '')
{	
	global $nroErrorDB, $msgErrorDB;
	$goDB = true;
	
	$arr = array();
	
	if($nomConsulta == ''){
		$goDB = true;
	}else{
		if($_SESSION[$nomConsulta."Check"]){		
			if(is_null($_SESSION[$nomConsulta])){
				//echo"<script> alert('goDB: $nomConsulta'); </script>";
				$goDB = true;
			}else{
				$goDB = false;
				$arr = $_SESSION[$nomConsulta];
			}
		}else{
			//echo"<script> alert('goDB(2): $nomConsulta'); </script>";
			$goDB = true;
		}
	}	
	
	if($goDB == true){
		$con = conectarDB();
		
		//registrarLogTxt("1521","<".$nomConsulta."> Conexion: ".$con->_connectionID,"");
		
		$consulta = $con->Execute($pSql);
		$num_columns = $consulta->FieldCount();
		
		$arr = mssql_fetch_all($consulta, $num_columns, $nomConsulta);
		
		$nroErrorDB = "0";
		$msgErrorDB = $con->ErrorMsg();
		$msgErrorDB = get_error_formateado($msgErrorDB);	
    
    desconectarDB($con);
	}
	
	
	
	return $arr;
}

// Función para insertar, actualizar o borrar en MySql
function modifyDB($pDML)
{	
	global $nroErrorDB, $msgErrorDB;
	$con = conectarDB();
	
	try{
    // Se ejecuta el DML que esta en utf-8 convertido a ISO-8859-1 (El que acepta BD)
    $pDML_ISO_8859 = utf8_decode($pDML);
		$res = $con->Execute($pDML_ISO_8859);
	}
	catch(Exception $e){
		$res = false;
		$msgErrorDB = $con->ErrorMsg();
		$msgErrorDB = get_error_formateado($msgErrorDB);
	}	
	if ($res == false){
		$r = -1;
		$nroErrorDB = "0";
		registrarLogTxt('SQL',$pDML);
	}else{
		try{
			$r = $con->Affected_Rows();
		}
		catch(Exception $e){
			$r = 0;
		}	
	}
  
	if($r > 0){
		resetCache($pDML);
	}
	
	desconectarDB($con);	
	return $r;	
	
}

function resetCache($sql){
	if(isModifyCache($sql, "UBICACIONES")){
		resetUbicaciones(); 
	}
	if(isModifyCache($sql, "NACIONALIDADES")){
		resetNacionalidades(); 
	}
	if(isModifyCache($sql, "PROVEEDORES")){
		resetProveedores(); 
	}
	if(isModifyCache($sql, "CLIENTES")){
		resetClientes(); 
	}
	if(isModifyCache($sql, "SERVICIOS")){
		resetServicios(); 
	}
	if(isModifyCache($sql, "USUARIOS")){
		resetUsuarios(); 
	}
}

// Función para obtener la estructura de un parametro "array('nombreParametro', 'valorParametro', 'tipoParametro', booleanIsOUTPUT);"
function getParameter($pNombre, $pValor, $pTipo="VARCHAR", $pIsOut=FALSE){
	$param = array($pNombre, $pValor, $pTipo, $pIsOut);
	return $param;
}

function get_error_formateado($msgError){
	$msg = str_replace("[Microsoft][ODBC SQL Server Driver][SQL Server]","",$msgError);
	return $msg;
}

// Funcion para ejecutar procedimiento almacenado
function callStoreProcedure($proc, $params){
/*
	$con = conectarDB();	
	$res = '';
	$msg = '';
	
	$QUERY = mssql_init($proc);
	
	mssql_bind($QUERY, "@pRes", $res, SQLVARCHAR, TRUE);
	mssql_bind($QUERY, "@pMsg", $msg, SQLVARCHAR, TRUE);
	foreach ($params as &$fila) {
		if($fila[2] == 'VARCHAR')
			$tipo = SQLVARCHAR;		
		if($fila[2] == 'INTEGER')
			$tipo = SQLINT4;			
		mssql_bind($QUERY, "@".$fila[0], $fila[1], $tipo, $fila[3]);
	}
	
	mssql_execute($QUERY);
	desconectarDB($con);

	$resultado = array('cod' => $res, 'msg' => $msg);
	
	return $resultado;
*/
}
	
// Función para obtener el error de DB
function getErrorDB($opc = 0){	
	global $nroErrorDB, $msgErrorDB;
	// Codigo y Mensaje de error.
	if($opc==0){ 
		//$error = "[".$nroErrorDB."] ".str_replace("ERROR:  ", "", $msgErrorDB);
		$error = "[".$nroErrorDB."] ";
		if($msgErrorDB){
			$error = "[".$nroErrorDB."] ".trim($msgErrorDB);//substr($msgErrorDB, 0, 16);
			registrarLogTxt('1111',$error);
		}
	}
	// Sólo el código del error.
	elseif($opc==1){ 
		$error = "".$nroErrorDB;
	}
	//Sólo el mensaje del error		
	elseif($opc==2){ 
		$error = str_replace("ERROR:  ", "", $msgErrorDB);	
	}		
	else{
		$error = "fffff";
	}
	
	/*************** Manejo de Errores **************/
	if(isError($error, "FOREIGN KEY constraint \"fk_reservas_codhot\"") ||
		isError($error, "FOREIGN KEY constraint \"fk_servparti_codhot\"")		
	){
		$error = "   El Hotel especificado no existe. Verifique.";
	}
	
	if(isError($error, "FOREIGN KEY constraint \"fk_usuarios_codcli\"") ||
		isError($error, "FOREIGN KEY constraint \"fk_reservas_codcli\"")		
	){
		$error = "   El Cliente especificado no existe. Verifique.";
	}
	
	if(isError($error, "FOREIGN KEY constraint \"fk_servxprov_codser\"") ||
		isError($error, "FOREIGN KEY constraint \"fk_tours_codser\"") ||	
		isError($error, "FOREIGN KEY constraint \"fk_restour_codser\"")		
	){
		$error = "   El Servicio especificado no existe. Verifique.";
	}
	
	if(isError($error, "FOREIGN KEY constraint \"fk_servxprov_codpro\"") ||
		isError($error, "FOREIGN KEY constraint \"fk_tours_codpro\"")		
	){
		$error = "   El Proveedor especificado no existe. Verifique.";
	}
	
	if(isError($error, "FOREIGN KEY constraint \"fk_reservas_codnac\"") ||
		isError($error, "FOREIGN KEY constraint \"fk_servparti_codnac\"")		
	){
		$error = "   La Nacionalidad especificada no existe. Verifique.";
	}
	
	if(isError($error, "FOREIGN KEY constraint \"fk_restour_numres\"")		
	){
		$error = "   La Reserva especificada no existe. Verifique.";
	}
	
	if(isError($error, "FOREIGN KEY constraint \"fk_servparti_codtour\"")		
	){
		$error = "   El Tour especificado no existe. Verifique.";
	}
	
	if(isError($error, "Violation of PRIMARY KEY constraint 'pk_vuelos'")
	){
		$error = "   El Vuelo especificado ya existe.";
	}
	
	if(isError($error, "Violation of PRIMARY KEY constraint 'pk_clientes'")
	){
		$error = "   El Cliente especificado ya existe.";
	}
	
	if(isError($error, "Violation of PRIMARY KEY constraint 'pk_usuarios'")
	){
		$error = "   El Usuario especificado ya existe.";
	}
	
	if(isError($error, "Violation of PRIMARY KEY constraint 'pk_proveedores'")
	){
		$error = "   El Proveedor especificado ya existe.";
	}
	
	if(isError($error, "Violation of PRIMARY KEY constraint 'pk_nacionalidades'")
	){
		$error = "   La Nacionalidad especificada ya existe.";
	}
	
	if(isError($error, "Violation of PRIMARY KEY constraint 'pk_ubicaciones'")
	){
		$error = "   El Hotel especificado ya existe.";
	}
  
	if(isError($error, "constraint 'uq_nitcli'")
	){
		$error = "   El NIT especificado ya existe.";
	}
	
	if(isError($error, "Violation of PRIMARY KEY constraint 'pk_servicios'")
	){
		$error = "   El Servicio especificado ya existe.";
	}
	
	if(isError($error, "Violation of PRIMARY KEY constraint 'pk_reservas'")
	){
		$error = "   La Reserva especificada ya existe.";
	}
	
	if(isError($error, "Violation of PRIMARY KEY constraint 'pk_tours'")
	){
		$error = "   El Tour especificado ya esta programado para esta fecha y hora.";
	}
	
	if(isError($error, "Violation of PRIMARY KEY constraint 'pk_servicios_particular'")
	){
		$error = "   Numero de voucher ya está registrado.";
	}
	
	if(isError($error, "Violation of PRIMARY KEY constraint 'pk_reservas_tour'")
	){
		$error = "   Reserva ya tiene asociado el servicio.";
	}
	
	if(isError($error, "Violation of PRIMARY KEY constraint 'pk_serviciosxproveedor'")
	){
		$error = "   Proveedor ya esta asociado a servicio.";
	}

	if(isError($error, "Violation of UNIQUE KEY constraint 'uq_reservas_voucher'")
	){
		$error = "   El Voucher especificado ya existe.";
	}
		
	return $error;
	
}

function isError($msgError, $cadenaError){
	$ban = false;
	$resultado = strpos($msgError, $cadenaError);
	if($resultado !== FALSE){
		$ban = true;
	}
	return $ban;
}

function isModifyCache($sql, $tabla){
	$ban1 = false;
	$ban2 = false;
	$ban3 = false;
	$ban4 = false;
	$sql = strtoupper ($sql);
	$tabla = strtoupper ($tabla);
	
	$resultado = strpos($sql, " ".$tabla);
	if($resultado !== FALSE){
		$ban1 = true;
	}
	
	$resultado = strpos($sql, "INSERT ");
	if($resultado !== FALSE){
		$ban2 = true;
	}
	
	$resultado = strpos($sql, "UPDATE ");
	if($resultado !== FALSE){
		$ban3 = true;
	}
	
	$resultado = strpos($sql, "DELETE ");
	if($resultado !== FALSE){
		$ban4 = true;
	}
	
	if(($ban1 == true) && (($ban2 == true)||($ban3 == true)||($ban4 == true))){
		return true;
	}else{
		return false;
	}
	
}

function actualDate($format, $timestamp = null){
	$timestamp = time();
	$gmt = '-5';
	$gmt = $gmt*60*60;
	$timestamp = $timestamp + $gmt;
	return gmdate($format,$timestamp);
}

function actualDateMenosNdays($format, $nDays){
	$timestamp = time();
	$gmt = '-5';
	$gmt = $gmt*60*60;
	$timeResta = $nDays*24*60*60;
	$timestamp = $timestamp + $gmt - $timeResta;
	return gmdate($format,$timestamp);
}

function registrarLogTxt($numero,$texto,$user = ''){
	if($user == '')
		$user = $_SESSION["user"];
		
	$ddf = fopen('logs/log.txt','a');
	fwrite($ddf,"\n[".actualDate("d/m/Y G:i:s")."] <$numero> <".$user."> <".getRealIpAddr()."> <".session_id().">:\n$texto");
	fclose($ddf);
}

function getRealIpAddr() {
   if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
   } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
   }else{
		  $ip=$_SERVER['REMOTE_ADDR'];
   }
	return $ip;
}
	
function registrarSesionTxt($numero,$user,$texto){
	$ddf = fopen('logs/sesion.txt','a');
	fwrite($ddf,"\n[".actualDate("d/m/Y G:i:s")."] <$numero> <".$user."> <".getRealIpAddr()."> <".session_id().">: $texto");
	fclose($ddf);
}

?>

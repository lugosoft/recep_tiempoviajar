<?php 
session_start();


include "db/funciones_db.php";
include "db/consultas.php";
include "library/alfabeto.php";
require_once "library/excel/PHPExcel.php";
include "xajax/libreria_xajax.php";

$MAX_FILAS_REPORTE = 10;

function getLanguageSelected(){
	if($_SESSION["languageSelected"])
		return true;
	else
		return false;	
}

if (@getLanguageSelected()){
	
}else{
	$_SESSION["language"] = "es";
}

function setLanguage($pLang){
	$output = new xajaxResponse();
	$_SESSION["language"] = $pLang;
	$_SESSION["languageSelected"] = true;
	$output->script("window.location.reload();");
	return $output;	
}

$docXML = @(new DOMDocument());

//@($docXML->load( "library/lang_es_2.xml" ));	
@($docXML->load( $FILE_LANGUAGE ));	

function cargarTablaReservas($nrores) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();
	
	$num = $nrores;
	
	$output->assign("imgAct1","style.display", "none");	
	//$output->assign("imgEli1","style.display", "");
	$output->assign("imgEli1","style.display", "none");
	for($i=2;$i<=$num;$i=$i+1){
		$output->assign("res$i","style.display", "");
		$output->assign("imgAct$i","style.display", "none");	
		//$output->assign("imgEli$i","style.display", "");
		$output->assign("imgEli$i","style.display", "none");
		$output->assign("imgObs$i","src", "images/edit.png");
	}
	
	for($i=$num+1;$i<=50;$i=$i+1){
		$output->assign("res$i","style.display", "none");
	}
		
	// Y para finalizar debemos retornar nuestra salida XAJAX.   
	return $output; 
 }  

function resetServicios(){ 	
	$_SESSION["queryListaServicios2"] = null; 
	$_SESSION["queryListaServicios"] = null; 
	$_SESSION["queryConteoServicios"] = null; 
	$_SESSION["queryListaPaquetes"] = null; 
}

function resetClientes(){ 	
	$_SESSION["queryListaClientes"] = null; 
}

function resetNacionalidades(){ 	
	$_SESSION["queryListaNacionalidades"] = null; 
}

function resetUsuarios(){ 	
	$_SESSION["queryListaUsuarios"] = null; 
	$_SESSION["queryListaRoles"] = null; 
}
	
function resetProveedores(){ 	
	$_SESSION["queryListaProveedores"] = null; 
	$_SESSION["queryConteoProveedores"] = null; 
}

function resetUbicaciones(){ 	
	$_SESSION["queryListaHoteles"] = null; 				
	$_SESSION["queryListaOtrUbi"] = null; 
	$_SESSION["queryListaArpUbi"] = null; 
	$_SESSION["queryListaMueUbi"] = null; 
}
	
function printVar($var){
	if ($var)
		echo($var);	
}

function printVarJSfromDB($pDominio){
	$res = array();
	$sql  = @getSql("queryRefCodesXDominio",$pDominio);
	$res = queryDB($sql);
	
	echo "\n<script>\n";
	echo "/* Variables $pDominio */\n";
	foreach ($res as &$fila) {
		echo "var $fila[0] = $fila[1];\n";
	}
	echo "</script>\n";
} 

function printTouresPaquetes(){
	/*
  $res = array();
	$sql  = @getSql("queryListaPaquetes");
	$res = queryDB($sql,"queryListaPaquetes");
	echo "\n";
	foreach ($res as &$fila) {
		$res2 = array();
		$sql2  = @getSql("queryListaServiciosPq2", $fila[0]);
		$res2 = queryDB($sql2);
		$servs = '';
		foreach ($res2 as &$fila2){
			$servs = $servs.', '.$fila2[1];
		}
		echo "<a id='textoPaqServicios' name='textoPaqServicios' class='textoPaqServicios'>El <b>".$fila[1]."</b> incluye los tours: ".substr($servs, 1, 500).".</a>";
		echo "<br>\n";
	}
  */
} 

function getVarPHPfromDB($pVar){
	$res = array();
	$sql  = @getSql("queryRefCodes", 'VAR_PHP_GENERAL', $pVar);
	$res = queryDB($sql);
	$val = '<NULL>';
	foreach ($res as &$fila) {
		$val = $fila[0];
	}
	return $val;
} 

function getMes(){
	$fechasecs = time ();
	$mon = actualDate( "F" , $fechasecs );
	
	if ($_SESSION["language"] == 'en'){
		$mes = $mon;
	}
	else{
		$mes = strtoupper( $mon );
		if ($mes == "JANUARY")
			$mes = "Enero";
		elseif ($mes == "FEBRUARY") 
			$mes = "Febrero";
		elseif ($mes == "MARCH") 
			$mes = "Marzo";
		elseif ($mes == "APRIL") 
			$mes = "Abril";		
		elseif ($mes == "MAY") 
			$mes = "Mayo";
		elseif ($mes == "JUNE") 
			$mes = "Junio";
		elseif ($mes == "JULY") 
			$mes = "Julio";
		elseif ($mes == "AUGUST") 
			$mes = "Agosto";
		elseif ($mes == "SEPTEMBER") 
			$mes = "Septiembre";
		elseif ($mes == "OCTOBER") 
			$mes = "Octubre";		
		elseif ($mes == "NOVEMBER") 
			$mes = "Noviembre";
		elseif ($mes == "DECEMBER") 
			$mes = "Diciembre";			
	}		
										
	return $mes;
}

function getFechaCompleta(){
	$fechasecs = time ();
	$mes = getMes();
	if ($_SESSION["language"] == 'en'){
		$resDate = $mes.actualDate( " j\,").actualDate(" Y" , $fechasecs );
	}else{
		$resDate = actualDate( "j ").$mes.actualDate(" Y" , $fechasecs );	
	}	
	return $resDate;
}

function getFechaddmmyyyy(){
	$resDate = actualDate( "d\/m\/Y");		
	return $resDate;
}

function getFecha0101yyyy(){
	$resDate = actualDate( "01\/01\/Y");		
	return $resDate;
}


function getFecha01mmyyyy(){
	$resDate = actualDate( "01\/m\/Y");		
	return $resDate;
}

function getFechayyyymmdd(){
	$resDate = actualDate( "Y\-m\-d");		
	return $resDate;
}

function getFechayyyymmddhhmm(){
	$resDate = actualDate( "Y\-m\-d G\:i");		
	return $resDate;
}

function getFechayyyymmddhhmmss(){
	$resDate = actualDate( "Y\-m\-d G\:i:s");		
	return $resDate;
}

function getFechaHoy(){
	$resDate = getFechayyyymmdd();		
	return $resDate;
}

function getFechaAno(){
	$resDate = getFechayyyymmdd();		
	return substr($resDate, 0, 4);
}

function getFechaMes(){
	$resDate = getFechayyyymmdd();		
	return substr($resDate, 5, 2);
}

function getFechaDia(){
	$resDate = getFechayyyymmdd();		
	return substr($resDate, 8, 2);
}

function getFechasDeshabilitadas($daysBefore = 1){

  $currDate = actualDate( "Y\-m\-d");
  $pastDate = strtotime('-'.$daysBefore.' day', strtotime($currDate));
  $pastDate = date('Y\-m\-d', $pastDate);
  
  $ano = substr($pastDate, 0, 4);
  $mes = (int)substr($pastDate, 5, 2);
  $mes = $mes - 1; // En JS los meses comienzan en cero
  $dia = (int)substr($pastDate, 8, 2);
  
  
  return " scwDisabledDates[0] = [new Date(2018,0,1),new Date({$ano},{$mes},{$dia})];";
}

function getFechaDB($fecha){
	// Convierte la fecha recibida que viene en formato 'yyyy-mm-dd HH:MM' en el formato necesario
	// para la base de datos.
	// Para SQL Server se retorna el formato 'yyyymmdd HH:MM'
	$fecha = str_replace("-","",$fecha);
	$fecha = str_replace(".","",$fecha);
	
	$fecha = "'".$fecha."'";		
	return $fecha;
}

function getFechaDBToInterfaz($pFecha){
	// Convierte la fecha recibida en formato de base de datos YYYY.MM.DD al formato de interfaz DD/MM/YYYY
	$pFecha = substr($pFecha, 8, 2).'/'.substr($pFecha, 5, 2).'/'.substr($pFecha, 0, 4);
	return $pFecha;
}

function getFechaDBToYYYYMMDD($pFecha){
	// Convierte la fecha recibida en formato de base de datos YYYY.MM.DD al formato YYYYMMDD
	$pFecha = str_replace(".","",$pFecha);
	return $pFecha;
}

function getFechaDBToYYYY_MM_DD($pFecha){
	// Convierte la fecha recibida en formato de base de datos YYYY.MM.DD al formato YYYYMMDD
	$pFecha = str_replace(".","-",$pFecha);
	return $pFecha;
}

function getHoraDBToInterfaz($pHora){
	// Convierte la hora recibida en formato de base de datos HH:MM:SS al formato de interfaz HH:MM
	$pHora = substr($pHora, 0, 5);
	return $pHora;
}

function getLoginStatus($pUser,$pPass) 
 {  
	$res = array();
	$sql  = @getSql("queryLogin",$pUser,$pPass);
	$res = queryDB($sql);

	if($res){
		registrarSesionTxt(1,$pUser,"Inicio de sesion correcto");
		return true;		
	}
	else{
		registrarLogTxt(-1, "Error: ".getErrorDB(), $pUser);
		registrarLogTxt(-2, "Consulta: ".$sql, $pUser);
		return false; 
	}	
 }
 
function getNameUser($user)
{	
	$res = array();
	$sql  = @getSql("queryNameUser",$user);
	$res = queryDB($sql);
	$name = '&lt;NULL&gt;';
	foreach ($res as &$fila) {
		$name = $fila[0];
	}
	
	return $name;
} 

function getTelUser($user)
{	
	$res = array();
	$sql  = @getSql("queryNameUser",$user);
	$res = queryDB($sql);
	$tel = '&lt;NULL&gt;';
	foreach ($res as &$fila) {
		$tel = $fila[1];
	}
	
	return $tel;
}


function getNomOfi($codOfi)
{	
	$res = array();
	$sql  = @getSql("queryOficina",$codOfi);
	$res = queryDB($sql);
	$name = '&lt;NULL&gt;';
	foreach ($res as &$fila) {
		$name = $fila[0];
	}
	
	return $name;
}

function getPrefijoOfi($codOfi)
{	
	$res = array();
	$sql  = @getSql("queryOficina",$codOfi);
	$res = queryDB($sql);
	$prefijo = '&lt;NULL&gt;';

	foreach ($res as &$fila) {
		$prefijo = $fila[1];
	}
	
	return $prefijo;
}

function getTipoGral($pTipo){
	if(substr($pTipo, 0, 2) == 'IN'){
		$pTipo = 'IN';
	}	
	if(substr($pTipo, 0, 3) == 'OUT'){
		$pTipo = 'OUT';
	}
	return $pTipo;
}

function getTipoEspecifico($pTipo, $pNumTrans){
	$res = array();
	$sql  = @getSql("queryConsecutivo", $pTipo, $pNumTrans);
	$res = queryDB($sql);
	foreach ($res as &$fila) {
		$pTipo = $fila[0];
	}
	return $pTipo;
}

function printOpcionesCodOfi($defVal){	
	$res = array();
	$sql  = @getSql("queryListaOficinas");
	$res = queryDB($sql);
	
	foreach ($res as &$fila) {
    $selected = "";
    if($defVal == $fila[0]){
      $selected = "selected='selected'";
    }
		echo "<option value='$fila[0]' {$selected}>$fila[1]</option>";
	}
}

function printOpcionesTipoVoucher(){	
	$res = array();
	$sql  = @getSql("queryListaOficinas");
	$res = queryDB($sql);
	
	foreach ($res as &$fila) {
		if($fila[2] != ''){
			echo "<option value='$fila[2]'>$fila[2]</option>";
		}
	}

	//echo "<option value='OTR'>Transfer-Otros</option>";
}

function printOpcionesCodAge(){	
	$res = array();
	$sql  = @getSql("queryListaClientesShort");
	$res = queryDB($sql);
	
	foreach ($res as &$fila) {
		echo "<option value='{$fila[0]}'>{$fila[1]}</option>";
	}
}



function printOpcionesCodSer(){	
	$res = array();
	$sql  = @getSql("queryListaServicios2");
	$res = queryDB($sql);
	
	foreach ($res as &$fila) {
		echo "<option value='$fila[0]'>$fila[1]</option>";
	}
}


function printOpcionesCodNac(){	
	$res = array();
	/*
	$sql  = @getSql("queryListaNacionalidades");
	$res = queryDB($sql, "queryListaNacionalidades");
	
	foreach ($res as &$fila) {
		echo "<option value='$fila[0]'>$fila[1]</option>";
	}
	*/
	echo "<option value='COL'>Colombia</option>";
}

function printOpcionesNroVlo($pTipo) 
 { 
	$res = array();
	$sql  = @getSql("queryVuelosXTipo",$pTipo);
	$res = queryDB($sql);
	foreach ($res as &$fila) {
		echo "<option value='$fila[1]'>$fila[1]</option>";
	}
}
	
function printOpcionesUsuarios(){	
	$res = array();
	$sql  = @getSql("queryListaUsuarios");
	$res = queryDB($sql, "queryListaUsuarios");
	echo "<option value='<NULL>'>----</option>";
	foreach ($res as &$fila) {
		echo "<option value='$fila[0]'>$fila[0]</option>";
	}
}

function printOpcionesOperacionLog(){	
	$res = array();
	$sql  = @getSql("queryListaOperacionesLog");
	$res = queryDB($sql, "queryListaOperacionesLog");
	echo "<option value='<NULL>'>----</option>";
	foreach ($res as &$fila) {
		echo "<option value='$fila[0]'>$fila[1]</option>";
	}
}

function printOpcionesTablaLog(){	
	$res = array();
	$sql  = @getSql("queryListaTablasLog");
	$res = queryDB($sql, "queryListaTablasLog");
	//echo "<option value='<NULL>'>----</option>";
	foreach ($res as &$fila) {
		echo "<option value='$fila[0]'>$fila[1]</option>";
	}
}

function printOpcionesMes($lang){	
	if ($lang == 'en'){
		echo "
		<option value='01'>January</option>\n
		<option value='02'>February</option>\n
		<option value='03'>March</option>\n
		<option value='04'>April</option>\n
		<option value='05'>May</option>\n
		<option value='06'>June</option>\n
		<option value='07'>July</option>\n
		<option value='08'>August</option>\n
		<option value='09'>September</option>\n
		<option value='10'>October</option>\n
		<option value='11'>November</option>\n
		<option value='12'>December</option>
		";						
	}
	else{
		echo "
		<option value='01'>Enero</option>\n
		<option value='02'>Febrero</option>\n
		<option value='03'>Marzo</option>\n
		<option value='04'>Abril</option>\n
		<option value='05'>Mayo</option>\n
		<option value='06'>Junio</option>\n
		<option value='07'>Julio</option>\n
		<option value='08'>Agosto</option>\n
		<option value='09'>Septiembre</option>\n
		<option value='10'>Octubre</option>\n
		<option value='11'>Noviembre</option>\n
		<option value='12'>Diciembre</option>
		";
	}	
}

function printOpcionesCodRol(){	
	$res = array();
	$sql  = @getSql("queryListaRoles");
	$res = queryDB($sql, "queryListaRoles");
	
	foreach ($res as &$fila) {
		$def = '';
		if($fila[0] == 'ASE')
			$def = "selected='selected'";
		echo "<option value='$fila[0]' $def>$fila[1]</option>";
	}
}

function printOpcionesCodPro() 
 { 
	$res = array();
	$sql  = @getSql("queryListaProveedores");
	$res = queryDB($sql, "queryListaProveedores");
	foreach ($res as &$fila) {
		echo "<option value='$fila[0]'>$fila[1]</option>";
	}
}

function getOpcionesProveedorXServ($pCodSer){
	$res = array();
	$sql  = @getSql("queryListaProveedoresXServ", $pCodSer);
	$res = queryDB($sql);
	return $res;
}

function printOpcionesCodHot() 
 { 
	$res = array();  
	$sql  = @getSql("queryListaHoteles", $_SESSION["oficina"]);
	$res = queryDB($sql);
	foreach ($res as &$fila) {
		echo "<option value='$fila[0]'>{$fila[1]}</option>";
	}
}

function printOpcionesCodHotAll() 
 { 
	$res = array();
	$sql  = @getSql("queryListaHotelesAll");
	$res = queryDB($sql);
	foreach ($res as &$fila) {
		echo "<option value='$fila[0]'>{$fila[1]}</option>";
	}
}

function getOpcionesCodHot(){	
	$res = array();
	$sql  = @getSql("queryListaHoteles", $_SESSION["oficina"]);
	$res = queryDB($sql);
	
	return $res;
}

function getOpcionesCodPaq(){	
	$res = array();
	$sql  = @getSql("queryListaPaquetes", $_SESSION["oficina"]);
	$res = queryDB($sql);
	
	return $res;
}

function printOpcionesCodPaq() 
 { 
	$res = array();
	$sql  = @getSql("queryListaPaquetesAll");
	$res = queryDB($sql);
	foreach ($res as &$fila) {
		echo "<option value='$fila[0]'>$fila[1]</option>";
	}
}

function printOpcionesAllCodPaq() 
 { 
	$res = array();
	$sql  = @getSql("queryListaPaquetesAll");
	$res = queryDB($sql);
  // Se incluye opcion de todos los genericos
  echo "<option value='GEN%'>*Todos los GENERICOS*</option>";
	foreach ($res as &$fila) {
		echo "<option value='$fila[0]'>$fila[1]</option>";
	}
}

function getValueXML($raiz, $etiqueta, $js = 'no'){
	global $docXML;
	$raiz = $docXML->getElementsByTagName( $raiz );
	$valor = '&lt;NULL&gt;';
	foreach( $raiz as $reg )
	{
		$etiquetaValor = $reg->getElementsByTagName( $etiqueta );
		$valor = $etiquetaValor->item(0)->nodeValue; 			
	}
	return getMsgCaractEsp($valor, $js);
}



function printValueXML($raiz, $etiqueta){
	global $docXML;
	$raiz = $docXML->getElementsByTagName( $raiz );
	$valor = '&lt;NULL&gt;';
	foreach( $raiz as $reg )
	{
		$etiquetaValor = $reg->getElementsByTagName( $etiqueta );
		$valor = $etiquetaValor->item(0)->nodeValue; 			
	}
	echo getMsgCaractEsp($valor);
}

function getArrayServicios() {
	$servicios = array();
	$servicio = array();	
	$res = array();
	$sql  = @getSql("queryListaServicios");
	$res = queryDB($sql,"queryListaServicios");
	$i = 1;
	foreach ($res as &$fila) {		
		$servicio = array('it' => $i, 'cod' => $fila[0], 'desc' => $fila[1]);
		$servicios[$i] = $servicio;					
		$i++;	
	}
	return $servicios;
}

function getArrayProveedores() {
	$proveedores = array();
	$proveedor = array();	
	$res = array();
	$sql  = @getSql("queryListaProveedores");
	$res = queryDB($sql,"queryListaProveedores");
	$i = 1;
	foreach ($res as &$fila) {		
		$proveedor = array('it' => $i, 'cod' => $fila[0], 'desc' => $fila[1]);
		$proveedores[$i] = $proveedor;					
		$i++;	
	}
	return $proveedores;
}

function getNroServicios()
{	
	$res = array();
	
	$sql  = @getSql("queryConteoServicios");
	$res = queryDB($sql, "queryConteoServicios");
	$nro = '0';
	foreach ($res as &$fila) {
		$nro = $fila[0];
	}	
	return $nro;
}

function getNroProveedores()
{	
	$res = array();
	$sql  = @getSql("queryConteoProveedores");
	$res = queryDB($sql,"queryConteoProveedores");
	$nro = '0';
	foreach ($res as &$fila) {
		$nro = $fila[0];
	}	
	return $nro;
}

function inicializarServiciosReservas(){
	$res = array();
	$sql  = @getSql("queryListaServicios");
	$res = queryDB($sql,"queryListaServicios");
	$nroIndex = getNroServicios()+1;
	echo"<script>
		var res = 1;\n
		var servicios = new Array($nroIndex);\n
		var reservas = new Array(51);\n
		";
	for($j=1;$j<=50;$j++){
		echo"servicios = new Array($nroIndex);\n";
		$i = 1;	
		foreach ($res as &$fila) {
			if($fila[2] == 'NO'){
				$defa = 'false';	
			}else{
				$defa = 'true';		
			}		
			echo"servicios[$i] = new Array(null,'$fila[0]','$defa');\n";						
			$i++;	
		}
		echo"reservas[$j] = new Array (null,servicios,'','','','','','','','','','NULL');\n";
	}
	echo"</script>";	
}

function limpiarServiciosReservas(){
	$res = array();
	$sql  = @getSql("queryListaServicios");
	$res = queryDB($sql,"queryListaServicios");
	$nroIndex = getNroServicios()+1;
	echo"function limpiarServiciosReservas(){\n
		res = 1;\n
		servicios = new Array($nroIndex);\n
		reservas = new Array(51);\n
		";
	for($j=1;$j<=50;$j++){
		echo"servicios = new Array($nroIndex);\n";
		$i = 1;	
		foreach ($res as &$fila) {
			$defa = 'false';		
			echo"servicios[$i] = new Array(null,'$fila[0]','$defa');\n";						
			$i++;	
		}
		echo"reservas[$j] = new Array (null,servicios,'','','','','','','','','','NULL');\n";
	}
	echo"}";	
}

function inicializarProveedores(){
	$res = array();
	$sql  = @getSql("queryListaProveedores");
	$res = queryDB($sql,"queryListaProveedores");
	$nroIndex = getNroProveedores()+1;
	echo"\n<script>\n
		var proveedores = new Array($nroIndex);\n
		";
		$i = 1;
		foreach ($res as &$fila) {
			$val = 'false';	
			echo"proveedores[$i] = new Array(null,'$fila[0]','$val','');\n";
			$i++;
		}
	echo"</script>";	
}

function limpiarProveedoresServicio(){
	$res = array();
	$sql  = @getSql("queryListaProveedores");
	$res = queryDB($sql,"queryListaProveedores");
	$nroIndex = getNroProveedores()+1;
	echo"\nfunction limpiarProveedoresServicio(){\n
		proveedores = new Array($nroIndex);\n
		";
		$i = 1;
		foreach ($res as &$fila) {
			$val = 'false';	
			echo"proveedores[$i] = new Array(null,'$fila[0]','$val','');\n";
			$i++;
		}
	echo"}";
}

$reservas = array();
$serviciosBase = array();

function setServicioRes($itres,$itser,$dato)
{
	global $reservas;
	$reservas[$itres][1][$itser][2]=$dato; 
}

function getServicioRes($itres,$itser)
{
	global $reservas;
	return $reservas[$itres][1][$itser][2];
}


function getValueFromArrString($dato, $index){
  $val = '';
  $arr = explode("|", $dato);
  if(count($arr) >= ($index+1)){
    $val = $arr[$index];
  }
  return $val;
}

function setNomPaxRes($itres,$dato)
{
	global $reservas;
	$reservas[$itres][2]=$dato;
}

function getNomPaxRes($itres)
{
	global $reservas;
	return $reservas[$itres][2];
}

function setTelPaxRes($itres,$dato)
{
	global $reservas;
	$reservas[$itres][13]=$dato;
}

function getTelPaxRes($itres)
{
	global $reservas;
	return $reservas[$itres][13];
}


function setDocuPaxRes($itres,$dato)
{
	global $reservas;
	$reservas[$itres][14]=$dato;
}

function getDocuPaxRes($itres)
{
	global $reservas;
	return $reservas[$itres][14];
}

function setNacRes($itres,$dato)
{
	global $reservas;
  $dato = getValueFromArrString($dato, 0);
	$reservas[$itres][3]=$dato;
}

function getNacRes($itres)
{
	global $reservas;
	return $reservas[$itres][3];
}

function setNumPaxRes($itres,$dato)
{
	global $reservas;
	$reservas[$itres][4]=$dato;
}

function getNumPaxRes($itres)
{
	global $reservas;
	return $reservas[$itres][4];
}

function setFecLlegaRes($itres,$dato)
{
	global $reservas;
	$reservas[$itres][5]=$dato;
}

function getFecLlegaRes($itres)
{
	global $reservas;
	return $reservas[$itres][5];
}

function setFecSaleRes($itres,$dato)
{
	global $reservas;
	$reservas[$itres][6]=$dato;
}

function getFecSaleRes($itres)
{
	global $reservas;
	return $reservas[$itres][6];
}

function setHotelRes($itres,$dato)
{
	global $reservas;
	$reservas[$itres][7]=$dato;
}

function getHotelRes($itres)
{
	global $reservas;
	return $reservas[$itres][7];
}

function setVloLlegaRes($itres,$dato)
{
	global $reservas;
  $dato = getValueFromArrString($dato, 0);
	$reservas[$itres][8]=$dato;
}

function getVloLlegaRes($itres)
{
	global $reservas;
	return $reservas[$itres][8];
}


function getHoraLlegaRes($itres)
{
	global $reservas;
	return $reservas[$itres][101];
}

function getAsesorAge($itres)
{
	global $reservas;
	return $reservas[$itres][104];
}

function setVloSaleRes($itres,$dato)
{
	global $reservas;
  $dato = getValueFromArrString($dato, 0);
	$reservas[$itres][9]=$dato;
}

function getVloSaleRes($itres)
{
	global $reservas;
	return $reservas[$itres][9];
}

function getHoraSaleRes($itres)
{
	global $reservas;
	return $reservas[$itres][102];
}

function setObservacionRes($itres,$dato)
{
	global $reservas;
	$reservas[$itres][10]=$dato;
}

function getObservacionRes($itres)
{
	global $reservas;
	return $reservas[$itres][10];
}

function setBorradaRes($itres,$dato)
{
	global $reservas;
	$reservas[$itres][11]=$dato;
}

function getBorradaRes($itres)
{
	global $reservas;
	return $reservas[$itres][11];
}

function setVoucher($itres,$dato)
{
	global $reservas;
	$reservas[$itres][12]=$dato;
}

function getVoucher($itres)
{
	global $reservas;
	return $reservas[$itres][12];
}

function getPaquete($itres)
{
	global $reservas;
	return $reservas[$itres][103];
}

$proveedores = array();
function setProveedorSer($itpro,$dato)
{
	global $proveedores;
	$proveedores[$itpro][2]=$dato; 
}

function getProveedorSer($itpro)
{
	global $proveedores;
	return $proveedores[$itpro][2];
}

function setProveedorCosSer($itpro,$dato)
{
	global $proveedores;
	$proveedores[$itpro][3]=$dato; 
}

function getProveedorCosSer($itpro)
{
	global $proveedores;
	return $proveedores[$itpro][3];
}


function registrarResRes($oficina, $pNumRes, $pResRes, $pDocupax, $pNompax, $pNac, $pNumpax, 
                         $pFecllega, $pFecsale, $pCodCli, $pHotel, $pVlollega, $pVlosale, $pCodUsu, 
                         $pObs, $pBorr, $pVou, $pTelpax, $numResActualizar, $horallega, $horasale, 
                         $paquete, $asesorAge){
	//$hoy = getFechayyyymmdd();
	$hoy = getFechaHoy();
	$hoy = getFechaDB($hoy);
	
	//registrarLogDB("REG", "RES", 0, "++$pFecllega++$pFecsale++");
	
  if($pFecllega == ''){
    // Se toma por default una fecha de 1900
    $pFecllega = '1900-01-01';
  }
  if($pFecsale == ''){
    // Se toma por default una fecha de 1900
    $pFecsale = '1900-01-01';
  }
  
	$pFecllega = getFechaDB($pFecllega);
	$pFecsale = getFechaDB($pFecsale);
	//registrarLogDB("REG", "RES", 0, "++$pFecsale");
	if($numResActualizar == '0'){
		$sql  = @getSql("insertReserva",$hoy,$pNumRes,$pResRes,$pFecllega,$pFecsale,
										$pCodCli,$pNompax,$pNac,$pNumpax,$pVlollega,
										$pHotel,$pVlosale,$pCodUsu,$pObs,$pBorr,
                    $pVou,$pTelpax,$pDocupax,$oficina, $horallega, 
                    $horasale, $paquete, $asesorAge);

	}else{
		$res2 = array();
		$sql2  = @getSql("queryReservaXResRes", $numResActualizar, '1');
		$res2 = queryDB($sql2);
		$fdig = '';
		foreach ($res2 as &$fila2) {
			$fdig = $fila2[12];
		}
		$fdig = getFechaDB($fdig);
		$sql  = @getSql("insertReserva",$fdig,$pNumRes,$pResRes,$pFecllega,$pFecsale,
										$pCodCli,$pNompax,$pNac,$pNumpax,$pVlollega,
										$pHotel,$pVlosale,$pCodUsu,$pObs,$pBorr,
                    $pVou,$pTelpax,$pDocupax,$oficina, $horallega, 
                    $horasale, $paquete, $asesorAge);	
	}
	$r = modifyDB($sql);
	
	return $r;
}

function getReservas($pqReservas,$pqServicios){
	global $reservas;
	$reservas = array();
	
	$filaReserva = explode("/;/",$pqReservas,-1);	
	for($i=0;$i<=count($filaReserva)-1;$i++){						
			$datoReserva = explode("/,/",$filaReserva[$i],-1);
			for($j=0;$j<=count($datoReserva)-1;$j++){
        if($j+2 == 8){
          // Se extrae vueloLLega
          $reservas[$i+1][101] = getValueFromArrString($datoReserva[$j], 1);
          $datoReserva[$j] = getValueFromArrString($datoReserva[$j], 0);
        }
        
        if($j+2 == 9){
          // Se extrae vueloSale
          $reservas[$i+1][102] = getValueFromArrString($datoReserva[$j], 1);
          $datoReserva[$j] = getValueFromArrString($datoReserva[$j], 0);
        }
        
        if($j+2 == 12){
          // Se extrae paquete
          $reservas[$i+1][103] = getValueFromArrString($datoReserva[$j], 0);
          $datoReserva[$j] = getValueFromArrString($datoReserva[$j], 1);
        }
        
        if($j+2 == 3){
          // Se extrae asesor agencia de la nacionalidad (3)
          $reservas[$i+1][104] = getValueFromArrString($datoReserva[$j], 1);
          $datoReserva[$j] = getValueFromArrString($datoReserva[$j], 0);
        }
        
				$reservas[$i+1][$j+2] = $datoReserva[$j];
			}
	}
	
		
	$filaServicios = explode("/;/",$pqServicios,-1);
	for($i=0;$i<=count($filaServicios)-1;$i++){			
			$datoServicio = explode("/,/",$filaServicios[$i],-1);			
			for($j=0;$j<=count($datoServicio)-1;$j++){
				$dato = explode(":",$datoServicio[$j],-1);				
				$reservas[$i+1][1][$j+1][1] = $dato[0];				
				$reservas[$i+1][1][$j+1][2] = $dato[1];
			}
	}

}

function registrarServRes($pNumRes,$pResRes,$pServ){
	$codUsu = $_SESSION["user"];
	//$hoy = getFechayyyymmdd();
	$hoy = getFechaHoy();
	$hoy = getFechaDB($hoy);
	
	$res = array();
	$sql  = @getSql("queryIsPaquete", $pServ);
	$res = queryDB($sql);
	$isPaq = 'NO';
	foreach ($res as &$fila) {
		$isPaq = $fila[0];
	}
	$r = '0';
	if($isPaq == 'NO'){
		$sql  = @getSql("insertServicioReserva", $pNumRes, $pResRes, $pServ, $codUsu, $hoy);
		$r = modifyDB($sql);
	}else{
		$res2 = array();
		$sql2  = @getSql("queryListaServiciosPq", $pServ);
		$res2 = queryDB($sql2);
		
		$sql3  = @getSql("insertServicioReserva", $pNumRes, $pResRes, $pServ, $codUsu, $hoy);
		$r = modifyDB($sql3);
		
		foreach ($res2 as &$fila2) {
			$sql3  = @getSql("insertServicioReserva", $pNumRes, $pResRes, $fila2[0], $codUsu, $hoy);
			$r = modifyDB($sql3);
		}
		$r = '1';
	}
	
	return $r;
}

function crearConsecutivos($pTipo, $pCant){
	$ban = false;
	
	$res = array();
	$sql  = @getSql("queryNumConsecMax", $pTipo);
	$res = queryDB($sql);
	$inicio = '0';
	foreach ($res as &$fila) {
		$inicio = $fila[0];
	}
	
	if($inicio != '0'){
		$j = $pCant/50;
		$i=1;
		$nro = $inicio;
		while($i<=$j){
			$sql  = @getSql("insertConsecutivoRango", $pTipo, $nro, 'LIB');
			$r = modifyDB($sql);	
			if ($r > 0){
				$ban = true;
			}
			$nro=$nro+50;
			$i=$i+1;
		}
	}
	
	return $ban;
}

/*
function obtenerNroReserva(){
	if($_SESSION["numres"]=='0'){
		$res = array();
		$sql  = @getSql("queryNumResSiguiente");
		$res = queryDB($sql);
		$nro = '0';
		foreach ($res as &$fila) {
			$nro = $fila[0];
		}
		$_SESSION["numres"] = $nro;
		reservarNroReserva($nro);
	}	
}
*/
function obtenerNroReserva(){
	if($_SESSION["numres"]=='0'){
		$res = array();
		$sql  = @getSql("queryNumResSiguiente");
		$res = queryDB($sql);
		$nro = '0';
		foreach ($res as &$fila) {
			$nro = $fila[0];
		}
		$_SESSION["numres"] = $nro;
		reservarNroReserva($nro);
		if($nro == '0'){
			if(crearConsecutivos('RES', 100)){
				obtenerNroReserva();
			}
		}
	}	
}

function obtenerNroReservaX(){
	$output = new xajaxResponse();
	obtenerNroReserva();
	$output->script("sessionNumRes = '".$_SESSION["numres"]."';");
	return $output;	
}

function iniIngresarReserva(){
	$output = new xajaxResponse();
	/*
	obtenerNroReserva();
	
	//Manejo de reintentos
	if($_SESSION["numres"] == 0){
		sleep(1);
		obtenerNroReserva();
		if($_SESSION["numres"] == 0){
			sleep(1);
			obtenerNroReserva();
			if($_SESSION["numres"] == 0){
				sleep(1);
				obtenerNroReserva();
			}
		}
	}
	*/
	$output->script("document.getElementById('labelNumRes').innerHTML = '&nbsp;&nbsp;Reserva No. __ ';");
	
	$output->script("desactivarObj('btnIngresarReserva');
						activarObj('btnGuardarReserva');
						desactivarObj('btnConsultarReserva');
						desactivarObj('btnActualizarReserva');
						desactivarObj('btnEliminarReserva');
						activarObj('btnCancelarReserva');
						mostrarObj('filaGeneral');
						pasarFoco('codAge');
					");
	
	return $output;	
}

function liberarConsecReservAntiguos(){
	$timestamp = time();
	$gmt = '-53';
	$gmt = $gmt*60*60;
	$timestamp = $timestamp + $gmt;
	$pasado =  gmdate("Y\-m\-d",$timestamp);
	$pasado = getFechaDB($pasado);
	
	$sql  = @getSql("updateLibConsecReservadosAnt", $pasado);
	$r = modifyDB($sql);

}

function liberarNroReserva(){
	if($_SESSION["numres"] != '0'){
		$sql  = @getSql("updateLibNumResReservado",$_SESSION["numres"]);
		$r = modifyDB($sql);
		$_SESSION["numres"] = '0';
	}
}

function liberarNroReservaX(){
	$output = new xajaxResponse();
	liberarNroReserva();
	return $output;	
}	

function confirmarNroReserva($nroRes){
	$sql  = @getSql("updateConfirNumResReservado",$nroRes);
	$r = modifyDB($sql);	
	$_SESSION["numres"] = '0';
}

function cancelarReserva($nroRes){
	$sql  = @getSql("deleteServiciosReserva",$nroRes);
	$r = modifyDB($sql);
	
	$sql  = @getSql("deleteReserva",$nroRes);	
	$r = modifyDB($sql);			
}

function liberarNroVoucher(){
	if($_SESSION["numvou"] != '0'){
		$sql  = @getSql("updateLibNumVouReservado",$_SESSION["numvou"],$_SESSION["oficina"]);
		$r = modifyDB($sql);
		$_SESSION["numvou"] = '0';
	}
}

function liberarNroVoucherX(){
	$output = new xajaxResponse();
	liberarNroVoucher();
	return $output;	
}	

function reservarNroVoucher($nroRes){
	$hoy = getFechaHoy();
	$hoy = getFechaDB($hoy);
	$sql  = @getSql("updateNumVouReservado",$nroRes,$hoy,$_SESSION["oficina"]);
	$r = modifyDB($sql);	
}

function confirmarNroVoucher($nroRes){
	$sql  = @getSql("updateConfirNumVouReservado",$nroRes,$_SESSION["oficina"]);
	$r = modifyDB($sql);	
	$_SESSION["numvou"] = '0';
}

function reservarNroReserva($nroRes){
	$hoy = getFechaHoy();
	$hoy = getFechaDB($hoy);
	$sql  = @getSql("updateNumResReservado",$nroRes, $hoy);
	$r = modifyDB($sql);	
}

function obtenerNroVoucher(){
	if($_SESSION["numvou"]=='0'){
		$res = array();
		$sql  = @getSql("queryNumVouSiguiente", $_SESSION["oficina"]);
		$res = queryDB($sql);
		$nro = '0';
		foreach ($res as &$fila) {
			$nro = $fila[0];
		}
		$_SESSION["numvou"] = $nro;
		reservarNroVoucher($nro);
		if($nro == '0'){
			if(crearConsecutivos('VOU '.$_SESSION["oficina"], 100)){
				obtenerNroVoucher();
			}
		}
	}	
}

function obtenerNroVoucherX(){
	$output = new xajaxResponse();
	obtenerNroVoucher();
	$output->script("sessionNumVou = '".$_SESSION["numvou"]."';");
	return $output;	
}

function confirmarActualizacionReserva($nroResNeg){
	$nroResPos = $nroResNeg*(-1);	
	
	$r = cancelarReserva($nroResPos);
	
	$r = respaldarReservaDB($nroResNeg);
		
	$sql  = @getSql("updateConfirServiciosReserva",$nroResPos,$nroResNeg);
	$r = modifyDB($sql);
	
	$sql  = @getSql("deleteReserva",$nroResNeg);	
	$r = modifyDB($sql);		
}

function registrarReserva($pReservas,$pServicios,$pCodCli,$cantRes,$numResActualizar='0',$numResAnular='0',$resResAnular='0'){
	global $reservas, $serviciosBase;
	$output = new xajaxResponse();
	$codUsu = $_SESSION["user"];
	getReservas($pReservas,$pServicios);
	
	if($numResActualizar =='0'){
		obtenerNroReserva();
		$numRes = $_SESSION["numres"];
		$output->assign("labelNumRes","innerHTML", "&nbsp;&nbsp;Reserva No. $numRes&nbsp;");
	}else{
		// Se va a actualizar una reserva
		settype($numResActualizar,'integer');
		$num = $numResActualizar*(-1);
		$numRes = ""+$num;
	}
	
	$serviciosBase = getArrayServicios();
	$stop = false;
	
	for($i=1;$i<=$cantRes;$i++){
		$nompax = getNomPaxRes($i);
		$docupax = getDocuPaxRes($i);

		$telpax = getTelPaxRes($i);
		$nac = getNacRes($i);
		$numpax = getNumPaxRes($i);
		
		$fecllega = getFecLlegaRes($i);
		
		$fecsale = getFecSaleRes($i);		
		
		$hotel = getHotelRes($i);
		$vlollega = getVloLlegaRes($i);
		$vlosale = getVloSaleRes($i);
    $horallega = getHoraLlegaRes($i);
		$horasale = getHoraSaleRes($i);
		$paquete = getPaquete($i);
		$asesorAge = getAsesorAge($i);
    
		$obs = getObservacionRes($i);
		$borr = getBorradaRes($i);
		$vou = getVoucher($i);
		if ($borr == 'SI'){
			$borr = "'SI'";
		}
		
    //$output->script("alert('{$vlollega} {$vlosale} - {$horallega} {$horasale} - {$paquete}');");
    
		if($vlollega != ''){
			$res = array();
			$sql  = @getSql("queryVuelo", "IN", $vlollega);
			$res = queryDB($sql);
			$existeVloLlega = '';
			foreach ($res as &$fila) {
				$existeVloLlega = 'SI';
			}
			
			if ($existeVloLlega == ''){
        // El vuelo de llegada No existe previamente, se crea en esstos momentos.
        $sql  = @getSql("insertVuelo", 'IN' , $vlollega, $horallega);
        $r = modifyDB($sql);	
			}else{
        // Actualizar hora de vuelo
        $sql  = @getSql("updateVuelo", 'IN' , $vlollega, $horallega);
        $r = modifyDB($sql);	
      }
		}
	
		
		if($vlosale != ''){
			$res = array();
			$sql  = @getSql("queryVuelo", "OUT", $vlosale);
			$res = queryDB($sql);
			$existeVloSale = '';
			foreach ($res as &$fila) {
				$existeVloSale = 'SI';
			}
			
			if ($existeVloSale == ''){
				// El vuelo de SALIDA No existe previamente, se crea en esstos momentos.
        $sql  = @getSql("insertVuelo", 'OUT' , $vlosale, $horasale);
        $r = modifyDB($sql);	       
			}else{
        // Actualizar hora de vuelo
        $sql  = @getSql("updateVuelo", 'OUT' , $vlosale, $horasale);
        $r = modifyDB($sql);	
      }
		}
    
		$r = registrarResRes($_SESSION["oficina"], $numRes, $i, $docupax, $nompax, $nac, $numpax, 
                         $fecllega, $fecsale, $pCodCli, $hotel, $vlollega, $vlosale, $codUsu, 
                         $obs, $borr, $vou, $telpax, $numResActualizar, $horallega, $horasale, 
                         $paquete, $asesorAge);
		
		if ($r <= 0){
			$msg = getMsgCaractEsp(getErrorDB(),'si');
			$msg = substr(str_replace("'","",$msg), 0,1000);
			registrarLogDB("REG", "RES", 0, "$msg");
			$output->script("mostrarMsg('errorAgregarReserva', '$numRes ($i).');");
			$stop = true;
			break;	
		}
		
		
		foreach ($serviciosBase as $serv){
			$valSer = getServicioRes($i,$serv['it']);
			$r2 = 0;			
			if ($valSer == 'true'){				
				$r2 = registrarServRes($numRes,$i,$serv['cod']);	
				if ($r2 <= 0){
					$msg = getMsgCaractEsp(getErrorDB(),'si');
					$output->script("mostrarMsg('errorAgregarSerReserva', '$numRes ($i)(".$serv['cod'].").$msg');");	
					$stop = true;
					break;	
				}					
			}			
		}
			
	}
	
  //$stop = true;

	if($stop == true){
		cancelarReserva($numRes);
		if($numResActualizar =='0')
			$output->script("mostrarMsg('errorReservaNoGuardada');");
		else
			$output->script("mostrarMsg('errorReservaNoActualizada');");								
	}else{
		if($numResActualizar =='0'){
			confirmarNroReserva($numRes);	
			$output->script("reservaModificar = ".$numRes.";");
			$_SESSION["numres"] = '0';
			$output->script("sessionNumRes = '0';");
		}else{
			// Se actualizo una reserva
			confirmarActualizacionReserva($numRes);
		}		
		
		$output->script("desactivarObj('btnIngresarReserva');");
		$output->script("desactivarObj('btnGuardarReserva');");
		$output->script("activarObj('btnConsultarReserva');");
		$output->script("activarObj('btnActualizarReserva');");
		$output->script("activarObj('btnEliminarReserva');");
		$output->script("activarObj('btnCancelarReserva');");
			
		if($numResActualizar =='0'){
			$output->script("mostrarMsg('infoRegistroReserva', '{$numRes} en la oficina {$_SESSION['oficinaname']}');");
			registrarLogDB('REG', 'RES', $numRes, "Registro de Reserva # $numRes");		
		}
		else{
			if($numResAnular =='0'){
				// Se anulo un resres
				if($resResAnular != '0'){
					$output->script("xajax_desactivarResRes($numResActualizar, $resResAnular);");
          $output->script("mostrarMsg('infoAnularReserva', '".$numRes*(-1)."');");
				}else{
          $output->script("mostrarMsg('infoActualizarReserva', '".$numRes*(-1)."');");
        }
				registrarLogDB('ACT', 'RES', $numRes*(-1), "Actualizacion de Reserva # ".$numRes*(-1));
				$output->script("datosReservasInicial = '$pReservas';");
				$output->script("datosServReservaInicial = '$pServicios';");
			}else{ //Se esta anulando toda la reserva
				$sql  = @getSql("updateBorradaResDes", $numResAnular, $codUsu);	
				$r = modifyDB($sql);
				if ($r <= 0){
					$msg = getMsgCaractEsp(getErrorDB(),'si');
					$output->script("mostrarMsg('errorReservaNoEliminado','$msg');");	
				}else{
					$sql  = @getSql("updateNumResAnulado", $numResAnular);
					$r2 = modifyDB($sql);
					$output->script("mostrarMsg('infoReservaEliminado');");
					registrarLogDB('ANU', 'RES', $numResAnular, "Anulacion de Reserva # $numResAnular");
				}
			}
		}	
	}	
	
	return $output;
}


function verificarReservasExistentes($pReservas,$pServicios,$pCodCli,$cantRes){
	global $reservas, $serviciosBase;
	$output = new xajaxResponse();
	
	$existe = false;
	getReservas($pReservas,$pServicios);
	
	$serviciosBase = getArrayServicios();
	
  $stop = false;
	for($i=1;$i<=$cantRes;$i++){
		$nompax = getNomPaxRes($i);
		$nac = getNacRes($i);
		$numpax = getNumPaxRes($i);		
		$fecllega = getFecLlegaRes($i);		
		$fecsale = getFecSaleRes($i);			
		$hotel = getHotelRes($i);
		$vou = getVoucher($i);
		$paquete = getPaquete($i);
    $asesorAge = getAsesorAge($i);
    
    // Validar datos obligatorios
    if(
      ($nompax == '')||
      ($nac == '')||
      ($numpax == '')||
      ($fecllega == '')||
      ($fecsale == '')||
      ($pCodCli == '')||
      ($hotel == '')||
      ($paquete == '')
    ){
      //$output->script("alert('Error registrando reserva.\nFaltan datos obligatorios.');");
      //return $output;
      $stop = true;
      break;
    }
		
    $fecllega = getFechaDB($fecllega);
		$fecsale = getFechaDB($fecsale);
    
		$nom = explode(" ",$nompax);
		$nomEnv[0]= '%';
		$nomEnv[1]= '%';
		$nomEnv[2]= '%';
		$nomEnv[3]= '%';
		$nomEnv[4]= '%';
		for($j=0;$j<=count($nom)-1;$j++){
			$nomEnv[$j]= '%'.$nom[$j].' %';
		}
		
		$sql  = @getSql("queryReservaExiste", $fecllega, $fecsale, $nomEnv[0], $nomEnv[1], $vou);
		
		//registrarSesionTxt(10,'usuario',$sql);

		$res = queryDB($sql);
		$texto = '';
		foreach ($res as &$fila) {
			$texto = $texto . '\n' . 'Reserva: '.$fila[0].'-'.$fila[1].', Pasajero: '.$fila[2].', Voucher: '.$fila[4].', Fecha IN: '.$fila[5].', Fecha OUT: '.$fila[6];
		}		
		
		//$texto = '';
		if($texto != ''){
			$output->script("alert('*** Precaucion. ***  Las siguientes reservas ya estan registradas a nombre del pasajero ".$nompax." :".$texto."');");
			$existe = true;
		}
		
	}
	
	if($stop == true){
    $output->script("alert('Error registrando reserva. Faltan datos obligatorios.');");
	}else if($existe == true){
		$output->script("var answer = confirm('Desea continuar ingresando la nueva reserva de todas formas ?');
						if (answer == true){
							xajax_registrarReserva(res_datosReservas,res_datosServReserva,res_codAge,res_cantRes);
						}
						else{
							mostrarMsg('errorReservaNoGuardada');
						}");
	}else{
    $output->script("xajax_registrarReserva(res_datosReservas,res_datosServReserva,res_codAge,res_cantRes);");
  }
	
	return $output;
}

function eliminarReserva($pNroRes){
	$output = new xajaxResponse();
	
	$sql  = @getSql("deleteServiciosReserva",$pNroRes);
	$r = modifyDB($sql);
	
	$sql  = @getSql("deleteReserva",$pNroRes);
	$r = modifyDB($sql);
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorReservaNoEliminada', '$msg');");				
	}else{
		$output->script("mostrarMsg('infoReservaEliminada', '$pNroRes');");
		$output->script("iniCancelarReserva();");	
	}
	
	return $output;	
}

function getMsgCaractEsp($texto, $js = 'no'){
	if ($js == 'no'){
		$texto = str_replace("a'","&aacute;",$texto);
		$texto = str_replace("e'","&eacute;",$texto);
		$texto = str_replace("i'","&iacute;",$texto);
		$texto = str_replace("o'","&oacute;",$texto);
		$texto = str_replace("u'","&uacute;",$texto);
		
		$texto = str_replace("A'","&Aacute;",$texto);
		$texto = str_replace("E'","&Eacute;",$texto);
		$texto = str_replace("I'","&Iacute;",$texto);
		$texto = str_replace("O'","&Oacute;",$texto);
		$texto = str_replace("U'","&Uacute;",$texto);		
		
		$texto = str_replace("n'","&ntilde;",$texto);
		$texto = str_replace("N'","&Ntilde;",$texto);
		/*
		$texto = str_replace("á","&aacute;",$texto);
		$texto = str_replace("é","&eacute;",$texto);
		$texto = str_replace("í","&iacute;",$texto);
		$texto = str_replace("ó","&oacute;",$texto);
		$texto = str_replace("ú","&uacute;",$texto);
		
		$texto = str_replace("Á","&Aacute;",$texto);
		$texto = str_replace("É","&Eacute;",$texto);
		$texto = str_replace("Í","&Iacute;",$texto);
		$texto = str_replace("Ó","&Oacute;",$texto);
		$texto = str_replace("Ú","&Uacute;",$texto);		
		
		$texto = str_replace("ñ","&ntilde;",$texto);
		$texto = str_replace("Ñ","&Ntilde;",$texto);
		*/
	}else{			
	
		$texto = str_replace("a'","'+String.fromCharCode(".ord('á').")+'",$texto);
		$texto = str_replace("e'","'+String.fromCharCode(".ord('é').")+'",$texto);
		$texto = str_replace("i'","'+String.fromCharCode(".ord('í').")+'",$texto);
		$texto = str_replace("o'","'+String.fromCharCode(".ord('ó').")+'",$texto);
		$texto = str_replace("u'","'+String.fromCharCode(".ord('ú').")+'",$texto);
		
		$texto = str_replace("A'","'+String.fromCharCode(".ord('Á').")+'",$texto);
		$texto = str_replace("E'","'+String.fromCharCode(".ord('É').")+'",$texto);
		$texto = str_replace("I'","'+String.fromCharCode(".ord('Í').")+'",$texto);
		$texto = str_replace("O'","'+String.fromCharCode(".ord('Ó').")+'",$texto);
		$texto = str_replace("U'","'+String.fromCharCode(".ord('Ú').")+'",$texto);		
		
		$texto = str_replace("n'","'+String.fromCharCode(".ord('ñ').")+'",$texto);
		$texto = str_replace("N'","'+String.fromCharCode(".ord('Ñ').")+'",$texto);	
		
	}
	
	$texto = str_replace("á","a",$texto);
		$texto = str_replace("é","e",$texto);
		$texto = str_replace("í","i",$texto);
		$texto = str_replace("ó","o",$texto);
		$texto = str_replace("ú","u",$texto);
		
		$texto = str_replace("Á","A",$texto);
		$texto = str_replace("É","E",$texto);
		$texto = str_replace("Í","I",$texto);
		$texto = str_replace("Ó","O",$texto);
		$texto = str_replace("Ú","U",$texto);		
		
		$texto = str_replace("ñ","n",$texto);
		$texto = str_replace("Ñ","N",$texto);
		$texto = str_replace("\"","",$texto);
		
	return str_replace("'","",$texto);
}

function getArrayReservaDB($nroRes){
	$res = array();
	
	$clienteUsu = getUsuarioRolCliente($_SESSION["user"]);
	if($clienteUsu == ''){
		$sql  = @getSql("queryReserva",$nroRes, $_SESSION["oficina"]);
	}else{
		$sql  = @getSql("queryReservaCli",$nroRes,$clienteUsu);
	}
	$res = queryDB($sql);
	
	return $res;
}

function getArrayServiciosPlanDB($nroRes,$resRes){
	$res = array();
	$sql  = @getSql("queryServicioReserva",$nroRes,$resRes);
	$res = queryDB($sql);
	return $res;
}

function llenarTablaReservas($nroRes) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();	
	$res = array();
	$res = getArrayReservaDB($nroRes);
	
	$output->assign("res0","style.display", "");		
		
	$output->script("limpiarServiciosReservas();");
	
	$i = 0;
	$nroItems = 0;
	$nroBorradas = 0;
	$codUsr = '';
	foreach ($res as &$fila) {
		$i = $fila[0];
		$nroItems = $nroItems+1;
		$output->assign("nomPax$fila[0]","value", "$fila[1]");
		$output->assign("docuPax$fila[0]","value", "$fila[16]");
		$output->assign("telPax$fila[0]","value", "$fila[15]");
		$output->assign("nac$fila[0]","value", "$fila[2]");
		$output->assign("numPax$fila[0]","value", "$fila[3]");
		$fecLle = getFechaDBToInterfaz($fila[4]); 
		$output->assign("fecLlega$fila[0]","value", "$fecLle");
		$fecSal = getFechaDBToInterfaz($fila[5]); 
		$output->assign("fecSale$fila[0]","value", "$fecSal");
		$output->assign("codHot$fila[0]","value", "$fila[6]");
		
		$output->assign("nomHot$fila[0]","value", "$fila[6]");
		
		$output->assign("vloLlega$fila[0]","value", "$fila[7]");				
		$output->assign("vloSale$fila[0]","value", "$fila[8]");
    
    $output->assign("horaLlega$fila[0]","value", "$fila[17]");				
		$output->assign("horaSale$fila[0]","value", "$fila[18]");
    $output->assign("codPaq$fila[0]","value", "$fila[19]");
		$output->assign("nomPaq$fila[0]","value", "$fila[19]");
    
		$output->assign("asesorAge$fila[0]","value", "$fila[20]");
    
		$it = $fila[0];
		
		$output->script("setObservacionRes($fila[0],'$fila[9]');");
		
		if(trim($fila[9]) == ''){
			$output->assign("imgObs$fila[0]","src", "images/edit.png");		
		}else{
			$output->assign("imgObs$fila[0]","src", "images/view.gif");			
		}
		
		$output->assign("voucher$fila[0]","value", "$fila[14]");
		
		
		$codCli = $fila[10];

		$codUsr = $fila[11];
		
		$res2 = getArrayServiciosPlanDB($nroRes, $fila[0]);
		foreach ($res2 as &$fila2) {
			// $nroRes = nroRes
			// $fila2[0] = resRes
			// $fila2[1] = codSer		
			$output->script("setServicioCodRes($fila2[0],'$fila2[1]','true');");
		}
		
		if($fila[13] == 'SI'){
			$nroBorradas = $nroBorradas+1;
			$output->script("setBorradaRes($fila[0],'$fila[13]');");
			$output->assign("res$fila[0]","style.display", "");
			
			//$output->assign("nomPax$fila[0]","style.display", "none");
			$output->assign("nomPax$fila[0]","style.display", "");
			$output->assign("nomPax$fila[0]","disabled", "disabled");

			$output->assign("docuPax$fila[0]","style.display", "");
			$output->assign("docuPax$fila[0]","disabled", "disabled");

			$output->assign("telPax$fila[0]","style.display", "");
			$output->assign("telPax$fila[0]","disabled", "disabled");
			
			$output->assign("nac$fila[0]","style.display", "none");
			$output->assign("numPax$fila[0]","style.display", "none");
			$output->assign("voucher$fila[0]","style.display", "none");
			$output->assign("imgServ$fila[0]","style.display", "none");
			$output->assign("fecLlega$fila[0]","style.display", "none");
			$output->assign("fecSale$fila[0]","style.display", "none");
			$output->assign("imgFecLlega$fila[0]","style.display", "none");
			$output->assign("imgFecSale$fila[0]","style.display", "none");		
			$output->assign("codHot$fila[0]","style.display", "none");
			$output->assign("nomHot$fila[0]","style.display", "none");
			$output->assign("vloLlega$fila[0]","style.display", "none");
			$output->assign("vloSale$fila[0]","style.display", "none");
      $output->assign("horaLlega$fila[0]","style.display", "none");
			$output->assign("horaSale$fila[0]","style.display", "none");
			$output->assign("codPaq$fila[0]","style.display", "none");
      $output->assign("nomPaq$fila[0]","style.display", "none");
      $output->assign("asesorAge$fila[0]","style.display", "none");
      
			$output->assign("imgVloLlega$fila[0]","style.display", "none");
			$output->assign("imgVloSale$fila[0]","style.display", "none");
			
			//$output->assign("imgObs$fila[0]","style.display", "none");
			$output->assign("imgObs$fila[0]","style.display", "");	
			
			$output->assign("imgAct$fila[0]","style.display", "");	
			$output->assign("imgEli$fila[0]","style.display", "none");			
			
		}else{
			$output->script("setBorradaRes($fila[0],'NULL');");
			$output->assign("res$fila[0]","style.display", "");
			
			$output->assign("nomPax$fila[0]","style.display", "");
			$output->assign("nomPax$fila[0]","disabled", "");
			
			$output->assign("docuPax$fila[0]","style.display", "");
			$output->assign("docuPax$fila[0]","disabled", "");

			$output->assign("telPax$fila[0]","style.display", "");
			$output->assign("telPax$fila[0]","disabled", "");
			
			$output->assign("nac$fila[0]","style.display", "");
			$output->assign("numPax$fila[0]","style.display", "");
			$output->assign("voucher$fila[0]","style.display", "");
			$output->assign("imgServ$fila[0]","style.display", "");
			$output->assign("fecLlega$fila[0]","style.display", "");
			$output->assign("fecSale$fila[0]","style.display", "");
			$output->assign("imgFecLlega$fila[0]","style.display", "");
			$output->assign("imgFecSale$fila[0]","style.display", "");		
			$output->assign("codHot$fila[0]","style.display", "");
			$output->assign("nomHot$fila[0]","style.display", "");
			$output->assign("vloLlega$fila[0]","style.display", "");
			$output->assign("vloSale$fila[0]","style.display", "");
			$output->assign("imgVloLlega$fila[0]","style.display", "");
			$output->assign("imgVloSale$fila[0]","style.display", "");	
      $output->assign("horaLlega$fila[0]","style.display", "");
			$output->assign("horaSale$fila[0]","style.display", "");
			$output->assign("codPaq$fila[0]","style.display", "");
      $output->assign("nomPaq$fila[0]","style.display", "");
      $output->assign("asesorAge$fila[0]","style.display", "");
      
			$output->assign("imgObs$fila[0]","style.display", "");	
			$output->assign("imgAct$fila[0]","style.display", "none");	
			$output->assign("imgEli$fila[0]","style.display", "");	
		}
		
	}	
	
	if($i > 0){
		$output->assign("codAge","value", "$codCli");
		$output->assign("nomAge","value", "$codCli");
		$output->assign("cantRes","value", "$i");
		$output->assign("labelNumRes","innerHTML", "&nbsp;&nbsp;Reserva No. $nroRes&nbsp;");
		if($nroBorradas == $nroItems)
			$output->script("mostrarMsg('infoReservaAnulada', '$codUsr');");
		else{ 
			if($nroBorradas > 0)
				$output->script("mostrarMsg('infoItemReservaAnulada');");
		}

		/***********/
		$output->script("actualizarArrayReserva();\n
						datosReservasInicial = '';\n
						for(i=1;i<=$i;i++){\n
							datosReservasInicial = datosReservasInicial + getNomPaxRes(i) + '/,/' + getNacRes(i) + '/,/' + getNumPaxRes(i) + '/,/' + getFecLlegaRes(i) + '/,/' + getFecSaleRes(i) + '/,/' + getHotelRes(i) + '/,/' + getVloLlegaRes(i) + '/,/' + getVloSaleRes(i) + '/,/' + getObservacionRes(i) + '/,/' + getBorradaRes(i)  + '/,/' + getVoucher(i)  + '/,/' + getTelPaxRes(i)  + '/,/' + getDocuPaxRes(i) + '/,//;/';\n
						}");
		$output->script("actualizarDatosServReservaInicial($i);");
		//$output->script("alert(datosServReservaInicial);");
		/***********/
				
		$output->script("mostrarObj('filaGeneral'); resultadoBox = '1'; reservaModificar = $nroRes;");
	}else{
		$output->script("ocultarObj('filaGeneral'); resultadoBox = '0'; reservaModificar = 0;");
		$output->assign("labelNumRes","innerHTML", "&nbsp;Reserva NO encontrada.&nbsp;");	
		$output->assign("res0","style.display", "none");		
	}
	
	$output->script("$.fn.colorbox.close();");
	
	for($j=$i+1;$j<=50;$j=$j+1){
		$output->assign("res$j","style.display", "none");
		
	}	

	return $output; 
 }  
 
 
 function llenarTablaReservasNom($pNomPax) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();	
	$res = array();
	
	$clienteUsu = getUsuarioRolCliente($_SESSION["user"]);
	if($clienteUsu == ''){
		$sql  = @getSql("queryReservaXNomPax",$pNomPax, $_SESSION["oficina"]);
	}else{
		$sql  = @getSql("queryReservaXNomPaxCli",$pNomPax,$clienteUsu);
	}
	$res = queryDB($sql);
	
	$output->assign("resNom0","style.display", "");		
		
	//$output->script("limpiarServiciosReservas();");
	
	$i = 0;
	foreach ($res as &$fila) {
		$i = $i+1;
		$output->assign("resNom$i","style.display", "");
		$output->assign("numResNom$i","value", "$fila[0]");
		$output->assign("resResNom$i","value", "$fila[1]");
		$output->assign("nomPaxNom$i","value", "$fila[2]");
		
		$output->assign("docuPaxNom$i","value", "$fila[7]");

		$output->assign("nacNom$i","value", "$fila[3]");
		$fecLle = getFechaDBToInterfaz($fila[4]); 
		$output->assign("fecLlegaNom$i","value", "$fecLle");
		
    $output->assign("clienteNom$i","value", "$fila[5]");
    
		if($fila[6] == 'SI'){
			$output->assign("imgVer$i","style.display", "none");						
		}else{
			$output->assign("imgVer$i","style.display", "");	
		}	
		
	}	
	
	if($i > 0){
		$output->script("document.getElementById('labelResulConsultaReservaNom').innerHTML=getValueXML('formConsultaReserva','labelResulConsultaReservaNomTrue');");
	}else{
		$output->assign("resNom0","style.display", "none");
		$output->script("document.getElementById('labelResulConsultaReservaNom').innerHTML=getValueXML('formConsultaReserva','labelResulConsultaReservaNomFalse');");
	}
	
	for($j=$i+1;$j<=20;$j=$j+1){
		$output->assign("resNom$j","style.display", "none");		
	}	

	return $output; 
 } 
 
 
function respaldarReservaDB($pNumRes){
	$sql  = @getSql("insertRespaldoReserva",$pNumRes);
	$r = modifyDB($sql);
	
	return $r;
} 

function registrarAgencia($pTipoCli, $pCodCli , $pNomCli , $pDirCli , $pCiuCli , $pTe1Cli , $pTe2Cli , $pCelCli , $pConCli, $pNitAge){
	$output = new xajaxResponse();
									
	$sql  = @getSql("insertCliente",$pCodCli, $pNomCli, $pDirCli, $pCiuCli, 
									$pTe1Cli, $pTe2Cli, $pCelCli, $pConCli, $pTipoCli, $pNitAge);
	$r = modifyDB($sql);	
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorClienteNoGuardado', '$pCodCli - $pNomCli. $msg');");	
	}else{
		$output->script("mostrarMsg('infoClienteGuardado', '$pCodCli - $pNomCli');");
		$output->script(" 	document.formTablaAgencias.btnIngresarTabla.disabled=''; 
							document.formTablaAgencias.btnGuardarTabla.disabled='disabled';
							document.formTablaAgencias.btnConsultarAgencia.disabled='';
							document.formTablaAgencias.btnActualizarTabla.disabled=''; 
							desactivarObj('codAge'); ");	
    resetQueriesClientes();
	}
	
	return $output;
}

function actualizarAgencia($pTipoCli, $pCodCli , $pNomCli , $pDirCli , $pCiuCli , $pTe1Cli , $pTe2Cli , $pCelCli , $pConCli, $pNitAge){
	$output = new xajaxResponse();
	
	$sql  = @getSql("updateCliente" ,$pCodCli ,$pNomCli ,$pDirCli ,$pCiuCli ,$pTe1Cli ,$pTe2Cli ,$pCelCli ,$pConCli, $pTipoCli, $pNitAge);
	
	$r = modifyDB($sql);	
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorClienteNoActualizado','$pCodCli - $pNomCli. $msg');");	
	}else{
		$output->script("mostrarMsg('infoClienteActualizado','$pCodCli - $pNomCli');");
		$output->script(" 	document.formTablaAgencias.btnIngresarTabla.disabled=''; 
							document.formTablaAgencias.btnGuardarTabla.disabled='disabled';
							document.formTablaAgencias.btnConsultarAgencia.disabled='';
							document.formTablaAgencias.btnActualizarTabla.disabled=''; 
							document.formTablaAgencias.btnRetirarTabla.disabled=''; 
							desactivarObj('codAge');  ");
    resetQueriesClientes();
	}
	
	return $output;
}

function retirarAgencia($pCodCli){
	$output = new xajaxResponse();
	
	//$sql = "DELETE FROM AGENCIAS WHERE CODAGE = '$pCodCli'";
	
	$sql  = @getSql("deleteCliente",$pCodCli);
	
	$r = modifyDB($sql);	
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorClienteNoEliminado', '$pCodCli. $msg');");	
	}else{
		$output->script("mostrarMsg('infoClienteEliminado', '$pCodCli');");
		$output->script(" 	document.formTablaAgencias.btnIngresarTabla.disabled=''; 
							document.formTablaAgencias.btnGuardarTabla.disabled='disabled';
							document.formTablaAgencias.btnConsultarAgencia.disabled='';
							document.formTablaAgencias.btnActualizarTabla.disabled='disabled'; 
							document.formTablaAgencias.btnRetirarTabla.disabled='disabled'; 
							desactivarTablaAgencias(); ");
    resetQueriesClientes();
	}
	
	return $output;
}

function getNomCliente($pCodCli){
	$sql  = @getSql("queryCliente",$pCodCli);
	$res = queryDB($sql);
	$pNomCli = '';
	foreach ($res as &$fila) {
		$pNomCli = $fila[1];
	}
	return $pNomCli;
}
function llenarTablaAgencias($pCodCli) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();		
	
	$res = array();
	$sql  = @getSql("queryCliente",$pCodCli);
	$res = queryDB($sql);
	
	$output->script("activarTablaAgencias();");
	
	$i = 0;
	foreach ($res as &$fila) {			
		$i = 1;
		$output->assign("codAge","value", "$fila[0]");
		$output->assign("nomAge","value", "$fila[1]");
		$output->assign("nitAge","value", "$fila[9]");
		$output->assign("dirAge","value", "$fila[2]");
		$output->assign("ciuAge","value", "$fila[3]");
		$output->assign("tel1Age","value", "$fila[4]");
		$output->assign("tel2Age","value", "$fila[5]");
		$output->assign("celAge","value", "$fila[6]");
		$output->assign("contacAge","value", "$fila[7]");
		$output->assign("selTipoAge","value", "$fila[8]");
	}
	
	if($i == 1){
		$output->script("resultadoBox = '1'; desactivarObj('codAge');");		
	}else{
		$output->script("resultadoBox = '0'; desactivarTablaAgencias();");	
	}
	
	$output->script("$.fn.colorbox.close();");
	
	return $output; 
} 

function getProveedoresSer($pqProveedores){
	global $proveedores;
	$proveedores = array();

	$filaProveedores = explode("/;/",$pqProveedores,-1);
	for($i=0;$i<=count($filaProveedores)-1;$i++){			
			$datoProveedor = explode("/,/",$filaProveedores[$i],-1);			
			for($j=0;$j<=count($datoProveedor)-1;$j++){
				$dato = explode(":",$datoProveedor[$j],-1);				
				$proveedores[$j+1][1] = $dato[0];				
				$proveedores[$j+1][2] = $dato[1];
				$proveedores[$j+1][3] = $dato[2];
			}
	}

}

function registrarProvSer($pCodSer, $pCodPro, $pCosSer){
	//$sql  = @getSql("xxx", $pCodSer);	
	$pCosSer = str_replace(".","",$pCosSer);
	$pCosSer = str_replace(",","",$pCosSer);
	$sql  = "INSERT INTO SERVICIOSXPROVEEDOR (CODSER, CODPRO, COSSER) values ('$pCodSer','$pCodPro','$pCosSer')";
	$r = modifyDB($sql);
	return $r;
}

function registrarServicio($pCodSer , $pNomSer , $pSelDefecto , $pOrdenSale , $pProveedores, $pPrecioXAd, $pPrecioXIn){
	$output = new xajaxResponse();
	$stop = false;
	
	if($pPrecioXAd == '')
		$pPrecioXAd = '0';
	if($pPrecioXIn == '')
		$pPrecioXIn = '0';

	if($pOrdenSale=='')
		$pOrdenSale = '99';	

	$pCodSer = strtoupper($pCodSer);
	
	$sql  = @getSql("insertServicio", $pCodSer, $pNomSer, $pSelDefecto, $pOrdenSale, $pPrecioXAd, $pPrecioXIn);	
	$r = modifyDB($sql);

	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');		
		$output->script("mostrarMsg('errorServicioNoGuardado','$pCodSer - $pNomSer. $msg');");	
	}else{
		getProveedoresSer($pProveedores);
		$proveedoresBase = getArrayProveedores();
		foreach ($proveedoresBase as $pro){
			$val = getProveedorSer($pro['it']);
			$valCosto = getProveedorCosSer($pro['it']);
			$r2 = 0;			
			if ($val == 'true'){				
				$r2 = registrarProvSer($pCodSer,$pro['cod'],$valCosto);	
				if ($r2 <= 0){
					$msg = getMsgCaractEsp(getErrorDB(),'si');
					$output->script("mostrarMsg('errorProServicioNoGuardado','$pNomSer (".$pro['cod'].").  $msg');");	
					$stop = true;
					break;	
				}					
			}			
		}

		if($stop == true){
			//cancelarReserva($numRes);
			$output->script("mostrarMsg('errorProServicioNoGuardado','$pCodSer - $pNomSer');");
		}else{
			$output->script("mostrarMsg('infoServicioGuardado','$pCodSer - $pNomSer');");
			$output->script(" 	document.formTablaServicios.btnIngresarTabla.disabled=''; 
								document.formTablaServicios.btnGuardarTabla.disabled='disabled';
								document.formTablaServicios.btnConsultarServicio.disabled='';
								document.formTablaServicios.btnActualizarTabla.disabled=''; 
								desactivarObj('codSer'); ");		
      		resetQueriesServicios();
		}
		
	
	}
	
	return $output;
}	

function actualizarServicio($pCodSer , $pNomSer , $pSelDefecto , $pOrdenSale, $pProveedores, $pPrecioXAd, $pPrecioXIn){
	$output = new xajaxResponse();
	
	if($pPrecioXAd == '')
		$pPrecioXAd = '0';
	if($pPrecioXIn == '')
		$pPrecioXIn = '0';

	if($pOrdenSale=='')
		$pOrdenSale = '99';
	
	/*$sql = "UPDATE SERVICIOS SET 
							NOMSER = '$pNomSer', 
							SELDEFECTO = '$pSelDefecto', 
							ORDENSALE = $pOrdenSale 
							WHERE CODSER = '$pCodSer'";*/
							
	$sql  = @getSql("updateServicio", $pCodSer , $pNomSer , $pSelDefecto , $pOrdenSale, $pPrecioXAd, $pPrecioXIn);								
	
	$r = modifyDB($sql);	
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorServicioNoActualizado','$pCodSer - $pNomSer. $msg');");	
	}else{
	
		getProveedoresSer($pProveedores);
		$proveedoresBase = getArrayProveedores();
		foreach ($proveedoresBase as $pro){
			$val = getProveedorSer($pro['it']);
			$valCosto = getProveedorCosSer($pro['it']);
			$r2 = 0;			
			if ($val == 'true'){				
				$r2 = registrarProvSer($pCodSer,$pro['cod'],$valCosto);				
			}else{
				$sql  = @getSql("deleteProveedorServicio", $pCodSer , $pro['cod']);									
				$r3 = modifyDB($sql);
			}
		}
		
		$output->script("mostrarMsg('infoServicioActualizado','$pCodSer - $pNomSer');");
		$output->script(" 	document.formTablaServicios.btnIngresarTabla.disabled=''; 
							document.formTablaServicios.btnGuardarTabla.disabled='disabled';
							document.formTablaServicios.btnConsultarServicio.disabled='';
							document.formTablaServicios.btnActualizarTabla.disabled=''; 
							document.formTablaServicios.btnRetirarTabla.disabled=''; 
							desactivarObj('codSer'); ");
    	resetQueriesServicios();
	}
	
	return $output;
}

function retirarServicio($pCodSer){
	$output = new xajaxResponse();
		
	$sql  = @getSql("deleteProveedoresServicio", $pCodSer);	
	$r = modifyDB($sql);
	
	//$sql = "DELETE FROM SERVICIOS WHERE CODSER = '$pCodSer'";
	$sql  = @getSql("deleteServicio", $pCodSer);
	
	$r = modifyDB($sql);	
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorServicioNoEliminado','$pCodSer. $msg');");	
	}else{
		$output->script("mostrarMsg('infoServicioEliminado','$pCodSer');");
		$output->script(" 	document.formTablaServicios.btnIngresarTabla.disabled=''; 
							document.formTablaServicios.btnGuardarTabla.disabled='disabled';
							document.formTablaServicios.btnConsultarServicio.disabled='';
							document.formTablaServicios.btnActualizarTabla.disabled='disabled'; 
							document.formTablaServicios.btnRetirarTabla.disabled='disabled'; 
							desactivarTablaServicios(); ");
    	resetQueriesServicios();
	}
	
	return $output;
}

function getArrayProveedoresSer($pCodSer){
	$res = array();
	$sql  = @getSql("queryProveedoresServicio",$pCodSer);
	$res = queryDB($sql);
	return $res;
}


function llenarTablaServicios($pCodSer) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();		
	
	$res = array();
	$sql  = @getSql("queryServicio",$pCodSer);
	$res = queryDB($sql);
	
	$output->script("activarTablaServicios();");
	
	$output->script("limpiarProveedoresServicio();");
	
	$i = 0;
	foreach ($res as &$fila) {			
		$i = 1;
		$output->assign("codSer","value", "$fila[0]");
		$output->assign("nomSer","value", "$fila[1]");
		$output->assign("selDefecto","value", "$fila[2]");
		
		$res2 = getArrayProveedoresSer($fila[0]);
		foreach ($res2 as &$fila2) {
			// $fila2[0] = codPro		
			$output->script("setProveedorCodSer($fila2[0],'true','$fila2[1]');");
		}		
		
		if($fila[3]=='99')
			$fila[3] = '';	
		$output->assign("ordenSale","value", "$fila[3]");
		$output->assign("precXPaxAd","value", "$fila[5]");
		$output->assign("precXPaxIn","value", "$fila[6]");
	}
	
	if($i == 1){
		$output->script("resultadoBox = '1'; desactivarObj('codSer');");		
	}else{
		$output->script("resultadoBox = '0'; desactivarTablaServicios();");	
	}
	
	$output->script("$.fn.colorbox.close();");
	
	return $output; 
} 

function registrarHotel($pCodHot , $pNomHot , $pDirHot , $pTel1Hot , $pTel2Hot, $pCelHot, $pConHot, $pTipoUbi, $pOficina){
	$output = new xajaxResponse();	
	
	//$sql="INSERT INTO HOTELES (CODHOT, NOMHOT, DIRHOT, TE1HOT, TE2HOT, CELHOT, CONHOT) VALUES ('$pCodHot', '$pNomHot', '$pDirHot', '$pTel1Hot', '$pTel2Hot' , '$pCelHot', '$pConHot')";
	
	$sql  = @getSql("insertUbicacion", $pCodHot, $pNomHot, $pDirHot, $pTel1Hot, $pTel2Hot , $pCelHot, $pConHot, $pTipoUbi, $pOficina);
	
	$r = modifyDB($sql);

	$descHotel = 'la ubicacion';
	if($pTipoUbi == 'HOT')
		$descHotel = 'el hotel';
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');		
		$output->script("mostrarMsg('errorHotelNoGuardado','$descHotel $pCodHot - $pNomHot. $msg');");	
	}else{
		$output->script("mostrarMsg('infoHotelGuardado','$descHotel $pCodHot - $pNomHot');");
		$output->script(" 	document.formTablaHoteles.btnIngresarTabla.disabled=''; 
							document.formTablaHoteles.btnGuardarTabla.disabled='disabled';
							document.formTablaHoteles.btnConsultarHotel.disabled='';
							document.formTablaHoteles.btnActualizarTabla.disabled=''; 
							desactivarObj('codHot'); ");	
    resetQueriesHoteles();
	}
		
	return $output;
}

function actualizarHotel($pCodHot , $pNomHot , $pDirHot , $pTel1Hot , $pTel2Hot, $pCelHot, $pConHot, $pTipoUbi, $pOficina){
	$output = new xajaxResponse();
							
	$sql  = @getSql("updateUbicacion", $pCodHot, $pNomHot, $pDirHot, $pTel1Hot, $pTel2Hot , $pCelHot, $pConHot, $pTipoUbi, $pOficina);
	
	$r = modifyDB($sql);

	$descHotel = 'la ubicacion';
	if($pTipoUbi == 'HOT')
		$descHotel = 'el hotel';
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorHotelNoActualizado','$descHotel $pCodHot - $pNomHot. $msg');");	
	}else{
		$output->script("mostrarMsg('infoHotelActualizado','$descHotel $pCodHot - $pNomHot');");
		$output->script(" 	document.formTablaHoteles.btnIngresarTabla.disabled=''; 
							document.formTablaHoteles.btnGuardarTabla.disabled='disabled';
							document.formTablaHoteles.btnConsultarHotel.disabled='';
							document.formTablaHoteles.btnActualizarTabla.disabled=''; 
							document.formTablaHoteles.btnRetirarTabla.disabled=''; 
							desactivarObj('codHot'); ");
    resetQueriesHoteles();
	}
	
	return $output;
}

function retirarHotel($pCodHot){
	$output = new xajaxResponse();
	
	//$sql = "DELETE FROM HOTELES WHERE CODHOT = '$pCodHot'";
	$sql  = @getSql("deleteUbicacion", $pCodHot);
	
	$r = modifyDB($sql);	
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorHotelNoEliminado','$pCodHot. $msg');");	
	}else{
		$output->script("mostrarMsg('infoHotelEliminado','$pCodHot');");
		$output->script(" 	document.formTablaHoteles.btnIngresarTabla.disabled=''; 
							document.formTablaHoteles.btnGuardarTabla.disabled='disabled';
							document.formTablaHoteles.btnConsultarHotel.disabled='';
							document.formTablaHoteles.btnActualizarTabla.disabled='disabled'; 
							document.formTablaHoteles.btnRetirarTabla.disabled='disabled'; 
							desactivarTablaHoteles(); ");
    resetQueriesHoteles();
	}
	
	return $output;
}


function llenarTablaHoteles($pCodHot) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();		
	
	$res = array();
	$sql  = @getSql("queryUbicacion",$pCodHot);
	$res = queryDB($sql);
	
	$output->script("activarTablaHoteles();");
	
	$i = 0;
	foreach ($res as &$fila) {			
		$i = 1;
		$output->assign("codHot","value", "$fila[0]");
		$output->assign("nomHot","value", "$fila[1]");
		$output->assign("dirHot","value", "$fila[2]");
		$output->assign("tel1Hot","value", "$fila[3]");
		$output->assign("tel2Hot","value", "$fila[4]");
		$output->assign("celHot","value", "$fila[5]");
		$output->assign("conHot","value", "$fila[6]");
		$output->assign("selTipoUbi","value", "$fila[7]");
		$output->assign("selOficina","value", "$fila[8]");
	}
	
	if($i == 1){
		$output->script("resultadoBox = '1'; desactivarObj('codHot');");		
	}else{
		$output->script("resultadoBox = '0'; desactivarTablaHoteles();");	
	}
	
	$output->script("$.fn.colorbox.close();");
	
	return $output; 
} 

function registrarUsuario($pCodUsr , $pClave , $pCodRol , $pNombre , $pApellidos, $pCliente = '<NULL>'){
	$output = new xajaxResponse();	
	$hoy = getFechaHoy();
	$hoy = getFechaDB($hoy);
	
	$codUsrDig = $_SESSION["user"];
	
	if($pCliente == '<NULL>')
		$pCliente = 'NULL';
	else
		$pCliente = "'".$pCliente."'";
	
	$sql  = @getSql("insertUsuario", $pCodUsr, $pClave, $pCodRol, $pNombre, $pApellidos, $hoy, $codUsrDig, $pCliente);
	
	$r = modifyDB($sql);	
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');		
		$output->script("mostrarMsg('errorUsuarioNoGuardado','$pCodUsr - $pNombre. $msg');");	
	}else{
		$output->script("mostrarMsg('infoUsuarioGuardado','$pCodUsr - $pNombre');");
		$output->script(" 	document.formTablaUsuarios.btnIngresarTabla.disabled=''; 
							document.formTablaUsuarios.btnGuardarTabla.disabled='disabled';
							document.formTablaUsuarios.btnConsultarUsuario.disabled='';
							document.formTablaUsuarios.btnActualizarTabla.disabled=''; 
							desactivarObj('codUsr'); ");	
    resetQueriesUsuarios();
	}
		
	return $output;
}

function actualizarUsuario($pCodUsr , $pClave , $pCodRol , $pNombre , $pApellidos, $pCliente = '<NULL>'){
	$output = new xajaxResponse();
	$codUsrDig = $_SESSION["user"];
	
	if($pCliente == '<NULL>')
		$pCliente = 'NULL';
	else
		$pCliente = "'".$pCliente."'";
							
	$sql  = @getSql("updateUsuario", $pCodUsr, $pClave, $pCodRol, $pNombre, $pApellidos , $codUsrDig, $pCliente);
	
	$r = modifyDB($sql);	
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorUsuarioNoActualizado','$pCodUsr - $pNombre. $msg');");	
	}else{
		$output->script("mostrarMsg('infoUsuarioActualizado','$pCodUsr - $pNombre');");
		$output->script(" 	document.formTablaUsuarios.btnIngresarTabla.disabled=''; 
							document.formTablaUsuarios.btnGuardarTabla.disabled='disabled';
							document.formTablaUsuarios.btnConsultarUsuario.disabled='';
							document.formTablaUsuarios.btnActualizarTabla.disabled=''; 
							document.formTablaUsuarios.btnRetirarTabla.disabled=''; 
							desactivarObj('codUsr'); ");
    resetQueriesUsuarios();
	}
	
	return $output;
}

function retirarUsuario($pCodUsr){
	$output = new xajaxResponse();
	
	//$sql = "DELETE FROM USUARIOS WHERE CODUSR = '$pCodUsr'";
	$sql  = @getSql("deleteUsuario", $pCodUsr);
	
	$r = modifyDB($sql);	
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorUsuarioNoEliminado','$pCodUsr. $msg');");	
	}else{
		$output->script("mostrarMsg('infoUsuarioEliminado','$pCodUsr');");
		$output->script(" 	document.formTablaUsuarios.btnIngresarTabla.disabled=''; 
							document.formTablaUsuarios.btnGuardarTabla.disabled='disabled';
							document.formTablaUsuarios.btnConsultarUsuario.disabled='';
							document.formTablaUsuarios.btnActualizarTabla.disabled='disabled'; 
							document.formTablaUsuarios.btnRetirarTabla.disabled='disabled'; 
							desactivarTablaUsuarios(); ");
    resetQueriesUsuarios();
	}
	
	return $output;
}

function llenarTablaUsuarios($pCodUsr) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();		
	
	$res = array();
	$sql  = @getSql("queryUsuario",$pCodUsr);
	$res = queryDB($sql);
	
	$output->script("activarTablaUsuarios();");
	
	$i = 0;
	foreach ($res as &$fila) {			
		$i = 1;
		$output->assign("codUsr","value", "$fila[0]");
		$output->assign("clave","value", "$fila[1]");
		$output->assign("codRol","value", "$fila[2]");
		$output->assign("nombre","value", "$fila[3]");
		$output->assign("apellidos","value", "$fila[4]");
		$output->assign("selCliente","value", "$fila[7]");
		$codRol = $fila[2];
	}
	
	if($i == 1){
		$output->script("resultadoBox = '1'; desactivarObj('codUsr');");	
		if($codRol == 'CLI')
			$output->script("activarObj('selCliente');");
	}else{
		$output->script("resultadoBox = '0'; desactivarTablaUsuarios();");	
	}
	
	$output->script("$.fn.colorbox.close();");
	
	return $output; 
} 

function registrarNacionalidad($pCodNac , $pNacional){
	$output = new xajaxResponse();	

	//$sql="INSERT INTO NACIONALIDADES (CODNAC, NACIONAL) VALUES ('$pCodNac', '$pNacional')";
	
	$sql  = @getSql("insertNacionalidad", $pCodNac , $pNacional);
	
	$r = modifyDB($sql);	
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');		
		$output->script("mostrarMsg('errorNacioNoGuardada','$pCodNac - $pNacional. $msg');");	
	}else{
		$output->script("mostrarMsg('infoNacioGuardada','$pCodNac - $pNacional');");
		$output->script(" 	document.formTablaNacionalidades.btnIngresarTabla.disabled=''; 
							document.formTablaNacionalidades.btnGuardarTabla.disabled='disabled';
							document.formTablaNacionalidades.btnConsultarNacionalidad.disabled='';
							document.formTablaNacionalidades.btnActualizarTabla.disabled=''; 
							desactivarObj('codNac'); ");
    resetQueriesNacionalidades();
	}
		
	return $output;
}

function actualizarNacionalidad($pCodNac , $pNacional){
	$output = new xajaxResponse();
	$codUsrDig = $_SESSION["user"];
	
	/*$sql = "UPDATE NACIONALIDADES SET 
							NACIONAL = '$pNacional' 
							WHERE CODNAC = '$pCodNac'";*/
							
	$sql  = @getSql("updateNacionalidad", $pCodNac , $pNacional);
	
	$r = modifyDB($sql);	
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorNacioNoActualizada','$pCodNac - $pNacional. $msg');");	
	}else{
		$output->script("mostrarMsg('infoNacioActualizada','$pCodNac - $pNacional');");
		$output->script(" 	document.formTablaNacionalidades.btnIngresarTabla.disabled=''; 
							document.formTablaNacionalidades.btnGuardarTabla.disabled='disabled';
							document.formTablaNacionalidades.btnConsultarNacionalidad.disabled='';
							document.formTablaNacionalidades.btnActualizarTabla.disabled=''; 
							document.formTablaNacionalidades.btnRetirarTabla.disabled=''; 
							desactivarObj('codNac'); ");
    resetQueriesNacionalidades();
	}
	
	return $output;
}

function retirarNacionalidad($pCodNac){
	$output = new xajaxResponse();
	
	//$sql = "DELETE FROM NACIONALIDADES WHERE CODNAC = '$pCodNac'";
	$sql  = @getSql("deleteNacionalidad", $pCodNac);
	
	$r = modifyDB($sql);	
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorNacioNoEliminada','$pCodNac. $msg');");	
	}else{
		$output->script("mostrarMsg('infoNacioEliminada','$pCodNac');");
		$output->script(" 	document.formTablaNacionalidades.btnIngresarTabla.disabled=''; 
							document.formTablaNacionalidades.btnGuardarTabla.disabled='disabled';
							document.formTablaNacionalidades.btnConsultarNacionalidad.disabled='';
							document.formTablaNacionalidades.btnActualizarTabla.disabled='disabled'; 
							document.formTablaNacionalidades.btnRetirarTabla.disabled='disabled'; 
							desactivarTablaNacionalidades(); ");
    resetQueriesNacionalidades();
	}
	
	return $output;
}

function llenarTablaNacionalidades($pCodNac) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();		
	
	$res = array();
	$sql  = @getSql("queryNacionalidad",$pCodNac);
	$res = queryDB($sql);
	
	$output->script("activarTablaNacionalidades();");
	
	$i = 0;
	foreach ($res as &$fila) {			
		$i = 1;
		$output->assign("codNac","value", "$fila[0]");
		$output->assign("nacional","value", "$fila[1]");
	}
	
	if($i == 1){
		$output->script("resultadoBox = '1'; desactivarObj('codNac');");		
	}else{
		$output->script("resultadoBox = '0'; desactivarTablaNacionalidades();");	
	}
	
	$output->script("$.fn.colorbox.close();");
	
	return $output; 
} 

function registrarProveedor($pCodPro , $pNomPro , $pDirPro , $pTel1Pro , $pTel2Pro, $pCelPro, $pConPro){
	$output = new xajaxResponse();	
	
	/*$sql="INSERT INTO PROVEEDORES (CODPRO, NOMPRO, DIRPRO, TE1PRO, TE2PRO, CELPRO, CONPRO) VALUES ('$pCodPro', '$pNomPro', '$pDirPro', '$pTel1Pro', '$pTel2Pro' , '$pCelPro', '$pConPro')";*/
	
	$sql  = @getSql("insertProveedor", $pCodPro, $pNomPro, $pDirPro, $pTel1Pro, $pTel2Pro , $pCelPro, $pConPro);
	
	$r = modifyDB($sql);	
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');		
		$output->script("mostrarMsg('errorProveedorNoGuardado','$pCodPro - $pNomPro. $msg');");	
	}else{
		$output->script("mostrarMsg('infoProveedorGuardado','$pCodPro - $pNomPro');");
		$output->script(" 	document.formTablaProveedores.btnIngresarTabla.disabled=''; 
							document.formTablaProveedores.btnGuardarTabla.disabled='disabled';
							document.formTablaProveedores.btnConsultarProveedor.disabled='';
							document.formTablaProveedores.btnActualizarTabla.disabled=''; 
							desactivarObj('codPro'); ");	
    resetQueriesProveedores();
	}
		
	return $output;
}

function actualizarProveedor($pCodPro , $pNomPro , $pDirPro , $pTel1Pro , $pTel2Pro, $pCelPro, $pConPro){
	$output = new xajaxResponse();
							
	$sql  = @getSql("updateProveedor", $pCodPro, $pNomPro, $pDirPro, $pTel1Pro, $pTel2Pro , $pCelPro, $pConPro);
	
	$r = modifyDB($sql);	
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorProveedorNoActualizado','$pCodPro - $pNomPro. $msg');");	
	}else{
		$output->script("mostrarMsg('infoProveedorActualizado','$pCodPro - $pNomPro');");
		$output->script(" 	document.formTablaProveedores.btnIngresarTabla.disabled=''; 
							document.formTablaProveedores.btnGuardarTabla.disabled='disabled';
							document.formTablaProveedores.btnConsultarProveedor.disabled='';
							document.formTablaProveedores.btnActualizarTabla.disabled=''; 
							document.formTablaProveedores.btnRetirarTabla.disabled=''; 
							desactivarObj('codPro'); ");
    resetQueriesProveedores();
	}
	
	return $output;
}

function retirarProveedor($pCodPro){
	$output = new xajaxResponse();
	
	//$sql = "DELETE FROM PROVEEDORES WHERE CODPRO = '$pCodPro'";
	$sql  = @getSql("deleteProveedor", $pCodPro);
	
	$r = modifyDB($sql);	
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorProveedorNoEliminado','$pCodPro. $msg');");	
	}else{
		$output->script("mostrarMsg('infoProveedorEliminado','$pCodPro');");
		$output->script(" 	document.formTablaProveedores.btnIngresarTabla.disabled=''; 
							document.formTablaProveedores.btnGuardarTabla.disabled='disabled';
							document.formTablaProveedores.btnConsultarProveedor.disabled='';
							document.formTablaProveedores.btnActualizarTabla.disabled='disabled'; 
							document.formTablaProveedores.btnRetirarTabla.disabled='disabled'; 
							desactivarTablaProveedores(); ");
    resetQueriesProveedores();
	}
	
	return $output;
}


function llenarTablaProveedores($pCodPro) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();		
	
	$res = array();
	$sql  = @getSql("queryProveedor",$pCodPro);
	$res = queryDB($sql);
	
	$output->script("activarTablaProveedores();");
	
	$i = 0;
	foreach ($res as &$fila) {			
		$i = 1;
		$output->assign("codPro","value", "$fila[0]");
		$output->assign("nomPro","value", "$fila[1]");
		$output->assign("dirPro","value", "$fila[2]");
		$output->assign("tel1Pro","value", "$fila[3]");
		$output->assign("tel2Pro","value", "$fila[4]");
		$output->assign("celPro","value", "$fila[5]");
		$output->assign("conPro","value", "$fila[6]");
	}
	
	if($i == 1){
		$output->script("resultadoBox = '1'; desactivarObj('codPro');");		
	}else{
		$output->script("resultadoBox = '0'; desactivarTablaProveedores();");	
	}
	
	$output->script("$.fn.colorbox.close();");
	
	return $output; 
}

function registrarPaquete($pCodPaq, $pNomPaq, $pDesPaq , $pCodOfi){
	$output = new xajaxResponse();	
	
	$sql  = @getSql("insertPaquete", $pCodPaq, $pNomPaq, $pDesPaq, $pCodOfi);
	
	$r = modifyDB($sql);	
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');		
		$output->script("mostrarMsg('errorPaqueteNoGuardado','$pCodPaq - $pNomPaq. $msg');");	
	}else{
		$output->script("mostrarMsg('infoPaqueteGuardado','$pCodPaq - $pNomPaq');");
		$output->script(" 	document.formTablaPaquetes.btnIngresarTabla.disabled=''; 
                        document.formTablaPaquetes.btnGuardarTabla.disabled='disabled';
                        document.formTablaPaquetes.btnConsultarPaquete.disabled='';
                        document.formTablaPaquetes.btnActualizarTabla.disabled=''; 
                        desactivarObj('codPaq'); ");	
	}
		
	return $output;
}

function actualizarPaquete($pCodPaq, $pNomPaq, $pDesPaq, $pCodOfi){
	$output = new xajaxResponse();
							
	$sql  = @getSql("updatePaquete", $pCodPaq, $pNomPaq, $pDesPaq, $pCodOfi);
	
	$r = modifyDB($sql);	
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorPaqueteNoActualizado','$pCodPaq - $pNomPaq. $msg');");	
	}else{
		$output->script("mostrarMsg('infoPaqueteActualizado','$pCodPaq - $pNomPaq');");
		$output->script(" 	document.formTablaPaquetes.btnIngresarTabla.disabled=''; 
                        document.formTablaPaquetes.btnGuardarTabla.disabled='disabled';
                        document.formTablaPaquetes.btnConsultarPaquete.disabled='';
                        document.formTablaPaquetes.btnActualizarTabla.disabled=''; 
                        document.formTablaPaquetes.btnRetirarTabla.disabled=''; 
                        desactivarObj('codPaq'); ");
	}
	
	return $output;
}

function retirarPaquete($pCodPaq){
	$output = new xajaxResponse();
	
	$sql  = @getSql("deletePaquete", $pCodPaq);
	
	$r = modifyDB($sql);	
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorPaqueteNoEliminado','$pCodPaq. $msg');");	
	}else{
		$output->script("mostrarMsg('infoPaqueteEliminado','$pCodPaq');");
		$output->script(" 	document.formTablaPaquetes.btnIngresarTabla.disabled=''; 
                        document.formTablaPaquetes.btnGuardarTabla.disabled='disabled';
                        document.formTablaPaquetes.btnConsultarPaquete.disabled='';
                        document.formTablaPaquetes.btnActualizarTabla.disabled='disabled'; 
                        document.formTablaPaquetes.btnRetirarTabla.disabled='disabled'; 
                        desactivarTablaPaquetes(); ");
	}
	
	return $output;
}

function llenarTablaPaquetes($pCodPaq) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();		
	
	$res = array();
	$sql  = @getSql("queryPaquete",$pCodPaq);
	$res = queryDB($sql);
	
	$output->script("activarTablaPaquetes();");
	
	$i = 0;
	foreach ($res as &$fila) {			
		$i = 1;
		$output->assign("codPaq","value", "$fila[0]");
		$output->assign("nomPaq","value", "$fila[1]");
		$output->assign("desPaq","value", "$fila[2]");
		$output->assign("selOfiPaq","value", "$fila[3]");
	}
	
	if($i == 1){
		$output->script("resultadoBox = '1'; desactivarObj('codPaq');");		
	}else{
		$output->script("resultadoBox = '0'; desactivarTablaPaquetes();");	
	}
	
	$output->script("$.fn.colorbox.close();");
	
	return $output; 
}

function desactivarResRes($pNroRes, $pResRes){
	$output = new xajaxResponse();
	
	$codUsr = $_SESSION["user"];
	
	$sql  = @getSql("updateBorradaResResDes", $pNroRes, $pResRes, $codUsr);	
	
	$r = modifyDB($sql);
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorItReservaNoEliminado','$msg');");	
	}else{
		$output->script("setBorradaRes($pResRes, 'SI');");
		$output->assign("imgAct$pResRes","style.display", "");
		$output->assign("imgEli$pResRes","style.display", "none");
		$output->assign("res$pResRes","style.display", "");
		
		//$output->assign("nomPax$pResRes","style.display", "none");
		$output->assign("nomPax$pResRes","style.display", "");
		$output->assign("nomPax$pResRes","disabled", "disabled");
		
		$output->assign("telPax$pResRes","style.display", "none");		
		$output->assign("nac$pResRes","style.display", "none");
		$output->assign("numPax$pResRes","style.display", "none");
		$output->assign("voucher$pResRes","style.display", "none");
		$output->assign("imgServ$pResRes","style.display", "none");
		$output->assign("fecLlega$pResRes","style.display", "none");
		$output->assign("fecSale$pResRes","style.display", "none");
    
		$output->assign("horaLlega$pResRes","style.display", "none");
		$output->assign("horaSale$pResRes","style.display", "none");
		$output->assign("codPaq$pResRes","style.display", "none");
    $output->assign("nomPaq$pResRes","style.display", "none");
    $output->assign("asesorAge$pResRes","style.display", "none");
    
		$output->assign("imgFecLlega$pResRes","style.display", "none");
		$output->assign("imgFecSale$pResRes","style.display", "none");
		$output->assign("codHot$pResRes","style.display", "none");
		$output->assign("nomHot$pResRes","style.display", "none");
		$output->assign("vloLlega$pResRes","style.display", "none");
		$output->assign("vloSale$pResRes","style.display", "none");
		$output->assign("imgVloLlega$pResRes","style.display", "none");
		$output->assign("imgVloSale$pResRes","style.display", "none");
		
		//$output->assign("imgObs$pResRes","style.display", "none");
		$output->assign("imgObs$pResRes","style.display", "");
		registrarLogDB('ANU', 'RES', $pNroRes, "Anular item $pResRes de Reserva # $pNroRes");
	}
	
	return $output; 
}

function desactivarRes($pNroRes){
	$output = new xajaxResponse();
	$codUsr = $_SESSION["user"];
	$sql  = @getSql("updateBorradaResDes", $pNroRes, $codUsr);	
	$r = modifyDB($sql);
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorReservaNoEliminado','$msg');");	
	}else{
		$sql  = @getSql("updateNumResAnulado", $pNroRes);
		$r2 = modifyDB($sql);
		$output->script("mostrarMsg('infoReservaEliminado');");
		registrarLogDB('ANU', 'RES', $pNroRes, "Anulacion de Reserva # $pNroRes");
	}	
	return $output; 
}

function activarResRes($pNroRes, $pResRes){
	$output = new xajaxResponse();
	
	//$sql = "UPDATE RESERVAS SET borrada = NULL WHERE numres = '$pNroRes' and resres = '$pResRes'";
	$sql  = @getSql("updateBorradaResResAct", $pNroRes, $pResRes);	
	
	$r = modifyDB($sql);
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorItReservaNoActivado','$msg');");	
	}else{
		$output->script("setBorradaRes($pResRes, 'NULL');");
		$output->assign("imgAct$pResRes","style.display", "none");	
		$output->assign("imgEli$pResRes","style.display", "");
		$output->assign("res$pResRes","style.display", "");
		$output->assign("nomPax$pResRes","style.display", "");
		$output->assign("nomPax$pResRes","disabled", "");
		$output->assign("nac$pResRes","style.display", "");
		$output->assign("numPax$pResRes","style.display", "");
		$output->assign("voucher$pResRes","style.display", "");
		$output->assign("imgServ$pResRes","style.display", "");
		$output->assign("fecLlega$pResRes","style.display", "");
		$output->assign("fecSale$pResRes","style.display", "");
		$output->assign("imgFecLlega$pResRes","style.display", "");
		$output->assign("imgFecSale$pResRes","style.display", "");		
		$output->assign("codHot$pResRes","style.display", "");
		$output->assign("nomHot$pResRes","style.display", "");
		$output->assign("vloLlega$pResRes","style.display", "");
		$output->assign("vloSale$pResRes","style.display", "");
		$output->assign("imgVloLlega$pResRes","style.display", "");
		$output->assign("imgVloSale$pResRes","style.display", "");	
		$output->assign("imgObs$pResRes","style.display", "");	
    
    $output->assign("horaLlega$pResRes","style.display", "");
		$output->assign("horaSale$pResRes","style.display", "");
		$output->assign("codPaq$pResRes","style.display", "");
		$output->assign("nomPaq$pResRes","style.display", "");
		$output->assign("asesorAge$pResRes","style.display", "");
    
		registrarLogDB('RES', 'RES', $pNroRes, "Restaurar item $pResRes de Reserva # $pNroRes");
	}
	
	return $output; 
}

function verificarPermiso($pUser, $pPermiso){
	$res = array();
	$sql  = @getSql("queryPermisoUsuario",$pUser,$pPermiso);
	$res = queryDB($sql);
	
	$i = 0;
	foreach ($res as &$fila) {			
		$i = 1;
	}

	if($i == 1){
		return true;	
	}else{
		return false;	
	}	
}

function getUsuarioRolCliente($codUsr){
	$res = array();
	$sql  = @getSql("queryUsuario",$codUsr);
	$res = queryDB($sql);
	
	$i = 0;
	$codCli = '';
	foreach ($res as &$fila) {			
		$i = 1;
		$codCli = $fila[7];
	}
	return $codCli;	
}

function obtenerNroTransfer($pTipo){
	if($_SESSION[$pTipo]=='0'){
		$res = array();
		$sql  = @getSql("queryNumTransSiguiente",$pTipo);
		$res = queryDB($sql);
		$nro = '0';
		foreach ($res as &$fila) {
			$nro = $fila[0];
		}
		$_SESSION[$pTipo] = $nro;
		reservarNroTransfer($nro,$pTipo);
	}	
	
	return $nro;	
}

function reservarNroTransfer($nroRes,$pTipo){
	$hoy = getFechaHoy();
	$hoy = getFechaDB($hoy);
	$sql  = @getSql("updateNumTransReservado",$nroRes,$pTipo,$hoy);
	$r = modifyDB($sql);	
}

function liberarNroTransfer($pTipo){
	if($_SESSION[$pTipo]!= '0'){
		$sql  = @getSql("updateLibNumTransReservado",$_SESSION[$pTipo], $pTipo);
		$r = modifyDB($sql);
		$_SESSION[$pTipo]= '0';
	}
}

function liberarNroTransferX($pTipo){
	$output = new xajaxResponse();
	liberarNroTransfer($pTipo);
	return $output;
}

function confirmarNroTransfer($nroTrans,$pTipo){
	$sql  = @getSql("updateConfirNumTransReservado",$nroTrans,$pTipo);	
	$r = modifyDB($sql);
	$_SESSION[$pTipo] = '0';
}

function selectTransfer($pTipo){
	$output = new xajaxResponse();
	$nroTrans = '0';
	
	if($_SESSION[$pTipo] == '0'){
		$nroTrans = obtenerNroTransfer($pTipo);
		$_SESSION[$pTipo] = $nroTrans;
	}
	else{
		$nroTrans = $_SESSION[$pTipo];
	}
	
	$output->script("document.getElementById('ordenTrans').innerHTML='$nroTrans'+' ';");
	
	return $output;
}



function getOpcionesOtrUbi(){	
	$res = array();
	$sql  = @getSql("queryListaOtrUbi");
	$res = queryDB($sql, "queryListaOtrUbi");
	
	return $res;
}

function getOpcionesArpUbi(){	
	$res = array();
	$sql  = @getSql("queryListaArpUbi");
	$res = queryDB($sql, "queryListaArpUbi");
	
	return $res;
}

function getOpcionesMueUbi(){	
	$res = array();
	$sql  = @getSql("queryListaMueUbi");
	$res = queryDB($sql, "queryListaMueUbi");
	
	return $res;
}

function getOpcionesVuelo($pTipoTrans){	
	$res = array();
	$sql  = @getSql("queryVuelosXTipo",$pTipoTrans);
	$res = queryDB($sql);
	
	return $res;
}

function inicializarOriDesTransfer(){
	$resHot = array();
	$textoHot ='';
	$resHot = getOpcionesCodHot();
	foreach ($resHot as &$fila) {
		$textoHot = $textoHot.", new Option('".$fila[1]."','".$fila[0]."')";
	}
	$resOtr = array();
	$textoOtr ='';
	$resOtr = getOpcionesOtrUbi();
	foreach ($resOtr as &$fila) {
		$textoOtr = $textoOtr.", new Option('".$fila[1]."','".$fila[0]."')";
	}
	
	$resArp = array();
	$textoArp ='';
	$resArp = getOpcionesArpUbi();
	foreach ($resArp as &$fila) {
		$textoArp = $textoArp.", new Option('".$fila[1]."','".$fila[0]."')";
	}
	
	$resMue = array();
	$textoMue ='';
	$resMue = getOpcionesMueUbi();
	foreach ($resMue as &$fila) {
		$textoMue = $textoMue.", new Option('".$fila[1]."','".$fila[0]."')";
	}
	
	echo"<script>
		var optIn_ori=new Array(new Option('- Seleccione -','<NULL>')".$textoArp.");\n		
		var optIn_des1=new Array(new Option('- Seleccione -','<NULL>')".$textoHot.");\n
		var optIn_des2=new Array(new Option('- Seleccione -','<NULL>')".$textoHot.");\n
		
		var optOut_ori=new Array(new Option('- Seleccione -','<NULL>')".$textoHot.");\n
		var optOut_des1=new Array(new Option('- Seleccione -','<NULL>')".$textoArp.");\n
		var optOut_des2=new Array(new Option('- Seleccione -','<NULL>')".$textoArp.");\n
		
		var optOtr_ori=new Array(new Option('- Seleccione -','<NULL>')".$textoMue.$textoHot.$textoOtr.");\n
		var optOtr_des1=new Array(new Option('- Seleccione -','<NULL>')".$textoMue.$textoHot.$textoOtr.");\n
		var optOtr_des2=new Array(new Option('- Seleccione -','<NULL>')".$textoMue.$textoHot.$textoOtr.");\n
		";
	echo"</script>";	
}

function inicializarVueloTransfer(){
	$resIN = array();
	$textoIN ='';
	$resIN = getOpcionesVuelo('IN');
	foreach ($resIN as &$fila) {
		$textoIN = $textoIN.", new Option(\"".$fila[1]."\",\"".$fila[1]."\")";
	}
	
	$resOUT = array();
	$textoOUT ='';
	$resOUT = getOpcionesVuelo('OUT');
	foreach ($resOUT as &$fila) {
		$textoOUT = $textoOUT.", new Option(\"".$fila[1]."\",\"".$fila[1]."\")";
	}
	
							
	echo"<script>
		var optVloIN=new Array(new Option('- Seleccione -','<NULL>')".$textoIN.");\n	
		var optVloOUT=new Array(new Option('- Seleccione -','<NULL>')".$textoOUT.");\n
		";
	echo"</script>";	
}

function registrarTransfer($pTipo, $pCate, $pFser, $pValSer, $pNompax, $pNumpax, 
						   $pNroVlo, $pFecHoraVlo, $pOrigen, $pDestino1, $pDestino2, $pPlacaTax, 
						   $pConductorTax, $pDocuTax, $pObs, $pCantVou){
	$output = new xajaxResponse();
	$codSerTax = '0';
	$codAsesor = $_SESSION["user"];
	
	$codSerTax = $_SESSION[$pTipo];
	
	if(($pFecHoraVlo == '')||($pFecHoraVlo == '<NULL>'))
		$pFecHoraVlo = 'NULL';
	else
		$pFecHoraVlo = getFechaDB($pFser.' '.$pFecHoraVlo);
	
	$pFser = getFechaDB($pFser);
	
	if(($pNroVlo == '')||($pNroVlo == '<NULL>'))
		$pNroVlo = 'NULL';
	else
		$pNroVlo = "'".$pNroVlo."'";
	
	if($pCantVou == '')
		$pCantVou = 'NULL';
	
	if($pDestino2 == '<NULL>')
		$pDestino2 = 'NULL';
	else
		$pDestino2 = "'".$pDestino2."'";
		
	$sql  = @getSql("mergeTaxista", $pDocuTax, $pConductorTax, $pPlacaTax);	
	$r1 = modifyDB($sql);

	if($r1<= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorTaxistaNoGuardado','$msg');");
		$r = 0;
	}else{		
		$sql  = @getSql("insertTransfer", getTipoGral($pTipo), $codSerTax, $pFser, $pValSer, $pNumpax, 
										  $pNroVlo, $pFecHoraVlo, $pOrigen, $pDestino1, 
										  $pDocuTax, $pObs, $pCantVou, $codAsesor, $pCate, $pDestino2, $pNompax);			
		$r = modifyDB($sql);
	}
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorTransferNoGuardado','$msg');");						
	}else{
		$output->script("mostrarMsg('infoTransferGuardado','$codSerTax');");
		$output->script("activarObj('btnIngresarTransfer');
						 desactivarObj('btnGuardarTransfer');
						 activarObj('btnConsultarTransfer');
						 activarObj('btnActualizarTransfer');
						 activarObj('btnRetirarTransfer');
						 activarObj('btnCancelarTransfer');");
		$output->script("transferModificar = ".$_SESSION[$pTipo].";");				 
		confirmarNroTransfer($codSerTax, $pTipo);			
		$_SESSION[$pTipo] = obtenerNroTransfer($pTipo);
		
		registrarLogDB('REG', getTipoGral($pTipo), $codSerTax, "Registro de Transfer-".getTipoGral($pTipo)." # $codSerTax");	
	}
	
	return $output;
}

function registrarTour($pTour, $pFechaTour, $pHoraTour, $pLugar, $pProv, $pCupos, $oficina){
	$output = new xajaxResponse();
	
	$pFechaTour = getFechaDB($pFechaTour.' '.$pHoraTour);
	
	$codTour = str_replace("'","",$pTour.'_'.$pFechaTour);
	$codTour = str_replace(" ","_",$codTour);
	
	$sql  = @getSql("insertTour", $codTour, $pTour, $pFechaTour, $pLugar, $pProv, $pCupos, $oficina);			
	$r = modifyDB($sql);
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorTourNoGuardado','$msg');");						
	}else{
		$output->script("mostrarMsg('infoTourGuardado');");
		$output->script("desactivarTour();");		
		registrarLogDB('REG', 'TOUR', '0', "Registro Prog Tour # ".$codTour);	
	}	
		
	return $output;
}


function registrarTourRango($pTour, $pFechaTourIni, $pFechaTourFin, $pHoraTour, $pLugar, $pProv, $pCupos, $oficina){
	$output = new xajaxResponse();
	
  $days = array('0101', '0102', '0103', '0104', '0105', '0106', '0107', '0108', '0109', '0110', '0111', '0112', '0113', '0114', '0115', '0116', '0117', '0118', '0119', '0120', '0121', '0122', '0123', '0124', '0125', '0126', '0127', '0128', '0129', '0130', '0131', '0201', '0202', '0203', '0204', '0205', '0206', '0207', '0208', '0209', '0210', '0211', '0212', '0213', '0214', '0215', '0216', '0217', '0218', '0219', '0220', '0221', '0222', '0223', '0224', '0225', '0226', '0227', '0228', '0301', '0302', '0303', '0304', '0305', '0306', '0307', '0308', '0309', '0310', '0311', '0312', '0313', '0314', '0315', '0316', '0317', '0318', '0319', '0320', '0321', '0322', '0323', '0324', '0325', '0326', '0327', '0328', '0329', '0330', '0331', '0401', '0402', '0403', '0404', '0405', '0406', '0407', '0408', '0409', '0410', '0411', '0412', '0413', '0414', '0415', '0416', '0417', '0418', '0419', '0420', '0421', '0422', '0423', '0424', '0425', '0426', '0427', '0428', '0429', '0430', '0501', '0502', '0503', '0504', '0505', '0506', '0507', '0508', '0509', '0510', '0511', '0512', '0513', '0514', '0515', '0516', '0517', '0518', '0519', '0520', '0521', '0522', '0523', '0524', '0525', '0526', '0527', '0528', '0529', '0530', '0531', '0601', '0602', '0603', '0604', '0605', '0606', '0607', '0608', '0609', '0610', '0611', '0612', '0613', '0614', '0615', '0616', '0617', '0618', '0619', '0620', '0621', '0622', '0623', '0624', '0625', '0626', '0627', '0628', '0629', '0630', '0701', '0702', '0703', '0704', '0705', '0706', '0707', '0708', '0709', '0710', '0711', '0712', '0713', '0714', '0715', '0716', '0717', '0718', '0719', '0720', '0721', '0722', '0723', '0724', '0725', '0726', '0727', '0728', '0729', '0730', '0731', '0801', '0802', '0803', '0804', '0805', '0806', '0807', '0808', '0809', '0810', '0811', '0812', '0813', '0814', '0815', '0816', '0817', '0818', '0819', '0820', '0821', '0822', '0823', '0824', '0825', '0826', '0827', '0828', '0829', '0830', '0831', '0901', '0902', '0903', '0904', '0905', '0906', '0907', '0908', '0909', '0910', '0911', '0912', '0913', '0914', '0915', '0916', '0917', '0918', '0919', '0920', '0921', '0922', '0923', '0924', '0925', '0926', '0927', '0928', '0929', '0930', '1001', '1002', '1003', '1004', '1005', '1006', '1007', '1008', '1009', '1010', '1011', '1012', '1013', '1014', '1015', '1016', '1017', '1018', '1019', '1020', '1021', '1022', '1023', '1024', '1025', '1026', '1027', '1028', '1029', '1030', '1031', '1101', '1102', '1103', '1104', '1105', '1106', '1107', '1108', '1109', '1110', '1111', '1112', '1113', '1114', '1115', '1116', '1117', '1118', '1119', '1120', '1121', '1122', '1123', '1124', '1125', '1126', '1127', '1128', '1129', '1130', '1201', '1202', '1203', '1204', '1205', '1206', '1207', '1208', '1209', '1210', '1211', '1212', '1213', '1214', '1215', '1216', '1217', '1218', '1219', '1220', '1221', '1222', '1223', '1224', '1225', '1226', '1227', '1228', '1229', '1230', '1231');
  
  $pFechaTourIni = str_replace("-","",$pFechaTourIni);
  $pFechaTourFin = str_replace("-","",$pFechaTourFin);
  $yearIni = substr($pFechaTourIni,0,4);
  $yearFin = substr($pFechaTourFin,0,4);
  $fechaIntIni = (int)$pFechaTourIni;
  $fechaIntFin = (int)$pFechaTourFin;
  
  if($yearIni != $yearFin){
    $output->script("alert('Error. Ambas fechas deben ser de un mismo anio.');");
    return $output;
  }
  
  $indIni = -1;
  $indFin = -99;
  // Encontrar el indice de la fecha inicial
  foreach ($days as $i => $valor) {
    if($yearIni.$valor == $pFechaTourIni){
      $indIni = $i;
    }
    if($yearFin.$valor == $pFechaTourFin){
      $indFin = $i;
    }
  }
  
  if(($indIni >= 0)&&($indFin >= 0)&&($indFin >= $indIni)){
    // Se inserta para cada una de las fechas
    $j = count($days);
    $msg = '';
    $indError = -1;
    $fechaIt = '';
    for($i = $indIni; $i <= $indFin; $i++) {
      $fechaIt = $yearIni."-".substr($days[$i],0,2)."-".substr($days[$i],2,2);
      $fechaTour = getFechaDB($fechaIt.' '.$pHoraTour);
      
      $codTour = str_replace("'","",$pTour.'_'.$fechaTour);
      $codTour = str_replace(" ","_",$codTour);
      
      $sql  = @getSql("insertTour", $codTour, $pTour, $fechaTour, $pLugar, $pProv, $pCupos, $oficina);			
      $r = modifyDB($sql);
      
      if ($r <= 0){
        $msg = getMsgCaractEsp(getErrorDB(),'si');
        $errorMsg = $msg;
        $indError = $i;
        break;			
      }else{
        registrarLogDB('REG', 'TOUR', '0', "Registro de Tour # ".$codTour);	
      }
      
    }
    
    if($indError >= 0){
      $output->script("alert('Error registrando el tour para la fecha $fechaIt. $msg. No se registro ningun tour.');");
      // Hacer rollback
      for($i = $indIni; $i < $indError; $i++) {
        $fechaIt = $yearIni."-".substr($days[$i],0,2)."-".substr($days[$i],2,2);
        $fechaTour = getFechaDB($fechaIt.' '.$pHoraTour);
        
        $codTour = str_replace("'","",$pTour.'_'.$fechaTour);
        $codTour = str_replace(" ","_",$codTour);
        
        $sql  = @getSql("deleteTour", $codTour);			
        $r = modifyDB($sql);
      }
      
    }else{
      $output->script("alert('Se registro la programacion de los tours especificados.');");
      $output->script("desactivarTour();");		
    }
    
  }else{
    $output->script("alert('Error. La fecha final debe ser despues de la fecha inicial.  $pFechaTourIni - $pFechaTourFin $indIni - $indFin');");
    return $output;
  }
  
	return $output;
}

function cambiarPassword($pUser, $pActual, $pNuevo){
	$output = new xajaxResponse();
	
	if(getLoginStatus($pUser,$pActual)){	
		$sql  = @getSql("updatePassword", $pUser, $pNuevo);			
		$r = modifyDB($sql);
		
		if ($r <= 0){
			$msg = getMsgCaractEsp(getErrorDB(),'si');
			$output->script("mostrarMsg('errorCambioPassNoGuardado','$msg');");						
		}else{
			$output->script("mostrarMsg('infoCambioPassGuardado');");
			$output->script("limpiarPassword();");		
		}	
	}else{
		$output->script("mostrarMsg('errorPasswordNoValido');");
	}
		
	return $output;
}

function actualizarTransfer($pTipo, $pCate, $pFser, $pValSer, $pNompax, $pNumpax, 
						   $pNroVlo, $pFecHoraVlo, $pOrigen, $pDestino1, $pDestino2, $pPlacaTax, 
						   $pConductorTax, $pDocuTax, $pObs, $pCantVou, $codSerTax){
	$output = new xajaxResponse();
	$codAsesor = $_SESSION["user"];;
	/*
	if($pFecHoraVlo == '')
		$pFecHoraVlo = 'NULL';
	else
		$pFecHoraVlo = getFechaDB($pFser.' '.$pFecHoraVlo);
	*/
	if(($pFecHoraVlo == '')||($pFecHoraVlo == '<NULL>'))
		$pFecHoraVlo = 'NULL';
	else
		$pFecHoraVlo = getFechaDB($pFser.' '.$pFecHoraVlo);
		
	$pFser = getFechaDB($pFser);
	/*
	if($pNroVlo == '')
		$pNroVlo = 'NULL';
	else
		$pNroVlo = "'".$pNroVlo."'";
	*/
	if(($pNroVlo == '')||($pNroVlo == '<NULL>'))
		$pNroVlo = 'NULL';
	else
		$pNroVlo = "'".$pNroVlo."'";
		
	if($pCantVou == '')
		$pCantVou = 'NULL';

	if($pDestino2 == '<NULL>')
		$pDestino2 = 'NULL';
	else
		$pDestino2 = "'".$pDestino2."'";

	$sql  = @getSql("mergeTaxista", $pDocuTax, $pConductorTax, $pPlacaTax);	
	$r1 = modifyDB($sql);

	if($r1<= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorTaxistaNoGuardado','$msg');");
		$r = 0;
	}else{
		$sql  = @getSql("updateTransfer", getTipoGral($pTipo), $codSerTax, $pFser, $pValSer, $pNumpax, 
										  $pNroVlo, $pFecHoraVlo, $pOrigen, $pDestino1, 
										  $pDocuTax, $pObs, $pCantVou, $codAsesor, $pCate, $pDestino2, $pNompax);			
		$r = modifyDB($sql);	
	}
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorTransferNoActualizado','$msg');");						
	}else{
		$output->script("mostrarMsg('infoTransferActualizado','$codSerTax');");
		registrarLogDB('ACT', getTipoGral($pTipo), $codSerTax, "Actualizacion de Transfer-".getTipoGral($pTipo)." # $codSerTax");		
	}
	
	return $output;
}

function retirarTransfer($pTipo, $pCodSerTax){
	$output = new xajaxResponse();
	$sql  = @getSql("deleteTransfer", $pTipo, $pCodSerTax);
	
	$r = modifyDB($sql);	
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorTransferNoEliminado', '$pCodSerTax. $msg');");	
	}else{
		$output->script("mostrarMsg('infoTransferEliminado', '$pCodSerTax');");
		$output->script(" 	document.formTablaTransfer.btnIngresarTransfer.disabled=''; 
							document.formTablaTransfer.btnGuardarTransfer.disabled='disabled';
							document.formTablaTransfer.btnConsultarTransfer.disabled='';
							document.formTablaTransfer.btnActualizarTransfer.disabled='disabled'; 
							document.formTablaTransfer.btnRetirarTransfer.disabled='disabled'; 
							ocultarTablaTransfer(); 
							ocultarObj('selTipoTrans'); 
							document.getElementById('labelSelTipoTrans').innerHTML=' ';
							");
		$output->script("document.getElementById('labelOrdenTrans').innerHTML=' '");
		$output->script("document.getElementById('ordenTrans').innerHTML=' ';");
	}
	
	return $output;
}

function desactivarTransfer($pTipo, $pCodSerTax){
	$output = new xajaxResponse();
	$codAsesor = $_SESSION["user"];
	$sql  = @getSql("updateBorradaTransferDes", getTipoGral($pTipo), $pCodSerTax, $codAsesor);	
	$r = modifyDB($sql);
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorTransferNoEliminado','$msg');");	
	}else{
		$sql  = @getSql("updateNumTransAnulado", $pTipo, $pCodSerTax);
		$r2 = modifyDB($sql);
		$output->script("mostrarMsg('infoTransferEliminado');");
		registrarLogDB('ANU', getTipoGral($pTipo), $pCodSerTax, "Anulacion de Transfer-".getTipoGral($pTipo)." # $pCodSerTax");
	}	
	return $output; 
}

function llenarTablaTransfer($pTipoTrans, $pCodTrans) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();		
	
	$res = array();
	$sql  = @getSql("queryTransfer",$pTipoTrans,$pCodTrans);
	$res = queryDB($sql);
	
	$output->script("mostrarTablaTransfer(); mostrarObj('selTipoTrans'); document.getElementById('labelSelTipoTrans').innerHTML=getValueXML('formTablaTransfer','selTipoTrans')+' ';");
	
	$i = 0;
	$anulada = false;
	$asesor = '';
	foreach ($res as &$fila) {			
		$i = 1;		
		//$output->assign("selTipoTrans","value", "$fila[0]");
		$tipoEspecifico = getTipoEspecifico($pTipoTrans, $pCodTrans);
		//$tipoEspecifico = 'IN NAC';
		$output->assign("selTipoTrans","value", "$tipoEspecifico");
		
		$fecSer = getFechaDBToInterfaz($fila[2]); 
		$output->script("fechaVlo = getFechaInterfazToYYYY_MM_DD('$fecSer');");
		$output->assign("fecSerTrans","value", "$fecSer");
		
		$fecSer = getFechaDBToYYYYMMDD($fila[2]);
		
		$output->assign("valTrans","value", "$fila[3]");
		$output->assign("cantPax","value", "$fila[4]");
		
		$nroVlo = $fila[5];
		//$output->assign("nroVlo","value", "$fila[5]");
		
		$fecHoraVlo = getHoraDBToInterfaz($fila[6]); 						
		//$output->assign("horaVlo","value", "$fecHoraVlo");		
		
		$selOri = $fila[7];
		$selDes = $fila[8];
		$selDes2 = $fila[17];
		if($selDes2 == '')
			$selDes2 = '<NULL>';
		
		$output->assign("placaTax","value", "$fila[9]");
		$output->assign("conducTax","value", "$fila[10]");
		$output->assign("docuTax","value", "$fila[11]");
		$output->assign("obsTrans","value", "$fila[12]");
		$output->assign("cantVou","value", "$fila[13]");
		//$fila[14] -> ASESOR	
		if($fila[15] == 'SI'){
			$anulada = true;
			$asesor = $fila[14];
		}		
		$output->assign("selCateTrans","value", "$fila[16]");
		$output->assign("nomPax","value", "$fila[18]");
	}
	
	if($i == 1){
		$output->script("cargarCamposTransfer2('selTipoTrans','cantPax', false);");
		if(getTipoGral($pTipoTrans) == 'IN'){
			$output->script("document.getElementById('labelOrdenTrans').innerHTML=getValueXML('formTablaTransfer','labelOrdenTransIn')+' '");			
		}	
		if(getTipoGral($pTipoTrans) == 'OUT'){
			$output->script("document.getElementById('labelOrdenTrans').innerHTML=getValueXML('formTablaTransfer','labelOrdenTransOut')+' '");
		}	
		if($pTipoTrans == 'OTR'){
			$output->script("document.getElementById('labelOrdenTrans').innerHTML=getValueXML('formTablaTransfer','labelOrdenTransOtr')+' '");
		}
		$output->assign("selOrigenTrans","value", "$selOri");
		$output->assign("selDestinoTrans1","value", "$selDes");
		$output->assign("selDestinoTrans2","value", "$selDes2");
		
		$output->script("document.getElementById('ordenTrans').innerHTML='$pCodTrans'+' ';");
		$output->script("resultadoBox = '1'; desactivarObj('selTipoTrans'); transferModificar = $pCodTrans;");
		
		if((getTipoGral($pTipoTrans) == 'IN')||(getTipoGral($pTipoTrans) == 'OUT')){
			$output->script("document.formTablaTransfer.horaVlo.value = '$fecHoraVlo';");
			
			/*--------- cargarSelNroVlo -------------*/
			
			$output->script("mis_options=eval('optVlo".getTipoGral($pTipoTrans)."');");
			$output->script("num_options = mis_options.length;");
			$output->script("document.formTablaTransfer.selNroVlo.length = num_options;");
			$output->script("for(i=0;i<num_options;i++){
								document.formTablaTransfer.selNroVlo.options[i] = mis_options[i]; 
							}
							");
			
			/*----------------------*/
			
			$output->script("document.formTablaTransfer.selNroVlo.value = '".$nroVlo."';");	
			//$output->assign("selNroVlo","value", "$nroVlo");
		}
		else{
			$output->script("document.formTablaTransfer.selNroVlo.value = '<NULL>';");				
		}
		if($anulada == true){
			$output->script("mostrarMsg('infoTransferAnulado','$asesor');");
			$output->script("ocultarTablaTransfer(); transferModificar = 0;");
		}
	}else{
		$output->script("document.getElementById('labelOrdenTrans').innerHTML=' '");
		$output->script("document.getElementById('ordenTrans').innerHTML=' ';");
		$output->script("resultadoBox = '0'; ocultarTablaTransfer(); ocultarObj('selTipoTrans'); document.getElementById('labelSelTipoTrans').innerHTML=' '; transferModificar = 0;");	
	}
	$output->script("$.fn.colorbox.close();");
	
	return $output; 
}

 function llenarTablaTransferNom($pNomPax) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();	
	$res = array();
	
	$sql  = @getSql("queryTransferXNomPax",$pNomPax);	
	$res = queryDB($sql);
	
	$output->assign("resNom0","style.display", "");		
		
	$output->script("limpiarTransferNom();");
	
	$i = 0;
	$phpMaxNomTrans = getVarPHPfromDB('phpMaxNomTrans');
	
	foreach ($res as &$fila) {
		$i = $i+1;
		if($i > $phpMaxNomTrans){
			$output->script("mostrarMsg('errorSuperaMaxFilas1','$phpMaxNomTrans','errorSuperaMaxFilas2');");
			break;
		}
		if ($i % 2){
			$color = '#CBEEF5';
			$colorId = '1';
		}else{
			$color = '#FFFFFF';
			$colorId = '2';
		}
		$output->script("agregarFilaTransferNom($colorId, '$color', $i, '$fila[0]', '$fila[1]', '$fila[2]', '$fila[3]', '$fila[4]', '$fila[5]');");
	}	
	
	if($i > 0){
		$output->script("document.getElementById('labelResulConsultaTransferNom').innerHTML=getValueXML('formConsultaTransfer','labelResulConsultaTransferNomTrue');");
	}else{
		$output->assign("resNom0","style.display", "none");
		$output->script("document.getElementById('labelResulConsultaTransferNom').innerHTML=getValueXML('formConsultaTransfer','labelResulConsultaTransferNomFalse');");
	}

	return $output; 
 }
 
function guardarSuma($valor, $it){
	$_SESSION["isSumPHPExcel"] = '1';
	$_SESSION["sumPHPExcel"][$it] = $valor;
}

function cargarDocuTax($pNomtax) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();		
	
	$res = array();
	$sql  = @getSql("queryTaxistaXNom",$pNomtax);
	$res = queryDB($sql);
	$i = 0;
	foreach ($res as &$fila) {			
		$i = 1;		
		$output->assign("docuTax","value", "$fila[0]");	
		$output->assign("placaTax","value", "$fila[2]");	
	}
	if($i == 0){
		$output->assign("docuTax","value", "");	
		$output->assign("placaTax","value", "");
	}
		
	return $output; 
} 

function cargarNomTax($pNomtax) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();		
	
	$res = array();
	$sql  = @getSql("queryTaxistaXDocu",$pNomtax);
	$res = queryDB($sql);
	$i = 0;
	foreach ($res as &$fila) {			
		$i = 1;		
		$output->assign("conducTax","value", "$fila[1]");	
		$output->assign("placaTax","value", "$fila[2]");	
	}
	if($i == 0){
		$output->assign("conducTax","value", "");	
		$output->assign("placaTax","value", "");
	}
		
	return $output; 
} 
function sacarReporteX($pReporte, $p1='', $p2='', $p3='', $p4='', $p5='', 
								  $p6='', $p7='', $p8='', $p9='', $p10=''){
	$output = new xajaxResponse();
	set_time_limit(0);
	$res = array();
	$sql  = @getSql($pReporte, $p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9, $p10);
	
	$res = queryDB($sql);
	if($res){
		$nroCol = count($res[0]);
	}else{
		$nroCol = 0;
	}
	
	if($nroCol == 0){
		$output->script("mostrarMsg('errorReporteNoDatos');");
	}
	
	$_SESSION["isSumPHPExcel"] = '0';
	$_SESSION["sumPHPExcel"] = array();
	$_SESSION["sumPHPExcel"][1] = '';
	$_SESSION["sumPHPExcel"][2] = '';
	$_SESSION["sumPHPExcel"][3] = '';
	$_SESSION["sumPHPExcel"][4] = '';
	$_SESSION["sumPHPExcel"][5] = '';
	$_SESSION["sumPHPExcel"][6] = '';
	$_SESSION["sumPHPExcel"][7] = '';
	$_SESSION["sumPHPExcel"][8] = '';
	$_SESSION["sumPHPExcel"][9] = '';
	$_SESSION["sumPHPExcel"][10] = '';	
	$_SESSION["sumPHPExcel"][11] = '';
	$_SESSION["sumPHPExcel"][12] = '';
	$_SESSION["sumPHPExcel"][13] = '';
	$_SESSION["sumPHPExcel"][14] = '';
	$_SESSION["sumPHPExcel"][15] = '';
	$_SESSION["sumPHPExcel"][16] = '';
	$_SESSION["sumPHPExcel"][17] = '';
	$_SESSION["sumPHPExcel"][18] = '';
	$_SESSION["sumPHPExcel"][19] = '';
	$_SESSION["sumPHPExcel"][20] = '';
	
	$_SESSION["objPHPExcel"] = array();
	$_SESSION["objPHPExcel"] = $res;
	$_SESSION["numPHPExcel"] = $nroCol;
	
	$output->script("campos = new Array($nroCol+1);");
	$output->script("var w = 0;");	
	$output->script("var t = '';");
	$output->script("var totw = 0;");
	
	$output->script("titulosReporte = new Array();");
	$output->script("arrSum = new Array('NO','NO','NO','NO','NO','NO','NO','NO','NO','NO',
											'NO','NO','NO','NO','NO','NO','NO','NO','NO','NO');");
	$output->script("sumCampo = new Array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);");
	$output->script("chkSuma = 0;");
	
	$output->script("var myCell = null;	var myRow = null; var myEnc = null;	var myA = null; var myTbody = null; var myTable = document.getElementById('tablaReporte');");	
	
	if($nroCol > 0){
		$output->script("try { while(myTable.hasChildNodes()) {myTable.removeChild(myTable.firstChild);} } catch(mierror){ } ");
		$output->script("myTbody = document.createElement('tbody'); 
						myTbody.id = 'bodytabla'; 
						myTable.appendChild(myTbody); 
						myRow = document.createElement('tr'); 
						myRow.id='filarep_0';");
	}else{
		$output->script("try { while(myTable.hasChildNodes()) {myTable.removeChild(myTable.firstChild);} } catch(mierror){ } ");	
	}
	
	for($j=1;$j<=$nroCol;$j=$j+1){
		$output->script("w = getWidth('".$pReporte."Campo$j');");
		$output->script("t = getTitulo('".$pReporte."Campo$j');");
		$output->script("a = getAlineacion('".$pReporte."Campo$j');");
		$output->script("s = getSum('".$pReporte."Campo$j');");
		$output->script("totw = totw + w;");
		$output->script("campos[$j] = new Array(w,t,a);");
		$output->script("titulosReporte[$j] = t;");
		$output->script("arrSum[$j] = s;");
		
		$output->script("myEnc = document.createElement('th');");
		$output->script("myEnc.align='center';");
		$output->script("myEnc.valign='center';");
		$output->script("myEnc.height = 20;");
		$output->script("myEnc.width = campos[$j][0];");
		$output->script("myA = document.createElement('a');");
		$output->script("myA.id='val_0_". $j ."';");
		$output->script("myA.className='textoEncReporte';");
		$output->script("myA.innerHTML = campos[$j][1];");
		$output->script("myEnc.appendChild(myA);");
		$output->script("myRow.appendChild(myEnc);");
	}
	
	if($nroCol > 0){
		$output->script("myTbody.appendChild(myRow);");	
	}
	

	if($nroCol > 0){
		$i = 0;	
		foreach ($res as &$fila) {
			$i=$i+1;
		}
		
		$output->script("filasReporte = $i;");
		$output->script("document.getElementById('tablaReporte').style.width = totw;");
		
		$k = 0;
		$bq = 50;
		if($i > 0){
			if ($i > $bq){
				$pt = $i / $bq;
				$pt = floor ( $pt ) + 1;
			}else{
				$pt = 1;
			}
			
			for($k=1;$k<=$pt;$k=$k+1){
				$output->script("var myTbody$k = null;
					myTbody$k = document.createElement('tbody'); 
					myTbody$k.id = 'bodytabla$k';
					myTable.appendChild(myTbody$k);");
			}
			
			$output->script("var myTbodyFin = null;
					myTbodyFin = document.createElement('tbody'); 
					myTbodyFin.id = 'bodytablafin';
					myTable.appendChild(myTbodyFin);
					");
					
			$ini = 0;
			$fin = 0;
			for($k=1;$k<=$pt;$k=$k+1){
				$ini = (($k-1)*$bq) + 1;
				$fin = $ini + ($bq-1);
				$output->script("xajax_sacarReporteY('$k', '$pt', '$pReporte', '$nroCol', $ini, $fin);");
			}
		}
	
	}

	return $output;
}


function sacarReporteY($sec, $finSec, $pReporte, $nroCol, $ini, $fin){
	$output = new xajaxResponse();	
	set_time_limit(0);
	$output->script("var myCell = null;	var myRow = null; var myEnc = null;	var myA = null; var myTbody = document.getElementById('bodytabla$sec');");	
		
	$res = array();
	$res = $_SESSION["objPHPExcel"];
	$i = 0;
	$l = 0;
	foreach ($res as &$fila2) {
		$i=$i+1;		
		if(($i >= $ini)&&($i <= $fin)){	
			$output->script("myRow = document.createElement('tr');");
			$output->script("myRow.id='filarep_". $i ."';");
			for($j=1;$j<=$nroCol;$j=$j+1){						
				$output->script("if(arrSum[$j] == 'SUM'){\n
								chkSuma = 1;\n
								sumCampo[$j] = sumCampo[$j] + parseInt('".str_replace(".","",$fila2[$j-1])."');\n
							}else{\n
								sumCampo[$j] = -1;
							}");
				$output->script("myCell = document.createElement('td');");
				$output->script("myCell.valign='center';");
				$output->script("myCell.align = campos[$j][2];");
				$output->script("myA = document.createElement('a');");
				$output->script("myA.id='val_". $i ."_". $j ."';");
				$output->script("myA.className='textoValReporte';");
				$output->script("myA.innerHTML = '".$fila2[$j-1]."';");
				$output->script("myCell.appendChild(myA);");
				$output->script("myRow.appendChild(myCell);");	
			}
			$output->script("myTbody.appendChild(myRow);");
		}
		
	}	
	

	for($j=1;$j<=$nroCol;$j=$j+1){
		$output->script("if((arrSum[$j] == 'OPE')&&($sec == $finSec)){\n
							chkSuma = 1;\n
							sumCampo[$j] = getOpe('".$pReporte."Campo$j');\n
						}");
	}
	
	$output->script("if((chkSuma == 1)&&($sec == $finSec)){\n
						myRow = document.createElement('tr'); myRow.style.background='white';\n
					}");
	
	for($j=1;$j<=$nroCol;$j=$j+1){					
		$output->script("if((chkSuma == 1)&&($sec == $finSec)){\n
							myCell = document.createElement('td');\n
							myCell.valign='center';\n
							myCell.align='right';\n
							myA = document.createElement('a');\n
							myA.id='val_". ($i+1) ."_". $j ."';\n
							myA.className='textoValReporte';\n	
							if(sumCampo[$j] != -1){\n
								myA.innerHTML = getValorConPuntos(sumCampo[$j]);\n
								xajax_guardarSuma(getValorConPuntos(sumCampo[$j]), $j);\n
							}else{\n
								myA.innerHTML = '';\n
							}\n
							myCell.appendChild(myA);\n
							myRow.appendChild(myCell);\n
						}");
	}
	
	$output->script("if((chkSuma == 1)&&($sec == $finSec)){\n
						var myTbodyFin = document.getElementById('bodytablafin');\n
						try { while(myTbodyFin.hasChildNodes()) {myTbodyFin.removeChild(myTbodyFin.firstChild);} } catch(mierror){ };\n
						myTbodyFin.appendChild(myRow);\n
					}");
					
	$output->script("if((chkSuma == 1)&&($sec == $finSec)){\n
						if(sumCampo[1] == -1){\n
							document.getElementById('val_". ($i+1) ."_1').innerHTML = 'TOTAL';\n
							xajax_guardarSuma('TOTAL', 1);\n
						}\n
					}");	
	
	$output->script("if($sec == $finSec){\n
						alert('Se encontraron ".($i)." resultados');
						document.getElementById('reporte').style.display = '';
					}");	
	
	return $output;
}

function borrarReporte($idReporte, $p1='', $p2='', $p3='', $p4='', $p5='', 
								   $p6='', $p7='', $p8='', $p9='', $p10=''){
	$output = new xajaxResponse();
	if($idReporte > 0){
		$sql  = @getSql("deleteReporteLog".$idReporte, $p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9, $p10);		
		$r = modifyDB($sql);			
		if ($r <= 0){
			$msg = getMsgCaractEsp(getErrorDB(),'si');		
			$output->script("mostrarMsg('errorLogNoBorrado','$msg');");	
		}else{
			$output->script("mostrarMsg('infoLogBorrado');");
			//$output->script("cargarTablaReporte('0','0','dummy',0);");
			$output->script("window.location = ('?id=43');");			
		}
	}
	return $output;
}

function getExcel($pTitulos){
	$output = new xajaxResponse();
	/*****************************/
		
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// Set properties
	$objPHPExcel->getProperties()->setCreator("Receptivos")
								 ->setLastModifiedBy("Receptivos")
								 ->setTitle("Reporte Receptivos");

	$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);


	$nroCol = $_SESSION["numPHPExcel"];
	
	//Encabezado
	$objPHPExcel->getActiveSheet()->getStyle('A1:'.getColumnName($nroCol).'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFA5D4FA');	
	$objPHPExcel->getActiveSheet()->getStyle('A1:'.getColumnName($nroCol).'1')->getFont()->setBold(true);
	for($j=1;$j<=$nroCol;$j=$j+1){		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(getColumnName($j).'1', $pTitulos[$j]);
		$objPHPExcel->getActiveSheet()->getStyle(getColumnName($j).'1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle(getColumnName($j).'1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);	
		$objPHPExcel->getActiveSheet()->getStyle(getColumnName($j).'1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);	
		$objPHPExcel->getActiveSheet()->getStyle(getColumnName($j).'1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);		
	}

	$i = 1;	
	foreach ($_SESSION["objPHPExcel"] as &$fila) {
		$i=$i+1;
		for($j=1;$j<=$nroCol;$j=$j+1){			
			//$objPHPExcel->setActiveSheetIndex(0)->setCellValue(getColumnName($j).''.$i, $fila[$j-1]);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(getColumnName($j).''.$i, str_replace(".","",$fila[$j-1]));	
			$objPHPExcel->getActiveSheet()->getStyle(getColumnName($j).''.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle(getColumnName($j).''.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);	
			$objPHPExcel->getActiveSheet()->getStyle(getColumnName($j).''.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);	
			$objPHPExcel->getActiveSheet()->getStyle(getColumnName($j).''.$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);	
		}	
		if($i == 1400 + 1){
			$objPHPExcel->getActiveSheet()->getStyle('A'.($i+2).':T'.($i+3))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFA5D4FA');
			$objPHPExcel->getActiveSheet()->getStyle('A'.($i+2).':T'.($i+3))->getFont()->setBold(true);
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+2), "Se supero el numero maximo de filas a obtener en excel. Se obtuvieron en excel los primeros ".($i-1)." registros encontrados.");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+3), "Coloque mas filtros a la busqueda para poder observar todos los registros en excel.");
			break;
		}
	}
	
	if($_SESSION["isSumPHPExcel"] == '1'){
		$i=$i+1;
		//$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.getColumnName($nroCol).''.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFA5D4FA');	
		$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.getColumnName($nroCol).''.$i)->getFont()->setBold(true);
		for($j=1;$j<=$nroCol;$j=$j+1){		
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(getColumnName($j).''.$i, str_replace(".","",$_SESSION["sumPHPExcel"][$j]));
			$objPHPExcel->getActiveSheet()->getStyle(getColumnName($j).''.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle(getColumnName($j).''.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);	
			$objPHPExcel->getActiveSheet()->getStyle(getColumnName($j).''.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);	
			$objPHPExcel->getActiveSheet()->getStyle(getColumnName($j).''.$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);		
		}
	}
	// Rename sheet
	$objPHPExcel->getActiveSheet()->setTitle('Reporte');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
  
  
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
  $objWriter->save('reporte.xls');	
  $output->script("window.location = 'reporte.xls';");
  
	return $output;
}


function registrarVuelo($tipoVlo , $pNroVlo, $pHoraVlo){
	$output = new xajaxResponse();	

	$sql  = @getSql("insertVuelo", $tipoVlo , $pNroVlo, $pHoraVlo);
	
	$r = modifyDB($sql);	
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');		
		$output->script("mostrarMsg('errorVueloNoGuardado','$pNroVlo. $msg');");	
	}else{
		$output->script("mostrarMsg('infoVueloGuardado','$pNroVlo');");
		$output->script(" 	document.formTablaVuelos.btnIngresarTabla.disabled=''; 
							document.formTablaVuelos.btnGuardarTabla.disabled='disabled';
							document.formTablaVuelos.btnConsultarVuelo.disabled='';
							document.formTablaVuelos.btnActualizarTabla.disabled='disabled'; 
							iniCancelarVuelo();");
    resetQueriesVuelos();
	}
		
	return $output;
}

function cancelarRango($tipo, $desde, $hasta){
	$i = $desde;
	$ban = true;
	while (($i <= $hasta)&&($ban == true)){
		$sql  = @getSql("deleteConsecutivo", $tipo, $i);	
		$r = modifyDB($sql);
		if ($r <= 0){
			$ban = false;
			break;
		}
		$i++;
	}
	
	if($ban == false){
		return $i;
	}else{
		return $hasta;
	}	
	
}

function ingresarRango($tipo, $estado, $desde, $hasta){
	$i = $desde;
	$ban = true;
	
	$res = array();
	$sql  = @getSql("queryRangoConsecutivo", getTipoGral($tipo), $desde , $hasta);	
	$res = queryDB($sql);
	$j = 0;
	foreach ($res as &$fila) {	
		$j = 1;
	}

	if ($j == 1){
		return $hasta + 1;
	}
		
	while (($i <= $hasta)&&($ban == true)){
		$sql  = @getSql("insertConsecutivo", $tipo, $i , $estado);	
		$r = modifyDB($sql);
		if ($r <= 0){
			$ban = false;
			break;
		}
		$i++;
	}
	
	if($ban == false){
		return $i-1;
	}else{
		return $hasta;
	}	
	
}

function registrarConsecutivo($tipo, $desde, $hasta){
	$output = new xajaxResponse();	
	
	$r = ingresarRango($tipo, 'DIS', $desde, $hasta);	
	
	if ($r == $hasta + 1){
		$msg = getMsgCaractEsp(getErrorDB(),'si');		
		$output->script("mostrarMsg('errorRangoExiste','.','errorRangoNoGuardado');");			
	}
	else{
		if ($r != $hasta){
			cancelarRango($tipo, $desde, $r);
			$r++;
			$msg = getMsgCaractEsp(getErrorDB(),'si');		
			$output->script("mostrarMsg('errorConsecutivoNoGuardado','$r.','errorRangoNoGuardado');");	
		}else{
			$output->script("mostrarMsg('infoRangoGuardado','$tipo ($desde-$hasta)');");
			$output->script(" 	document.formTablaConsecutivos.btnIngresarTabla.disabled=''; 
								document.formTablaConsecutivos.btnGuardarTabla.disabled='disabled';
								document.formTablaConsecutivos.btnConsultarConsecutivo.disabled='';
								document.formTablaConsecutivos.btnActualizarTabla.disabled='disabled'; 
								iniCancelarConsecutivo();");	
		}
	}
	
	return $output;
}



function retirarVuelo($pTipoVlo, $pNroVlo){
	$output = new xajaxResponse();
	$sql  = @getSql("deleteVuelo", $pTipoVlo, $pNroVlo );
	
	$r = modifyDB($sql);	
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorVueloNoEliminado','$pNroVlo. $msg');");	
	}else{
		$output->script("mostrarMsg('infoVueloEliminado','$pNroVlo');");
		$output->script(" 	document.formTablaNacionalidades.btnIngresarTabla.disabled=''; 
							document.formTablaNacionalidades.btnGuardarTabla.disabled='disabled';
							document.formTablaNacionalidades.btnConsultarVuelo.disabled='';
							document.formTablaNacionalidades.btnActualizarTabla.disabled='disabled'; 
							document.formTablaNacionalidades.btnRetirarTabla.disabled='disabled'; 
							desactivarTablaVuelos(); ");
    resetQueriesVuelos();
	}
	
	return $output;
}

function llenarTablaVuelos($pTipoVlo, $pNroVlo) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();	
	
	$res = array();
	$sql  = @getSql("queryVuelo",$pTipoVlo , $pNroVlo);
	$res = queryDB($sql);
	
	$output->script("activarTablaVuelos();");
	
	$i = 0;
	foreach ($res as &$fila) {			
		$i = 1;
		$output->assign("nroVlo","value", "$fila[1]");
		$output->assign("selTipoVlo","value", "$fila[0]");
		$output->assign("horaVlo","value", "$fila[2]");
	}
	
	if($i == 1){
		$output->script("resultadoBox = '1'; desactivarObj('selTipoVlo'); desactivarObj('nroVlo'); desactivarObj('horaVlo');");		
	}else{
		$output->script("resultadoBox = '0'; desactivarTablaVuelos();");	
	}
	
	$output->script("$.fn.colorbox.close();");
	
	return $output; 
}

function llenarTablaVuelosSearch($pTipoVlo, $pNroVlo){ 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();	
	$res = array();
		
	if($pNroVlo == ''){
		$sql  = @getSql("queryVuelosSearch2",$pTipoVlo);	
		$res = queryDB($sql,"queryVuelosSearch2$pTipoVlo");
	}else{
		$sql  = @getSql("queryVuelosSearch1",$pTipoVlo, $pNroVlo );	
		$res = queryDB($sql);
	}	
	
	$output->assign("resVlo0","style.display", "");		
	
	$i = 0;
	foreach ($res as &$fila) {
		$i = $i+1;
		$output->assign("resVlo$i","style.display", "");		
		$output->assign("selTipoVlo$i","value", "$fila[0]");	
		$output->assign("nroVlo$i","value", "$fila[1]");
		$output->assign("horaVlo$i","value", "$fila[2]");
		$output->assign("imgVer$i","style.display", "");
		
	}	

	if($i > 0){
		$output->script("document.getElementById('labelResulConsultaVuelo').innerHTML=getValueXML('formConsultaVuelo','labelResulConsultaVueloTrue');");
	}else{
		$output->assign("resVlo0","style.display", "none");
		$output->script("document.getElementById('labelResulConsultaVuelo').innerHTML=getValueXML('formConsultaVuelo','labelResulConsultaVueloFalse');");
	}

	for($j=$i+1;$j<=50;$j=$j+1){
		$output->assign("resVlo$j","style.display", "none");		
	}	

	return $output; 
} 

function cargarSelNroVlo($pTipo) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();	
	
	if(getTipoGral($pTipo) == 'IN'){
		$pTipo = 'IN';
	}
	if(getTipoGral($pTipo) == 'OUT'){
		$pTipo = 'OUT';
	}
	
	$output->script("mis_options=eval('optVlo$pTipo');");
	$output->script("num_options = mis_options.length;");
	$output->script("document.formTablaTransfer.selNroVlo.length = num_options;");
	$output->script("for(i=0;i<num_options;i++){
						document.formTablaTransfer.selNroVlo.options[i] = mis_options[i]; 
					}
					");	
	$output->script("document.formTablaTransfer.selNroVlo.value = '<NULL>';");
	
	//$output->script("alert('new Array(new Option(\"----\",\"<NULL>\")".$textoVlo.")');");

	return $output; 
}

function llenarTablaConsecutivosSearch($pTipo , $pDesde, $pHasta, $pEstado) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();	
	
	$res = array();
	
	if($pEstado == '<NULL>')
		$sql  = @getSql("queryConsecutivosSearch1",$pTipo , $pDesde, $pHasta);
	else
		$sql  = @getSql("queryConsecutivosSearch2",$pTipo , $pDesde, $pHasta, $pEstado);
		
	$res = queryDB($sql);
	
	$output->assign("resConsecutivo0","style.display", "");		
	$output->script("document.formConsultaConsecutivo.miCheckAll.checked = false;");
	$i = 0;
	foreach ($res as &$fila) {
		$i = $i+1;
		$output->assign("resConsecutivo$i","style.display", "");
		
		$output->assign("tipoConsec$i","value", "$fila[0]");
		$output->assign("numConsec$i","value", "$fila[1]");
		$output->assign("estadoConsec$i","value", "$fila[2]");
		$output->script("document.formConsultaConsecutivo.miCheck$i.checked = false;");
		if($fila[2] != 'DIS'){
			$output->assign("miCheck$i","style.display", "none");
			$output->assign("imgVer$i","style.display", "none");
		} else{
			$output->assign("miCheck$i","style.display", "");
			$output->assign("imgVer$i","style.display", "");
		}		
		
	}	

	if($i > 0){
		$output->script("document.getElementById('labelResulConsultaConsecutivo').innerHTML=getValueXML('formConsultaConsecutivo','labelResulConsultaConsecutivoTrue');");
		$output->assign("btnBorrarConsecutivos","style.display", "");		
	}else{
		$output->assign("btnBorrarConsecutivos","style.display", "none");
		$output->assign("resConsecutivo0","style.display", "none");
		$output->script("document.getElementById('labelResulConsultaConsecutivo').innerHTML=getValueXML('formConsultaConsecutivo','labelResulConsultaConsecutivoFalse');");
	}

	for($j=$i+1;$j<=50;$j=$j+1){
		$output->script("document.formConsultaConsecutivo.miCheck$j.checked = false;");
		$output->assign("miCheck$j","style.display", "none");
		$output->assign("resConsecutivo$j","style.display", "none");		
	}	

	return $output; 
}

$itemsConsecutivos = array();

function getItemC($it){
	global $itemsConsecutivos;
	return $itemsConsecutivos[$it][1];
}

function getConsec($it){
	global $itemsConsecutivos;
	return $itemsConsecutivos[$it][2];
}

function getConsecutivosSelec($pqConsecutivos){
	global $itemsConsecutivos;
	$itemsConsecutivos = array();	
	$filaConsec = explode("/;/",$pqConsecutivos,-1);	
	for($i=0;$i<=count($filaConsec)-1;$i++){
		//$itemsConsecutivos[$i+1] = $filaConsec[$i];		
		$datoConsec = explode("/,/",$filaConsec[$i],-1);
		$itemsConsecutivos[$i+1][1] = $datoConsec[0];
		$itemsConsecutivos[$i+1][2] = $datoConsec[1];
	}
}


function borrarConsecutivo(&$output, $tipo, $it, $val){
	$sql  = @getSql("deleteConsecutivoLib", $tipo, $val);
	$r = modifyDB($sql);
	if ($r <= 0){
		$output->script("mostrarMsg('errorNoBorradoConsecutivo',$val');");
	} else{
		$output->script("document.formConsultaConsecutivo.miCheck$it.checked = false;");
		$output->assign("miCheck$it","style.display", "none");
		$output->assign("resConsecutivo$it","style.display", "none");		
	}	
}


function borrarConsecutivoUnit($pTipo, $it, $val){
	$output = new xajaxResponse();
	borrarConsecutivo($output, $pTipo, $it, $val);
	return $output; 
}


function borrarConsecutivosSelec($pConsecutivos, $pTipo){
	global $itemsConsecutivos;
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();
	getConsecutivosSelec($pConsecutivos);	
	for($i=1;$i<=count($itemsConsecutivos);$i++){
		$it = getItemC($i);
		$val = getConsec($i);
		//$output->script("alert('$it - $val');");
		borrarConsecutivo($output, $pTipo, $it, $val);
	}
	$output->script("document.formConsultaConsecutivo.miCheckAll.checked = false;");
	return $output; 
}

function isRegistroLog($pTipo, $pTabla){
	$res = array();
	$sql  = @getSql("queryRegistroLog",$pTipo.$pTabla);
	$res = queryDB($sql);
	
	$i = 0;
	foreach ($res as &$fila) {			
		$i = 1;
	}

	if($i == 1){
		return true;	
	}else{
		return false;	
	}	
}

function registrarLogDB($pTipo, $pTabla, $pNum, $pDesc){
	if(isRegistroLog($pTipo, $pTabla) == true){
		$fecha = getFechayyyymmddhhmm();
		$fecha = getFechaDB($fecha);
		$codUsr = $_SESSION["user"];
		
		if($pNum == '')
			$pNum = 'NULL';
		else
			$pNum = "'".$pNum."'";
		
		$sql  = @getSql("insertLog", $fecha, $codUsr , $pTipo, $pTabla, $pNum, $pDesc, $_SESSION['oficina']);	
		$r = modifyDB($sql);		
		if ($r <= 0){
			return false;	
		}else{
			return true;
		}
	}else{
		return true;
	}
}

function cargarSelProveedor($pCodSer) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();	
	
	$res = array();
	$texto ='';
	$res = getOpcionesProveedorXServ($pCodSer);
	foreach ($res as &$fila) {
		$texto = $texto.", new Option(\"".$fila[1]."\",\"".$fila[0]."\")";
	}
	
	$output->script("var optProv=new Array(new Option('- Seleccione -','<NULL>')".$texto.");");
	
	$output->script("mis_options=eval('optProv');");
	$output->script("num_options = mis_options.length;");
	$output->script("document.formRegistrarTour.selProv.length = num_options;");
	$output->script("for(i=0;i<num_options;i++){
						document.formRegistrarTour.selProv.options[i] = mis_options[i]; 
					}
					");	
	$output->script("document.formRegistrarTour.selProv.value = '<NULL>';");
	
	
	$res = array();
	$lugar ='';
	$sql  = @getSql("queryServicio",$pCodSer);
	$res = queryDB($sql);
	foreach ($res as &$fila) {
		$lugar = $fila[4];
	}
	$output->script("document.formRegistrarTour.lugar.value = '$lugar';");
	
	return $output; 
}

function cargarCampoCupos($pCodPro) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();	

	$res = array();
	$cupos = '';
	$sql  = @getSql("queryProveedor",$pCodPro);
	$res = queryDB($sql);
	foreach ($res as &$fila) {
		$cupos = $fila[7];
	}
	
	$output->script("activarObj('cupos'); document.formRegistrarTour.cupos.value = '$cupos';");
	
	return $output; 
}

function getOpcionesFechaTourXServ($pCodSer, $oficina){	
	$hoy = getFechaHoy();
	$hoy = getFechaDB($hoy);
	$res = array();
	$sql  = @getSql("queryListaTours", $pCodSer, $hoy, $oficina);
	$res = queryDB($sql);
	return $res;
}

function cargarSelFechaTour($numRes, $resRes, $pCodSer){ 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();	
	$res = array();
	$texto ='';
	$res = getOpcionesFechaTourXServ($pCodSer, $_SESSION["oficina"]);
	foreach ($res as &$fila) {
		$texto = $texto.", new Option(\"".$fila[1]."\",\"".$fila[0]."\")";
	}

	$opcDefault = "new Option('- Seleccione -','<NULL>')";
  if($texto == ''){
    $opcDefault = "new Option('','<NULL>')";
  }
  
	$output->script("var optTour=new Array({$opcDefault}".$texto.");");
  
	$output->script("mis_options=eval('optTour');");
	$output->script("num_options = mis_options.length;");
	$output->script("document.formRegistrarVentaTour.selFechaTour.length = num_options;");
	$output->script("for(i=0;i<num_options;i++){
						document.formRegistrarVentaTour.selFechaTour.options[i] = mis_options[i]; 
					}
					");	
	$output->script("document.formRegistrarVentaTour.selFechaTour.value = '<NULL>';");
	$output->script("document.formRegistrarVentaTour.lugar.value = '';");
	
	if($texto != ''){
		$res = array();
		$sql  = @getSql("queryNumPaxFaltaTour", $numRes, $resRes, $pCodSer);
		$res = queryDB($sql);
		$num = '0';
		foreach ($res as &$fila) {
			$num = $fila[0];
		}
		$output->script("document.formRegistrarVentaTour.numPax.value = '$num';");
		$output->script("document.formRegistrarVentaTour.numPax2.value = '0';");

		// Obtener precios por default del servicio
		$res = array();
		$sql  = @getSql("queryServicio", $pCodSer);
		$res = queryDB($sql);
		$precioAdu = '';
		$precioInf = '';
		foreach ($res as &$fila) {
			$precioAdu = $fila[5];
			$precioInf = $fila[6];
		}
		$output->script("document.formRegistrarVentaTour.precXPax.value = '$precioAdu';");
		$output->script("document.formRegistrarVentaTour.precXPax2.value = '$precioInf';");
	}
	
	return $output; 
}

function cargarSelFechaTour3($pCodSer) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();	
	$res = array();
	$texto ='';
	$res = getOpcionesFechaTourXServ($pCodSer, $_SESSION["oficina"]);
	foreach ($res as &$fila) {
		$texto = $texto.", new Option(\"".$fila[1]."\",\"".$fila[0]."\")";
	}
	$output->script("var optTour=new Array(new Option('- Seleccione -','<NULL>')".$texto.");");
	
	$output->script("mis_options=eval('optTour');");
	$output->script("num_options = mis_options.length;");
	$output->script("document.formRegistrarVentaTour.selFechaTour.length = num_options;");
	$output->script("for(i=0;i<num_options;i++){
						document.formRegistrarVentaTour.selFechaTour.options[i] = mis_options[i]; 
					}
					");	
	$output->script("document.formRegistrarVentaTour.selFechaTour.value = '<NULL>';");
	$output->script("document.formRegistrarVentaTour.lugar.value = '';");

	// Obtener precios por default del servicio
	$res = array();
	$sql  = @getSql("queryServicio", $pCodSer);
	$res = queryDB($sql);
	$precioAdu = '';
	$precioInf = '';
	foreach ($res as &$fila) {
		$precioAdu = $fila[5];
		$precioInf = $fila[6];
	}
	$output->script("document.formRegistrarVentaTour.precXPax.value = '$precioAdu';");
	$output->script("document.formRegistrarVentaTour.precXPax2.value = '$precioInf';");
	
	return $output; 
}

function cargarSelFechaTour2($pCodSer) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();	
		
	$res = array();
	$texto ='';
	$res = getOpcionesFechaTourXServ($pCodSer, $_SESSION["oficina"]);
	
	foreach ($res as &$fila) {
		$texto = $texto.", new Option(\"".$fila[1]."\",\"".$fila[0]."\")";
	}
	
	$output->script("var optTour=new Array(new Option('- Seleccione -','<NULL>')".$texto.");");
	
	$output->script("mis_options=eval('optTour');");
	$output->script("num_options = mis_options.length;");
	$output->script("document.formAnularTour.selFechaTour.length = num_options;");
	$output->script("for(i=0;i<num_options;i++){
						document.formAnularTour.selFechaTour.options[i] = mis_options[i]; 
					}
					");	
	$output->script("document.formAnularTour.selFechaTour.value = '<NULL>';");
	$output->script("document.formAnularTour.selNomPax.value = '<NULL>';");
	$output->script("document.getElementById('labelNumpax').innerHTML = '';");

	return $output; 
}

function cargarSelFechaTour4($pCodSer, $oficina) { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();	
		
	$res = array();
	$texto ='';
	$res = getOpcionesFechaTourXServ($pCodSer, $oficina);
	
	foreach ($res as &$fila) {
		$texto = $texto.", new Option(\"".$fila[1]."\",\"".$fila[0]."\")";
	}
	
	$output->script("var optTour=new Array(new Option('- Seleccione -','<NULL>')".$texto.");");
	
	$output->script("mis_options=eval('optTour');");
	$output->script("num_options = mis_options.length;");
	$output->script("document.formAnularTour.selFechaTour.length = num_options;");
	$output->script("for(i=0;i<num_options;i++){
						document.formAnularTour.selFechaTour.options[i] = mis_options[i]; 
					}
					");	
	$output->script("document.formAnularTour.selFechaTour.value = '<NULL>';");
	$output->script("document.getElementById('labelCuposCreados').innerHTML = '';");
	$output->script("document.getElementById('labelCuposConfirmados').innerHTML = '';");

	return $output; 
}

function cargarCampoSelNomPax($pCodTour) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();	
	
	$res = array();
	$sql  = @getSql("queryPasajerosTour", $pCodTour, $_SESSION["oficina"]);
	$res = queryDB($sql);
	
  $texto = "";
	foreach ($res as &$fila) {
		$texto = $texto.", new Option(\"".$fila[1]."\",\"".$fila[0]."\")";
	}
	
	$output->script("var optTour=new Array(new Option('- Seleccione -','<NULL>')".$texto.");");
	
	$output->script("mis_options=eval('optTour');");
	$output->script("num_options = mis_options.length;");
	$output->script("document.formAnularTour.selNomPax.length = num_options;");
	$output->script("for(i=0;i<num_options;i++){
						document.formAnularTour.selNomPax.options[i] = mis_options[i]; 
					}
					");	
	$output->script("document.formAnularTour.selNomPax.value = '<NULL>';");
	$output->script("document.getElementById('labelNumpax').innerHTML = '';");
	
	return $output; 
}

function cargarCampoNumPax($pCodVou){
	$output = new xajaxResponse();	
	$res = array();
	$sql  = @getSql("queryPaxTour", $pCodVou);
	$res = queryDB($sql);
	$numPax = '';
	foreach ($res as &$fila) {
		$numPax = $fila[2];
	}
	
	$output->script("document.getElementById('labelNumpax').innerHTML = '$numPax';");
	
	return $output; 
}

function preCancelarAsistenciaTour($numVou){
	$output = new xajaxResponse();	
  
	$res = array();
	$sql  = @getSql("queryInfoVoucher", $numVou, $_SESSION['oficina']);
	$res = queryDB($sql);
	foreach ($res as &$fila) {
		$numVouStr = $fila[0];
		$nomPax = $fila[2];
		$nomSer = $fila[5];
	}

  $output->script("var answer = confirm('Esta seguro de anular el voucher {$numVouStr} de {$nomSer} para el pasajero {$nomPax} ?');
                  if (answer == true){
                    xajax_cancelarAsistenciaTour('{$numVou}');
                  }
                  else{
                    mostrarMsg('anulaTourCancelado');
                  }");
		
	return $output;
}

function cancelarAsistenciaTour($numVou){
	$output = new xajaxResponse();	
	$sql  = @getSql("updateBorradaVou",$numVou, $_SESSION['oficina']);							
	$r = modifyDB($sql);

	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorAnulaTourNoGuardado','$msg');");						
	}else{
		$output->script("limpiarAnularTour();");		
		$output->script("mostrarMsg('infoAnulaTourGuardado', '{$_SESSION['oficina']}-$numVou');");		
		registrarLogDB('ANU', 'TOUR', $numVou, "Anular Tour. Voucher # {$_SESSION['oficina']}-".$numVou);	
	}	
		
	return $output;
}

function cancelarProgramacionTour($pCodTour, $oficina){
	$output = new xajaxResponse();	
	$sql  = @getSql("updateBorradaTour",$pCodTour, $oficina);							
	$r = modifyDB($sql);

	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorAnulaProgTourNoGuardado','$msg');");						
	}else{
		$output->script("limpiarAnularTour();");		
		$output->script("mostrarMsg('infoAnulaProgTourGuardado', '$pCodTour');");		
		registrarLogDB('ANU', 'TOUR', '0', "Anular Programacion Tour: ".$pCodTour);	
	}	
		
	return $output;
}

function getCuposOcuTour($pCodTour){
	$cupos = '0';
	$res = array();
	$sql  = @getSql("queryCuposOcuTour", $pCodTour);
	$res = queryDB($sql);
	foreach ($res as &$fila) {
		$cupos = $fila[0];
	}
	return $cupos;
}

function getCuposDispTour($pCodTour){
	$cuposOcu = '0';
	$cuposOcu = getCuposOcuTour($pCodTour);
	
	$res = array();
	$sql  = @getSql("queryTourXCod", $pCodTour);
	$res = queryDB($sql);
	$cupos = '-99';
	foreach ($res as &$fila) {
		$cupos = $fila[6];
	}

	if($cupos == '0'){
		return '-1';
	}else{
		if($cupos == '-99'){
			return '-99';
		}else{
			$cupos = $cupos - $cuposOcu;
			return ''.$cupos;
		}	
	}
}

function cargarCampoCuposTour($pCodTour) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();	
		
	$cuposOcu = getCuposOcuTour($pCodTour);
	
	$res = array();
	$sql  = @getSql("queryTourXCod", $pCodTour);
	$res = queryDB($sql);
	$cupos = '-99';
	foreach ($res as &$fila) {
		$cupos = $fila[6];
	}
	
	if($cupos == '-1'){
		$cupos = 'Ilimitado';
	}
	
	$output->script("document.getElementById('labelCuposCreados').innerHTML = '$cupos';");
	$output->script("document.getElementById('labelCuposConfirmados').innerHTML = '$cuposOcu';");
	
	$output->script("if($cuposOcu != 0){ mostrarMsg('errorTourTieneCupos'); desactivarObj('btnAnular');} else{ activarObj('btnAnular'); }");
	
	return $output; 
}

function cargarLugarTour($pCodTour){
	$output = new xajaxResponse();	
	$res = array();
	$sql  = @getSql("queryTourXCod", $pCodTour);
	$res = queryDB($sql);
	$lugar = '';
	$codPro = '';
	$cupos = '';
	foreach ($res as &$fila) {
		$lugar = $fila[4];
		$codPro = $fila[5];
	}
	
	$res = array();
	$sql  = @getSql("queryProveedor", $codPro);
	$res = queryDB($sql);
	$nomPro = '';
	foreach ($res as &$fila) {
		$nomPro = $fila[1];
	}
	
	$cupos = getCuposDispTour($pCodTour);
	if($cupos == '-1'){
		$cupos = 'Ilimitado';
	}
	if($cupos == '-99'){
		$cupos = '0';		
	}

	if(($cupos == '0')&&($pCodTour != '<NULL>')){
		$output->script("mostrarMsg('errorNoCuposTour');");		
	}	
	
	$output->script("document.formRegistrarVentaTour.lugar.value = '$lugar';");
	$output->script("document.formRegistrarVentaTour.proveedor.value = '$nomPro';");
	$output->script("document.getElementById('labelCupos').innerHTML = '$cupos';");
	
	return $output; 
}  	

function cargarInfoContacto($pDocu){
	$output = new xajaxResponse();	
	$nombre = '';
	$celular = '';
	$email = '';
	$res = array();
	$sql  = @getSql("queryContacto", $pDocu);
	$res = queryDB($sql);
	
	foreach ($res as &$fila) {
		$nombre = $fila[0];
		$celular = $fila[1];
		$email = $fila[2];
	}
	
	$output->script("document.formRegistrarVentaTour.nomPax.value = '$nombre';");
	$output->script("document.formRegistrarVentaTour.celularPax.value = '$celular';");
	$output->script("document.formRegistrarVentaTour.emailPax.value = '$email';");
	
	return $output; 
}  	

function registrarVentaTour($docuPax, $nomPax, $selHotelPax, $cuarto,
							$selNacPax, $selTour, $selFechaTour, $obsPax,
							$numPaxTot, $precXPax, $total,
							$numPax1, $numPax2, $precXPax2, $celularPax, $emailPax){
	$output = new xajaxResponse();
	
	$codUsu = $_SESSION["user"];
	$fechaDigita = getFechaddmmyyyy();
	$hoy = getFechaHoy();
	$hoy = getFechaDB($hoy);
	
	obtenerNroVoucher();		
	$numVou = $_SESSION["numvou"];
	$output->script("sessionNumVou = '$numVou';");
	$output->assign("labelNumVou","innerHTML", "Voucher No. ".$_SESSION["oficina"]."-".$_SESSION["numvou"]);
	$output->assign("nroVou", "value", $_SESSION["oficina"]."-".$_SESSION["numvou"]);
	
	$cupos = getCuposDispTour($selFechaTour);
	if($cupos == '-1'){
		$cupos = $numPaxTot + '10';
	}
	if($cupos == '-99'){
		$cupos = '0';
	}	
	
	$r = 0;
	if($numPaxTot > $cupos){
		if($cupos == '0'){
			$output->script("mostrarMsg('errorNoCuposTour');");
		}else{
			$output->script("mostrarMsg('errorCupoTourSuperado1','$cupos','errorCupoTourSuperado2');");
		}		
		$r = -1;
	}else{
		$sql  = @getSql("insertServParticular", $numVou, $selFechaTour, $docuPax, $nomPax, 
												$selHotelPax, $cuarto, $selNacPax, $numPaxTot, 
												$precXPax, $total, $obsPax, $codUsu, $hoy, 'Particular', 
												$numPax1, $numPax2, $precXPax2, $_SESSION["oficina"]);			
		$r = modifyDB($sql);
	}
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorVentaTourNoGuardado','$msg');");						
	}else{
		// Se inserta en contacto la info del cliente
		if(($celularPax!='')||($emailPax!='')){
			$sql  = @getSql("insertContacto", $docuPax, $nomPax, $celularPax, $emailPax);
			$r = modifyDB($sql);
			if ($r <= 0){
				$sql  = @getSql("updateContacto", $docuPax, $nomPax, $celularPax, $emailPax);
				$r = modifyDB($sql);
			}
		}
		confirmarNroVoucher($numVou);		
		//obtenerNroVoucher();
		//$output->script("sessionNumVou = '".$_SESSION["numvou"]."';");		
		$output->script("document.formRegistrarVentaTour.fechaDigita.value = '$fechaDigita';");
		$output->script("desactivarTablaRegistrarVenta();");		
		$output->script("mostrarMsg('infoVentaTourGuardado', '{$_SESSION['oficina']}-{$numVou}');");		
		registrarLogDB('VEN', 'TOUR', $numVou, "Venta de Tour. Voucher # {$_SESSION['oficina']}-".$numVou);	
	}	
		
	return $output;
}

function getOpcionesPasajerosXRes($pNumRes){	
	$res = array();
	$sql  = @getSql("queryListaPaxServXRes", $pNumRes, $_SESSION["oficina"]);
	$res = queryDB($sql);
	return $res;
}

function getOpcionesPasajerosXDoc($pDoc){	
	$res = array();
	$sql  = @getSql("queryListaPaxServXDoc", $pDoc, $_SESSION["oficina"]);
	$res = queryDB($sql);
	return $res;
}

function cargarSelNombPax($pNumRes) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();	
		
	$res = array();
	$texto ='';
	$res = getOpcionesPasajerosXRes($pNumRes);
	
	foreach ($res as &$fila) {
		$texto = $texto.", new Option(\"".$fila[2]."\",\"".$fila[0]."-".$fila[1]."\")";
	}
	
	$opcDefault = "new Option('- Seleccione -','<NULL>')";
  if($texto == ''){
    $opcDefault = "new Option('','<NULL>')";
  }
  
	$output->script("var optPax=new Array({$opcDefault}".$texto.");");
	
	$output->script("mis_options=eval('optPax');");
	$output->script("num_options = mis_options.length;");
	$output->script("document.formRegistrarVentaTour.selNombPax.length = num_options;");
	$output->script("for(i=0;i<num_options;i++){
						document.formRegistrarVentaTour.selNombPax.options[i] = mis_options[i]; 
					}
					");	
	$output->script("document.formRegistrarVentaTour.selNombPax.value = '<NULL>';");
  
  if($texto == ''){
    $output->script("alert('Reserva no encontrada. O no tiene tours pendientes por confirmar.');");
  }
  
	return $output; 
}

function cargarSelNombPaxXDoc($pDoc) 
 { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();	
		
	$res = array();
	$texto ='';
	$res = getOpcionesPasajerosXDoc($pDoc);
	
	foreach ($res as &$fila) {
		$texto = $texto.", new Option(\"".$fila[2]."\",\"".$fila[0]."-".$fila[1]."\")";
	}
	
  $opcDefault = "new Option('- Seleccione -','<NULL>')";
  if($texto == ''){
    $opcDefault = "new Option('','<NULL>')";
  }
  
	$output->script("var optPax=new Array({$opcDefault}".$texto.");");
	
	$output->script("mis_options=eval('optPax');");
	$output->script("num_options = mis_options.length;");
	$output->script("document.formRegistrarVentaTour.selNombPax.length = num_options;");
	$output->script("for(i=0;i<num_options;i++){
						document.formRegistrarVentaTour.selNombPax.options[i] = mis_options[i]; 
					}
					");	
	$output->script("document.formRegistrarVentaTour.selNombPax.value = '<NULL>';");
  
  if($texto == ''){
    $output->script("alert('No hay una reserva con tours pendientes por confirmar asociada a este documento.');");
  }
  
	return $output; 
}

//registrarVentaTour(
function confirmarReservaTour($numResTot, $docuPax, $nomPax, $selHotelPax, $cuarto,
							$selNacPax, $selTour, $selFechaTour, $obsPax,
							$numPaxTot, $numRes, $resRes,
							$precXPax, $total,
							$numPax1, $numPax2, $precXPax2, $celularPax, $emailPax){
	$output = new xajaxResponse();
	$codUsu = $_SESSION["user"];
	$fechaDigita = getFechaddmmyyyy();
	$hoy = getFechaHoy();
	$hoy = getFechaDB($hoy);	
	
	obtenerNroVoucher();		
	$numVou = $_SESSION["numvou"];
	$output->script("sessionNumVou = '$numVou';");
	$output->assign("labelNumVou","innerHTML", "Voucher No. ".$_SESSION["oficina"]."-".$_SESSION["numvou"]);
	$output->assign("nroVou", "value", $_SESSION["oficina"]."-".$_SESSION["numvou"]);
	
	$cupos = getCuposDispTour($selFechaTour);
	if($cupos == '-1'){
		$cupos = $numPaxTot + '10';
	}
	if($cupos == '-99'){
		$cupos = '0';
	}	
	
	$r = 0;
	$numFaltan = '0';
	if($numPaxTot > $cupos){
		if($cupos == '0'){
			$output->script("mostrarMsg('errorNoCuposTour');");
		}else{
			$output->script("mostrarMsg('errorCupoTourSuperado1','$cupos','errorCupoTourSuperado2');");
		}		
		$r = -1;
	}else{
		/**********************/
		$res = array();
		$sql  = @getSql("queryNumPaxFaltaTour", $numRes, $resRes, $selTour);
		$res = queryDB($sql);
		
		foreach ($res as &$fila) {
			$numFaltan = $fila[0];
		}
		
		if($numPaxTot > $numFaltan){
			$output->script("mostrarMsg('errorTourConfirSuperado1','$numFaltan','errorTourConfirSuperado2');");
			$r = -1;
		}else{
			$sql  = @getSql("insertServParticular", $numVou, $selFechaTour, $numResTot, $nomPax, 
													$selHotelPax, $cuarto, $selNacPax, $numPaxTot, 
													$precXPax, $total, $obsPax, $codUsu, $hoy, 'Plan',
													$numPax1, $numPax2, $precXPax2, $_SESSION["oficina"]);			
			$r = modifyDB($sql);
		}
		/**********************/
	}
	
	if ($r <= 0){
		$msg = getMsgCaractEsp(getErrorDB(),'si');
		$output->script("mostrarMsg('errorVentaTourNoGuardado','$msg');");						
	}else{
		// Se inserta en contacto la info del cliente
		if(($celularPax!='')||($emailPax!='')){
			$sql  = @getSql("insertContacto", $docuPax, $nomPax, $celularPax, $emailPax);
			$r = modifyDB($sql);
			if ($r <= 0){
				$sql  = @getSql("updateContacto", $docuPax, $nomPax, $celularPax, $emailPax);
				$r = modifyDB($sql);
			}
		}
		
		if($numPaxTot == $numFaltan){
			$sql  = @getSql("updateConfirTourReserva", $numRes, $resRes, $selTour);			
			$r = modifyDB($sql);
		}
		confirmarNroVoucher($numVou);
		//obtenerNroVoucher();
		//$output->script("sessionNumVou = '".$_SESSION["numvou"]."';");		
		$output->script("document.formRegistrarVentaTour.fechaDigita.value = '$fechaDigita';");
		$output->script("desactivarTablaRegistrarVenta();");		
		$output->script("mostrarMsg('infoVentaTourGuardado', '{$_SESSION['oficina']}-{$numVou}');");		
		registrarLogDB('VEN', 'TOUR', $numVou, "Confirmar Tour. Voucher # {$_SESSION['oficina']}-".$numVou);	
	}	
		
	return $output;
}

function getOpcionesTourXPax($pNumRes, $pResRes){	
	$res = array();
	$sql  = @getSql("queryListaToursResXPax", $pNumRes, $pResRes);
	$res = queryDB($sql);
	return $res;
}

function cargarSelTour($pNumRes, $pResRes) { 
	// Debemos crear una respuesta a XAJAX para nuestra función de la siguiente manera.   
	$output = new xajaxResponse();	
  
	$codHot = '<NULL>';
	$codNac = '<NULL>';
	$numPax = '';	
	$codCli = '';
	$vou = '';
	$doc = '';
	
  $res = array();
	$sql  = @getSql("queryReservaXResRes", $pNumRes, $pResRes);
	$res = queryDB($sql);	
	
	foreach ($res as &$fila) {
		$codHot = $fila[6];
		$codNac = $fila[2];
		$numPax = $fila[3];
		$codCli = $fila[10];
		$vou = $fila[14];
		$doc = $fila[15];
	}	
	
	
	$celular = '';
	$email = '';
	
	if($doc == ''){
		$doc = $pNumRes."-".$pResRes;
	}

	$res = array();
	$sql  = @getSql("queryContacto", $doc);
	$res = queryDB($sql);
	foreach ($res as &$fila) {
		$celular = $fila[1];
		$email = $fila[2];
	}
  
  
  
	$res = array();
	$texto = '';
	$res = getOpcionesTourXPax($pNumRes, $pResRes);
	
	foreach ($res as &$fila) {
		if(($fila[0] != 'IN')&&($fila[0] != 'OUT')){
			$texto = $texto.", new Option(\"".$fila[1]."\",\"".$fila[0]."\")";
		}
	}
  
  $opcDefault = "new Option('- Seleccione -','<NULL>')";
  if($texto == ''){
    $opcDefault = "new Option('','<NULL>')";
  }
  
	$output->script("var optTour=new Array({$opcDefault}".$texto.");");
	
	$output->script("mis_options=eval('optTour');");
	$output->script("num_options = mis_options.length;");
	$output->script("document.formRegistrarVentaTour.selTour.length = num_options;");
	$output->script("for(i=0;i<num_options;i++){
						document.formRegistrarVentaTour.selTour.options[i] = mis_options[i]; 
					}
					");	
	$output->script("document.formRegistrarVentaTour.selTour.value = '<NULL>';");
	
	$output->script("document.formRegistrarVentaTour.selHotelPax.value = '$codHot';");
	$output->script("document.formRegistrarVentaTour.selNacPax.value = '$codNac';");
	$output->script("document.formRegistrarVentaTour.numPax.value = '$numPax';");
	$output->script("document.formRegistrarVentaTour.numPax2.value = '0';");
	$output->script("document.formRegistrarVentaTour.voucher.value = '$vou';");
	$output->script("document.formRegistrarVentaTour.codCli.value = '$codCli';");

	$output->script("document.formRegistrarVentaTour.docuPax.value = '$doc';");
	$output->script("document.formRegistrarVentaTour.celularPax.value = '$celular';");
	$output->script("document.formRegistrarVentaTour.emailPax.value = '$email';");
  
  if($texto == ''){
    $output->script("alert('Este pasajero no tiene reservado mas tours para confirmar.');");
  }
  
	return $output; 
}

function resetQueriesVuelos(){
  $_SESSION["queryVuelosSearch2IN"."Check"] = false;
  $_SESSION["queryVuelosSearch2OUT"."Check"] = false;
}

function resetQueriesHoteles(){
  $_SESSION["queryListaHoteles"."Check"] = false;
}

function resetQueriesProveedores(){
  $_SESSION["queryListaProveedores"."Check"] = false;
  $_SESSION["queryConteoProveedores"."Check"] = false;
}

function resetQueriesServicios(){
  $_SESSION["queryListaServicios"."Check"] = false;
  $_SESSION["queryConteoServicios"."Check"] = false;
  $_SESSION["queryListaPaquetes"."Check"] = false;
  $_SESSION["queryListaServicios2"."Check"] = false;
}

function resetQueriesUsuarios(){
  $_SESSION["queryListaUsuarios"."Check"] = false;
}

function resetQueriesNacionalidades(){
  $_SESSION["queryListaNacionalidades"."Check"] = false;
}

function resetQueriesClientes(){
  $_SESSION["queryListaClientes"."Check"] = false;
}

?>

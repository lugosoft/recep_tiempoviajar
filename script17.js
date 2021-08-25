var xmlDoc=null; 
var reservaModificar = '0';
var sessionNumRes = '0';
var sessionNumVou = '0';
var resModifyDB = 0;
var opcionBox = '';
var resultadoBox = '0';
var tabla = '';
var transferModificar = 0;
var fechaVlo = '';
var fechaVloLlega = new Array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
var fechaVloSale = new Array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
var titulosReporte = new Array();
var idReporte = '0';
var param1Reporte = '';
var param2Reporte = '';
var param3Reporte = '';
var param4Reporte = '';
var param5Reporte = '';
var param6Reporte = '';
var datosReservasInicial = '';
var datosServReservaInicial = '';
var sumCampo;
var arrSum = new Array('NO','NO','NO','NO','NO','NO','NO','NO','NO','NO','NO','NO','NO','NO','NO','NO','NO','NO','NO','NO');
var campos = new Array(21);
var chkSuma = 0;
var controlRep = 0;
var MAX_FILAS_REPORTE = 300;
var filasReporte = 0;

var res_datosReservas=null;
var res_datosServReserva=null;
var res_codAge=null;
var res_cantRes=null;

if (window.ActiveXObject) 
{	// code for IE 
	xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
	xmlDoc.async=false;
	xmlDoc.load(language); 
} 
else if (document.implementation.createDocument) 
{	// code for Firefox, Mozilla, Opera, etc.
	var xmlhttp = new window.XMLHttpRequest();
	xmlhttp.open("GET", language, false);
	xmlhttp.send(null);
	xmlDoc = xmlhttp.responseXML.documentElement;
} 
else 
{ 
	alert('Tu explorador no soporta script para lectura de archivos XML.');  
} 

function replaceAll( text, busca, reemplaza ){
  while (text.toString().indexOf(busca) != -1)
      text = text.toString().replace(busca,reemplaza);
  return text;
}


function getValueXML(raiz, etiqueta){
	var it = xmlDoc.getElementsByTagName(raiz)[0]; 
	var txt = it.getElementsByTagName(etiqueta)[0];
	var res = '<NULL>';
	try{
		res = txt.firstChild.data;
	} catch(e) {
		res = '<NULL>';
	}
	res = replaceAll(res,"a'",String.fromCharCode(225));
	res = replaceAll(res,"e'",String.fromCharCode(233));
	res = replaceAll(res,"i'",String.fromCharCode(237));
	res = replaceAll(res,"o'",String.fromCharCode(243));
	res = replaceAll(res,"u'",String.fromCharCode(250));
	
	res = replaceAll(res,"A'",String.fromCharCode(193));
	res = replaceAll(res,"E'",String.fromCharCode(201));
	res = replaceAll(res,"I'",String.fromCharCode(205));
	res = replaceAll(res,"O'",String.fromCharCode(211));
	res = replaceAll(res,"U'",String.fromCharCode(218));		
	
	res = replaceAll(res,"n'",String.fromCharCode(241));
	res = replaceAll(res,"N'",String.fromCharCode(209));	
	
	return res;		
}
	
function runSWF(archivo, ancho, alto, version, bgcolor, id, menu, FlashVars, quality, allowScriptAccess) 
{
	if(version!=""){
		var version_data=version;
	}else{
		var version_data="6,0,0,0";
	}
	if(menu!=""){
		menu_data=menu;
	}else{
		menu_data=false;
	}
	if(bgcolor!=""){
		var bgcolor_data=bgcolor;
	}else{
		var bgcolor_data="#FFFFFF";
	}
	if(id!=""){
		id_data=id;
	}else{
		id_data="flashMovie";
	}
	if(quality!=""){
		quality_data=quality;
	}else{
		quality_data="high";
	}
	if(allowScriptAccess!=""){
		allowScriptAccess_data=allowScriptAccess;
	}else{
		allowScriptAccess_data="always";
	}
	
	var quality="high";
	document.write('<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase= "http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version= '+version_data+'" width='+ancho+' height='+alto+' id='+id_data+'>\n');
	document.write('<param name="movie" value='+archivo+'>\n');
	document.write('<param name= "allowScriptAccess" value= '+allowScriptAccess_data+'>\n');
	document.write('<param name="quality" value='+quality_data+'>\n');
	document.write('<param name="FlashVars" value='+FlashVars+'>\n');
	document.write('<param name="bgcolor" value='+bgcolor_data+'>\n');
	document.write('<param name="menu" value='+menu_data+' >\n');
	document.write('<embed src='+archivo+' bgcolor='+bgcolor_data+' FlashVars='+FlashVars+' menu='+menu_data+' allowScriptAccess='+allowScriptAccess_data+' quality='+quality_data+' pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width='+ancho+' height='+alto+' swLiveConnect=true name='+id_data+'></embed>');
	document.write('</object>\n');
}

function mascaraFecha(caja,separador){
if(caja.valueAnt != caja.value){
	var val = caja.value;
	var longiIni = val.length;
	var val2 = '';
	var val3 = new Array();
	var val4 = '';
	
	// Defino patron para la fecha dd/mm/yyyy  
	var patron = new Array(2,2,4);

	val = val.split(separador);	
	longi = val.length;
	// Quito el separador 
	for(i=0;i<longi;i++){
		val2 = val2 + val[i];	
	}
	
	// Elimino los caracteres que no son n�meros
	for(i=0;i<val2.length;i++){
		l = val2.charAt(i);
		if(isNaN(l)){
			//l = new RegExp(l,'g');
			val2 = val2.replace(l,'');
		}
	}
	
	// Desarmo los componentes de la fecha y los guardo en val3	
	for(i=0;i<patron.length;i++){
		val3[i] = val2.substring(0,patron[i]);
		val2 = val2.substr(patron[i]);
	}
	
	// Armo la fecha con el separador en la variable val4
	for(i=0;i<val3.length;i++){
		if(i == 0)
			val4 = val3[i];
		else if(val3[i] != '')
				val4 = val4 + separador + val3[i];
	}
	
	// Asigno autom�ticamente el separador dependiendo de la longitud inicial 
	if((longiIni == 3)&&(val4.length == 2))
		val4 = val4+separador;
	if((longiIni == 6)&&(val4.length == 5))
		val4 = val4+separador;

	// Le asigno la fecha obtenida a la caja de texto
	caja.value = val4;
	caja.valueAnt = val4;	
	}
}

function mascaraHora(caja){
if(caja.valueAnt != caja.value){
	var val = caja.value;
	var longiIni = val.length;
	var val2 = '';
	var val3 = new Array();
	var val4 = '';
	var separador = ':';
	// Defino patron para la fecha dd/mm/yyyy  
	var patron = new Array(2,2);

	val = val.split(separador);	
	longi = val.length;
	// Quito el separador 
	for(i=0;i<longi;i++){
		val2 = val2 + val[i];	
	}
	
	// Elimino los caracteres que no son n�meros
	for(i=0;i<val2.length;i++){
		l = val2.charAt(i);
		if(isNaN(l)){
			//l = new RegExp(l,'g');
			val2 = val2.replace(l,'');
		}
	}
	
	// Desarmo los componentes de la fecha y los guardo en val3	
	for(i=0;i<patron.length;i++){
		val3[i] = val2.substring(0,patron[i]);
		val2 = val2.substr(patron[i]);
	}
	
	// Armo la fecha con el separador en la variable val4
	for(i=0;i<val3.length;i++){
		if(i == 0)
			val4 = val3[i];
		else if(val3[i] != '')
				val4 = val4 + separador + val3[i];
	}
	
	// Asigno autom�ticamente el separador dependiendo de la longitud inicial 
	if((longiIni == 3)&&(val4.length == 2))
		val4 = val4+separador;

	// Le asigno la fecha obtenida a la caja de texto
	caja.value = val4;
	caja.valueAnt = val4;	
	}
}

function getFechaInterfazToYYYY_MM_DD(pFecha){
	// Convierte la fecha en el formato de la interfaz dd/mm/yyyy al formato YYYY-MM-DD
	pFecha = pFecha.substring(6,10)+'-'+pFecha.substring(3,5)+'-'+pFecha.substring(0,2);
	return pFecha;
}

function getTipoGral(pTipo){
	if(pTipo.substring(0,2) == 'IN'){
		pTipo = 'IN';
	}
	if(pTipo.substring(0,3) == 'OUT'){
		pTipo = 'OUT';
	}
	return pTipo;
}
function pasarFoco(idObj){
	document.getElementById(idObj).focus();	
}

function pasarFocoOnEnter(e,idObj,idFoco){	
	if (((document.all)?e.keyCode:e.which)=="13"){	
		var cod = document.getElementById(idObj);
		if (cod.value.length >= 1){ 
			pasarFoco(idFoco);
		}
	}
}

function cargarSeleccionEnCaja(idSelec,idCaja,idFoco){
	var cod = document.getElementById(idSelec);
	document.getElementById(idCaja).value = cod.value;
	if(document.getElementById(idCaja).value == '<NULL>'){
		document.getElementById(idCaja).value = '';
		pasarFoco(idSelec);
	}else{
		pasarFoco(idFoco);
	}
}

function cargarDatoEnSelec(e,idCaja,idSelec,idFoco,msgError) {
	if (((document.all)?e.keyCode:e.which)=="13"){	
		var cod = document.getElementById(idCaja); 
		document.getElementById(idSelec).value = cod.value.toUpperCase();
		if((document.getElementById(idSelec).value != cod.value.toUpperCase())||(document.getElementById(idSelec).value == '<NULL>')){			
			document.getElementById(idSelec).value = '<NULL>';
			alert(getValueXML('mensajes',msgError));
			pasarFoco(idCaja);
		}else{
			pasarFoco(idFoco);
		}		
	}else{
		var cod2 = document.getElementById(idCaja); 
		document.getElementById(idSelec).value = cod2.value.toUpperCase();
		if(document.getElementById(idSelec).value != cod2.value.toUpperCase()){
			document.getElementById(idSelec).value = '<NULL>';	
		}
	}
}

function cargarTablaReservas(e) {
	if (((document.all)?e.keyCode:e.which)=="13"){
		cargarTablaRes();
	}
}

function cargarTablaRes(){
	res0.style['display'] = '';
	res1.style['display'] = '';
	var num = document.formReservas.cantRes.value;
	if(num > 20){
		alert('Error. No se permiten mas de 20 transfer en una misma reserva.');
	}else{
		xajax_cargarTablaReservas(document.formReservas.cantRes.value);
		pasarFoco(document.formReservas.docuPax1.id);
	}
}
/*
	1 - servicios
	2 - nompax
	3 - nac
	4 - numpax
	5 - fecLlega
	6 - fecSale
	7 - hotel
	8 - vlo llega
	9 - vlo sale
   10 - Obs
*/
function setServicioRes(itres,itser,dato)
{
	reservas[itres][1][itser][2]=dato; 
}

function getServicioRes(itres,itser)
{
	return reservas[itres][1][itser][2];
}

function setDocuPaxRes(itres,dato)
{
	reservas[itres][14]=dato;
}

function getDocuPaxRes(itres)
{
	return reservas[itres][14];
}

function setNomPaxRes(itres,dato)
{
	reservas[itres][2]=dato;
}

function getNomPaxRes(itres)
{
	return reservas[itres][2];
}

function setTelPaxRes(itres,dato)
{
	reservas[itres][13]=dato;
}

function getTelPaxRes(itres)
{
	return reservas[itres][13];
}

function setNacRes(itres,dato)
{
	reservas[itres][3]=dato;
}

function getNacRes(itres)
{
	return reservas[itres][3];
}

function setNumPaxRes(itres,dato)
{
	reservas[itres][4]=dato;
}

function getNumPaxRes(itres)
{
	return reservas[itres][4];
}

function setFecLlegaRes(itres,dato)
{
	reservas[itres][5]=dato;
}

function getFecLlegaRes(itres)
{
	return reservas[itres][5];
}

function setFecSaleRes(itres,dato)
{
	reservas[itres][6]=dato;
}

function getFecSaleRes(itres)
{
	return reservas[itres][6];
}

function setHotelRes(itres,dato)
{
	reservas[itres][7]=dato;
}

function getHotelRes(itres)
{
	return reservas[itres][7];
}

function setVloLlegaRes(itres,dato)
{
	reservas[itres][8]=dato;
}

function getVloLlegaRes(itres)
{
	return reservas[itres][8];
}

function setVloSaleRes(itres,dato)
{
	reservas[itres][9]=dato;
}

function getVloSaleRes(itres)
{
	return reservas[itres][9];
}

function setObservacionRes(itres,dato)
{
	reservas[itres][10]=dato;
}

function getObservacionRes(itres)
{
	return reservas[itres][10];
}

function setBorradaRes(itres,dato)
{
	reservas[itres][11]=dato;
}

function getBorradaRes(itres)
{
	return reservas[itres][11];
}

function setVoucher(itres,dato)
{
	reservas[itres][12]=dato;
}

function getVoucher(itres)
{
	return reservas[itres][12];
}

function setProveedorSer(itpro,dato)
{
	proveedores[itpro][2]=dato; 
}

function getProveedorSer(itpro)
{
	return proveedores[itpro][2];
}

function getProveedorCosSer(itpro)
{
	return proveedores[itpro][3];
}

function setProveedorCosSer(itpro,dato)
{
	proveedores[itpro][3]=dato; 
}


function iniIngresarReserva(){	
	xajax_iniIngresarReserva();
}

function iniCancelarReserva(){
	window.location = "?id=1";
}

// sleep time expects milliseconds
function sleepPrint (time) {
  return new Promise((resolve) => setTimeout(resolve, time));
}
    
function limpiarSelect(idSelect){
  var opc = new Array(new Option('','<NULL>')); 
  var mis_options = eval('opc');
  document.getElementById(idSelect).length = 1;
  document.getElementById(idSelect).options[0] = mis_options[0];
  document.getElementById(idSelect).value = '<NULL>';
}
    
function limpiarTablaAgencias(){
	document.formTablaAgencias.codAge.value = '';
	document.formTablaAgencias.selTipoAge.value = 'AG'; 
	document.formTablaAgencias.nomAge.value = ''; 
	document.formTablaAgencias.nitAge.value = ''; 
	document.formTablaAgencias.dirAge.value = ''; 
	document.formTablaAgencias.ciuAge.value = ''; 
	document.formTablaAgencias.tel1Age.value = ''; 
	document.formTablaAgencias.tel2Age.value = ''; 
	document.formTablaAgencias.celAge.value = ''; 
	document.formTablaAgencias.contacAge.value = '';
}

function activarTablaAgencias(){
	limpiarTablaAgencias();	
	activarObj('codAge');
	activarObj('selTipoAge');
	activarObj('nomAge');
	activarObj('nitAge');
	activarObj('dirAge');
	activarObj('ciuAge');
	activarObj('tel1Age');
	activarObj('tel2Age');
	activarObj('celAge');
	activarObj('contacAge');
}

function desactivarTablaAgencias(){
	limpiarTablaAgencias();	
	desactivarObj('codAge');
	desactivarObj('selTipoAge');
	desactivarObj('nomAge');
	desactivarObj('nitAge');
	desactivarObj('dirAge');
	desactivarObj('ciuAge');
	desactivarObj('tel1Age');
	desactivarObj('tel2Age');
	desactivarObj('celAge');
	desactivarObj('contacAge');
}

function iniIngresarAgencia(){
	document.formTablaAgencias.btnIngresarTabla.disabled='disabled';
	document.formTablaAgencias.btnGuardarTabla.disabled='';
	document.formTablaAgencias.btnConsultarAgencia.disabled='disabled';
	document.formTablaAgencias.btnActualizarTabla.disabled='disabled';
	document.formTablaAgencias.btnRetirarTabla.disabled='disabled';
	document.formTablaAgencias.btnCancelarTabla.disabled='';
	
	activarTablaAgencias();
	
	pasarFoco('codAge');

}

function iniCancelarAgencia(){
	desactivarTablaAgencias();	
	document.formTablaAgencias.btnIngresarTabla.disabled='';
	document.formTablaAgencias.btnGuardarTabla.disabled='disabled';
	document.formTablaAgencias.btnConsultarAgencia.disabled='';
	document.formTablaAgencias.btnActualizarTabla.disabled='disabled';
	document.formTablaAgencias.btnRetirarTabla.disabled='disabled';
	document.formTablaAgencias.btnCancelarTabla.disabled='';
}

function limpiarTablaServicios(){
	document.formTablaServicios.codSer.value = '';
	document.formTablaServicios.nomSer.value = ''; 
	document.formTablaServicios.selDefecto.value = 'NO'; 
	document.formTablaServicios.ordenSale.value = '';
	document.formTablaServicios.precXPaxAd.value = '';
	document.formTablaServicios.precXPaxIn.value = '';
}

function activarTablaServicios(){
	limpiarTablaServicios();	
	activarObj('codSer');
	activarObj('nomSer');
	activarObj('selDefecto');
	activarObj('ordenSale');
	activarObj('precXPaxAd');
	activarObj('precXPaxIn');
}

function desactivarTablaServicios(){
	limpiarTablaServicios();	
	desactivarObj('codSer');
	desactivarObj('nomSer');
	desactivarObj('selDefecto');
	desactivarObj('ordenSale');
	desactivarObj('precXPaxAd');
	desactivarObj('precXPaxIn');
}

function iniIngresarServicio(){	
	document.formTablaServicios.btnIngresarTabla.disabled='disabled';
	document.formTablaServicios.btnGuardarTabla.disabled='';
	document.formTablaServicios.btnConsultarServicio.disabled='disabled';
	document.formTablaServicios.btnActualizarTabla.disabled='disabled';
	document.formTablaServicios.btnRetirarTabla.disabled='disabled';
	document.formTablaServicios.btnCancelarTabla.disabled='';
		
	activarTablaServicios();
	
	pasarFoco('codSer');

}

function iniCancelarServicio(){
	desactivarTablaServicios();	
	document.formTablaServicios.btnIngresarTabla.disabled='';
	document.formTablaServicios.btnGuardarTabla.disabled='disabled';
	document.formTablaServicios.btnConsultarServicio.disabled='';
	document.formTablaServicios.btnActualizarTabla.disabled='disabled';
	document.formTablaServicios.btnRetirarTabla.disabled='disabled';
	document.formTablaServicios.btnCancelarTabla.disabled='';
}


function limpiarTablaHoteles(){
	document.formTablaHoteles.selTipoUbi.value = 'HOT';
	document.formTablaHoteles.codHot.value = ''; 
	document.formTablaHoteles.nomHot.value = ''; 
	document.formTablaHoteles.dirHot.value = ''; 
	document.formTablaHoteles.tel1Hot.value = ''; 
	document.formTablaHoteles.tel2Hot.value = ''; 
	document.formTablaHoteles.celHot.value = ''; 
	document.formTablaHoteles.conHot.value = '';
}

function activarTablaHoteles(){
	limpiarTablaHoteles();
	activarObj('selTipoUbi'); 
	activarObj('selOficina'); 
	activarObj('codHot'); 
	activarObj('nomHot'); 
	activarObj('dirHot'); 
	activarObj('tel1Hot'); 
	activarObj('tel2Hot'); 
	activarObj('celHot'); 
	activarObj('conHot');
}

function desactivarTablaHoteles(){
	limpiarTablaHoteles();
	desactivarObj('selTipoUbi'); 
	desactivarObj('selOficina'); 
	desactivarObj('codHot'); 
	desactivarObj('nomHot'); 
	desactivarObj('dirHot'); 
	desactivarObj('tel1Hot'); 
	desactivarObj('tel2Hot'); 
	desactivarObj('celHot'); 
	desactivarObj('conHot');	
}

function iniIngresarHotel(){	
	document.formTablaHoteles.btnIngresarTabla.disabled='disabled';
	document.formTablaHoteles.btnGuardarTabla.disabled='';
	document.formTablaHoteles.btnConsultarHotel.disabled='disabled';
	document.formTablaHoteles.btnActualizarTabla.disabled='disabled';
	document.formTablaHoteles.btnRetirarTabla.disabled='disabled';
	document.formTablaHoteles.btnCancelarTabla.disabled='';
		
	activarTablaHoteles();
	
	pasarFoco('codHot');
}

function iniCancelarHotel(){
	desactivarTablaHoteles();	
	document.formTablaHoteles.btnIngresarTabla.disabled='';
	document.formTablaHoteles.btnGuardarTabla.disabled='disabled';
	document.formTablaHoteles.btnConsultarHotel.disabled='';
	document.formTablaHoteles.btnActualizarTabla.disabled='disabled';
	document.formTablaHoteles.btnRetirarTabla.disabled='disabled';
	document.formTablaHoteles.btnCancelarTabla.disabled='';
}

function limpiarTablaUsuarios(){
	document.formTablaUsuarios.codUsr.value = ''; 
	document.formTablaUsuarios.clave.value = ''; 
	document.formTablaUsuarios.codRol.value = 'ASE'; 
	document.formTablaUsuarios.selCliente.value = '<NULL>'; 
	document.formTablaUsuarios.nombre.value = ''; 
	document.formTablaUsuarios.apellidos.value = ''; 
}

function activarTablaUsuarios(){
	limpiarTablaUsuarios();	
	activarObj('codUsr'); 
	activarObj('clave'); 
	activarObj('codRol');
	desactivarObj('selCliente');
	activarObj('nombre'); 
	activarObj('apellidos');
}

function desactivarTablaUsuarios(){
	limpiarTablaUsuarios();	
	desactivarObj('codUsr'); 
	desactivarObj('clave'); 
	desactivarObj('codRol'); 
	desactivarObj('selCliente'); 
	desactivarObj('nombre'); 
	desactivarObj('apellidos'); 	
}

function iniIngresarUsuario(){	
	document.formTablaUsuarios.btnIngresarTabla.disabled='disabled';
	document.formTablaUsuarios.btnGuardarTabla.disabled='';
	document.formTablaUsuarios.btnConsultarUsuario.disabled='disabled';
	document.formTablaUsuarios.btnActualizarTabla.disabled='disabled';
	document.formTablaUsuarios.btnRetirarTabla.disabled='disabled';
	document.formTablaUsuarios.btnCancelarTabla.disabled='';
		
	activarTablaUsuarios();
	
	pasarFoco('codUsr');
}

function iniCancelarUsuario(){
	desactivarTablaUsuarios();	
	document.formTablaUsuarios.btnIngresarTabla.disabled='';
	document.formTablaUsuarios.btnGuardarTabla.disabled='disabled';
	document.formTablaUsuarios.btnConsultarUsuario.disabled='';
	document.formTablaUsuarios.btnActualizarTabla.disabled='disabled';
	document.formTablaUsuarios.btnRetirarTabla.disabled='disabled';
	document.formTablaUsuarios.btnCancelarTabla.disabled='';
}

function limpiarTablaNacionalidades(){
	document.formTablaNacionalidades.codNac.value = ''; 
	document.formTablaNacionalidades.nacional.value = ''; 
}

function activarTablaNacionalidades(){
	limpiarTablaNacionalidades();
	activarObj('codNac'); 
	activarObj('nacional');
}

function desactivarTablaNacionalidades(){
	limpiarTablaNacionalidades();
	desactivarObj('codNac'); 
	desactivarObj('nacional');  	
}

function limpiarTablaConsecutivos(){
	document.formTablaConsecutivos.selTipoConsec.value = '<NULL>'; 
	document.formTablaConsecutivos.desde.value = ''; 
	document.formTablaConsecutivos.hasta.value = ''; 
}

function activarTablaConsecutivos(){
	limpiarTablaConsecutivos();
	activarObj('selTipoConsec');	
	activarObj('desde'); 
	activarObj('hasta');
}

function desactivarTablaConsecutivos(){
	limpiarTablaConsecutivos();
	desactivarObj('selTipoConsec');
	desactivarObj('desde'); 
	desactivarObj('hasta');  	
}

function iniIngresarNacionalidad(){	
	document.formTablaNacionalidades.btnIngresarTabla.disabled='disabled';
	document.formTablaNacionalidades.btnGuardarTabla.disabled='';
	document.formTablaNacionalidades.btnConsultarNacionalidad.disabled='disabled';
	document.formTablaNacionalidades.btnActualizarTabla.disabled='disabled';
	document.formTablaNacionalidades.btnRetirarTabla.disabled='disabled';
	document.formTablaNacionalidades.btnCancelarTabla.disabled='';
		
	activarTablaNacionalidades();
	
	pasarFoco('codNac');
}

function iniCancelarNacionalidad(){
	desactivarTablaNacionalidades();	
	document.formTablaNacionalidades.btnIngresarTabla.disabled='';
	document.formTablaNacionalidades.btnGuardarTabla.disabled='disabled';
	document.formTablaNacionalidades.btnConsultarNacionalidad.disabled='';
	document.formTablaNacionalidades.btnActualizarTabla.disabled='disabled';
	document.formTablaNacionalidades.btnRetirarTabla.disabled='disabled';
	document.formTablaNacionalidades.btnCancelarTabla.disabled='';
}

function limpiarTablaProveedores(){
	document.formTablaProveedores.codPro.value = ''; 
	document.formTablaProveedores.nomPro.value = ''; 
	document.formTablaProveedores.dirPro.value = ''; 
	document.formTablaProveedores.tel1Pro.value = ''; 
	document.formTablaProveedores.tel2Pro.value = ''; 
	document.formTablaProveedores.celPro.value = ''; 
	document.formTablaProveedores.conPro.value = '';
}

function activarTablaProveedores(){
	limpiarTablaProveedores();	
	activarObj('codPro'); 
	activarObj('nomPro'); 
	activarObj('dirPro'); 
	activarObj('tel1Pro'); 
	activarObj('tel2Pro'); 
	activarObj('celPro'); 
	activarObj('conPro');
}

function desactivarTablaProveedores(){
	limpiarTablaProveedores();	
	desactivarObj('codPro'); 
	desactivarObj('nomPro'); 
	desactivarObj('dirPro'); 
	desactivarObj('tel1Pro'); 
	desactivarObj('tel2Pro'); 
	desactivarObj('celPro'); 
	desactivarObj('conPro'); 	
}

function iniIngresarProveedor(){	
	document.formTablaProveedores.btnIngresarTabla.disabled='disabled';
	document.formTablaProveedores.btnGuardarTabla.disabled='';
	document.formTablaProveedores.btnConsultarProveedor.disabled='disabled';
	document.formTablaProveedores.btnActualizarTabla.disabled='disabled';
	document.formTablaProveedores.btnRetirarTabla.disabled='disabled';
	document.formTablaProveedores.btnCancelarTabla.disabled='';
		
	activarTablaProveedores();
	
	pasarFoco('codPro');
}

function iniCancelarProveedor(){
	desactivarTablaProveedores();	
	document.formTablaProveedores.btnIngresarTabla.disabled='';
	document.formTablaProveedores.btnGuardarTabla.disabled='disabled';
	document.formTablaProveedores.btnConsultarProveedor.disabled='';
	document.formTablaProveedores.btnActualizarTabla.disabled='disabled';
	document.formTablaProveedores.btnRetirarTabla.disabled='disabled';
	document.formTablaProveedores.btnCancelarTabla.disabled='';
}

function limpiarTablaPaquetes(){
	document.formTablaPaquetes.codPaq.value = ''; 
	document.formTablaPaquetes.nomPaq.value = ''; 
	document.formTablaPaquetes.desPaq.value = ''; 
}

function activarTablaPaquetes(){
	limpiarTablaPaquetes();	
	activarObj('codPaq'); 
	activarObj('nomPaq'); 
	activarObj('desPaq'); 
}

function desactivarTablaPaquetes(){
	limpiarTablaPaquetes();	
	desactivarObj('codPaq'); 
	desactivarObj('nomPaq'); 
	desactivarObj('desPaq');	
}

function iniIngresarPaquete(){	
	document.formTablaPaquetes.btnIngresarTabla.disabled='disabled';
	document.formTablaPaquetes.btnGuardarTabla.disabled='';
	document.formTablaPaquetes.btnConsultarPaquete.disabled='disabled';
	document.formTablaPaquetes.btnActualizarTabla.disabled='disabled';
	document.formTablaPaquetes.btnRetirarTabla.disabled='disabled';
	document.formTablaPaquetes.btnCancelarTabla.disabled='';
		
	activarTablaPaquetes();
	
	pasarFoco('codPaq');
}

function iniCancelarPaquete(){
	desactivarTablaPaquetes();	
	document.formTablaPaquetes.btnIngresarTabla.disabled='';
	document.formTablaPaquetes.btnGuardarTabla.disabled='disabled';
	document.formTablaPaquetes.btnConsultarPaquete.disabled='';
	document.formTablaPaquetes.btnActualizarTabla.disabled='disabled';
	document.formTablaPaquetes.btnRetirarTabla.disabled='disabled';
	document.formTablaPaquetes.btnCancelarTabla.disabled='';
}

function limpiarTablaVuelos(){
	document.formTablaVuelos.selTipoVlo.value = 'IN'; 
	document.formTablaVuelos.nroVlo.value = ''; 
	document.formTablaVuelos.horaVlo.value = '';
}

function activarTablaVuelos(){
	limpiarTablaVuelos();	
	activarObj('selTipoVlo');	
	activarObj('nroVlo');
	activarObj('horaVlo');
}

function desactivarTablaVuelos(){
	limpiarTablaVuelos();	
	desactivarObj('selTipoVlo');
	desactivarObj('nroVlo'); 
	desactivarObj('horaVlo'); 
}

function iniIngresarVuelo(){	
	document.formTablaVuelos.btnIngresarTabla.disabled='disabled';
	document.formTablaVuelos.btnGuardarTabla.disabled='';
	document.formTablaVuelos.btnConsultarVuelo.disabled='disabled';
	document.formTablaVuelos.btnActualizarTabla.disabled='disabled';
	document.formTablaVuelos.btnRetirarTabla.disabled='disabled';
	document.formTablaVuelos.btnCancelarTabla.disabled='';
		
	activarTablaVuelos();
	
	pasarFoco('selTipoVlo');
}

function iniIngresarConsecutivo(){	
	document.formTablaConsecutivos.btnIngresarTabla.disabled='disabled';
	document.formTablaConsecutivos.btnGuardarTabla.disabled='';
	document.formTablaConsecutivos.btnConsultarConsecutivo.disabled='disabled';
	document.formTablaConsecutivos.btnActualizarTabla.disabled='disabled';
	document.formTablaConsecutivos.btnRetirarTabla.disabled='disabled';
	document.formTablaConsecutivos.btnCancelarTabla.disabled='';
		
	activarTablaConsecutivos();
	
	pasarFoco('selTipoConsec');
}

function iniCancelarConsecutivo(){
	desactivarTablaConsecutivos();	
	document.formTablaConsecutivos.btnIngresarTabla.disabled='';
	document.formTablaConsecutivos.btnGuardarTabla.disabled='disabled';
	document.formTablaConsecutivos.btnConsultarConsecutivo.disabled='';
	document.formTablaConsecutivos.btnActualizarTabla.disabled='disabled';
	document.formTablaConsecutivos.btnRetirarTabla.disabled='disabled';
	document.formTablaConsecutivos.btnCancelarTabla.disabled='';
}

function iniCancelarVuelo(){
	desactivarTablaVuelos();	
	document.formTablaVuelos.btnIngresarTabla.disabled='';
	document.formTablaVuelos.btnGuardarTabla.disabled='disabled';
	document.formTablaVuelos.btnConsultarVuelo.disabled='';
	document.formTablaVuelos.btnActualizarTabla.disabled='disabled';
	document.formTablaVuelos.btnRetirarTabla.disabled='disabled';
	document.formTablaVuelos.btnCancelarTabla.disabled='';
}

function limpiarTablaTransfer(){
	document.formTablaTransfer.selCateTrans.value = '<NULL>';
	document.formTablaTransfer.horaVlo.value = '';
	document.formTablaTransfer.cantVou.value = '';
	document.formTablaTransfer.selNroVlo.value = '<NULL>';
	document.formTablaTransfer.cantPax.value = '';
	document.formTablaTransfer.nomPax.value = '';
	//document.formTablaTransfer.fecSerTrans.value = '';
	document.formTablaTransfer.valTrans.value = '';
	document.formTablaTransfer.placaTax.value = '';
	document.formTablaTransfer.conducTax.value = '';
	document.formTablaTransfer.docuTax.value = '';
	document.formTablaTransfer.obsTrans.value = '';
}

function mostrarTablaTransfer(){
	mostrarObj('selCateTrans');
	document.getElementById('labelSelCateTrans').innerHTML=getValueXML('formTablaTransfer','selCateTrans')+' ';
	
	mostrarObj('horaVlo');
	document.getElementById('labelHoraVlo').innerHTML=getValueXML('formTablaTransfer','horaVlo')+' ';
	
	mostrarObj('cantVou');
	document.getElementById('labelCantVou').innerHTML=getValueXML('formTablaTransfer','cantVou')+' ';
	
	mostrarObj('selNroVlo');
	document.getElementById('labelNroVlo').innerHTML=getValueXML('formTablaTransfer','selNroVlo')+' ';
	
	mostrarObj('cantPax');
	document.getElementById('labelCantPax').innerHTML=getValueXML('formTablaTransfer','cantPax')+' ';
	
	mostrarObj('nomPax');
	document.getElementById('labelNomPax').innerHTML=getValueXML('formTablaTransfer','nomPax')+' ';
	
	mostrarObj('fecSerTrans');
	document.getElementById('labelFecSerTrans').innerHTML=getValueXML('formTablaTransfer','fecSerTrans')+' ';
	mostrarObj('imgFecSer');
		
	mostrarObj('selOrigenTrans');
	activarObj('selOrigenTrans');
	document.getElementById('labelSelOrigenTrans').innerHTML=getValueXML('formTablaTransfer','selOrigenTrans')+' ';
	
	mostrarObj('selDestinoTrans1');
	activarObj('selDestinoTrans1');
	document.getElementById('labelSelDestinoTrans1').innerHTML=getValueXML('formTablaTransfer','selDestinoTrans1')+' ';
	
	mostrarObj('selDestinoTrans2');
	activarObj('selDestinoTrans2');
	document.getElementById('labelSelDestinoTrans2').innerHTML=getValueXML('formTablaTransfer','selDestinoTrans2')+' ';
	
	mostrarObj('valTrans');
	document.getElementById('labelValTrans').innerHTML=getValueXML('formTablaTransfer','valTrans')+' ';
	
	mostrarObj('placaTax');
	document.getElementById('labelPlacaTax').innerHTML=getValueXML('formTablaTransfer','placaTax')+' ';
	
	mostrarObj('conducTax');
	document.getElementById('labelConducTax').innerHTML=getValueXML('formTablaTransfer','conducTax')+' ';
	
	mostrarObj('docuTax');
	document.getElementById('labelDocuTax').innerHTML=getValueXML('formTablaTransfer','docuTax')+' ';
	
	mostrarObj('obsTrans');
	document.getElementById('labelObsTrans').innerHTML=getValueXML('formTablaTransfer','obsTrans')+' ';
}

function ocultarTablaTransfer(){
	ocultarObj('selCateTrans');
	document.getElementById('labelSelCateTrans').innerHTML='';
	
	ocultarObj('horaVlo');
	document.getElementById('labelHoraVlo').innerHTML='';
	
	ocultarObj('cantVou');
	document.getElementById('labelCantVou').innerHTML='';
	
	ocultarObj('selNroVlo');
	document.getElementById('labelNroVlo').innerHTML='';
	
	ocultarObj('cantPax');
	document.getElementById('labelCantPax').innerHTML='';
	
	ocultarObj('nomPax');
	document.getElementById('labelNomPax').innerHTML='';
	
	ocultarObj('fecSerTrans');
	document.getElementById('labelFecSerTrans').innerHTML='';
	ocultarObj('imgFecSer');
	
	ocultarObj('selOrigenTrans');
	document.getElementById('labelSelOrigenTrans').innerHTML='';
	
	ocultarObj('selDestinoTrans1');
	document.getElementById('labelSelDestinoTrans1').innerHTML='';
	
	ocultarObj('selDestinoTrans2');
	document.getElementById('labelSelDestinoTrans2').innerHTML='';
	
	ocultarObj('valTrans');
	document.getElementById('labelValTrans').innerHTML='';
	
	ocultarObj('placaTax');
	document.getElementById('labelPlacaTax').innerHTML='';
	
	ocultarObj('conducTax');
	document.getElementById('labelConducTax').innerHTML='';
	
	ocultarObj('docuTax');
	document.getElementById('labelDocuTax').innerHTML='';
	
	ocultarObj('obsTrans');
	document.getElementById('labelObsTrans').innerHTML='';
}

function cargarCamposTransfer(idSelec,idFoco,getNroTransfer){
	var cod = document.getElementById(idSelec);
	fechaVlo = '';
	if(cod.value == '<NULL>'){
		document.getElementById('labelOrdenTrans').innerHTML=' ';
		document.getElementById('ordenTrans').innerHTML='';
		ocultarTablaTransfer();		
	}else{
		if(getNroTransfer == true){
			xajax_selectTransfer(cod.value);
		}	
		mostrarTablaTransfer();
	}
	
	var mis_options;
	var num_options = 0;
	
	if((cod.value == 'IN NAC') || (cod.value == 'IN INT')){
		xajax_cargarSelNroVlo(cod.value);	
		document.getElementById('labelOrdenTrans').innerHTML=getValueXML('formTablaTransfer','labelOrdenTransIn')+' ';
		
		mis_options=eval('optIn_ori');
		num_options = mis_options.length;
		document.formTablaTransfer.selOrigenTrans.length = num_options; 
		for(i=0;i<num_options;i++){ 
			document.formTablaTransfer.selOrigenTrans.options[i] = mis_options[i];
		}

		mis_options=eval('optIn_des1');
		num_options = mis_options.length;
		document.formTablaTransfer.selDestinoTrans1.length = num_options; 
		for(i=0;i<num_options;i++){ 
			document.formTablaTransfer.selDestinoTrans1.options[i] = mis_options[i];
		}
		
		mis_options=eval('optIn_des2');
		num_options = mis_options.length;
		document.formTablaTransfer.selDestinoTrans2.length = num_options; 
		for(i=0;i<num_options;i++){ 
			document.formTablaTransfer.selDestinoTrans2.options[i] = mis_options[i];
		}
		
		document.formTablaTransfer.selOrigenTrans.value = 'ARP';
		desactivarObj('selOrigenTrans');		
		pasarFoco(idFoco);
	}else 
	if((cod.value == 'OUT AQU')||(cod.value == 'OUT MAR')||(cod.value == 'OUT MRL')||(cod.value == 'OUT DEL')||(cod.value == 'OUT DEC')){
		xajax_cargarSelNroVlo(cod.value);
		document.getElementById('labelOrdenTrans').innerHTML=getValueXML('formTablaTransfer','labelOrdenTransOut')+' ';
		
		mis_options=eval('optOut_ori');
		num_options = mis_options.length;
		document.formTablaTransfer.selOrigenTrans.length = num_options; 
		for(i=0;i<num_options;i++){ 
			document.formTablaTransfer.selOrigenTrans.options[i] = mis_options[i];
		}

		mis_options=eval('optOut_des1');
		num_options = mis_options.length;
		document.formTablaTransfer.selDestinoTrans1.length = num_options; 
		for(i=0;i<num_options;i++){ 
			document.formTablaTransfer.selDestinoTrans1.options[i] = mis_options[i];
		}
		
		mis_options=eval('optOut_des2');
		num_options = mis_options.length;
		document.formTablaTransfer.selDestinoTrans2.length = num_options; 
		for(i=0;i<num_options;i++){ 
			document.formTablaTransfer.selDestinoTrans2.options[i] = mis_options[i];
		}
		
		document.formTablaTransfer.selDestinoTrans1.value = 'ARP';
		desactivarObj('selDestinoTrans1');
		document.formTablaTransfer.selDestinoTrans2.value = '<NULL>';
		desactivarObj('selDestinoTrans2');		
		ocultarObj('cantVou');
		document.formTablaTransfer.cantVou.value = '';
		document.getElementById('labelCantVou').innerHTML='';
		pasarFoco(idFoco);
	}else
	if(cod.value == 'OTR'){
		document.getElementById('labelOrdenTrans').innerHTML=getValueXML('formTablaTransfer','labelOrdenTransOtr')+' ';
		
		mis_options=eval('optOtr_ori');
		num_options = mis_options.length;
		document.formTablaTransfer.selOrigenTrans.length = num_options; 
		for(i=0;i<num_options;i++){ 
			document.formTablaTransfer.selOrigenTrans.options[i] = mis_options[i];
		}

		mis_options=eval('optOtr_des1');
		num_options = mis_options.length;
		document.formTablaTransfer.selDestinoTrans1.length = num_options; 
		for(i=0;i<num_options;i++){ 
			document.formTablaTransfer.selDestinoTrans1.options[i] = mis_options[i];
		}
		
		mis_options=eval('optOtr_des2');
		num_options = mis_options.length;
		document.formTablaTransfer.selDestinoTrans2.length = num_options; 
		for(i=0;i<num_options;i++){ 
			document.formTablaTransfer.selDestinoTrans2.options[i] = mis_options[i];
		}
		
		document.formTablaTransfer.selOrigenTrans.value = '<NULL>';
		document.formTablaTransfer.selDestinoTrans1.value = '<NULL>';
		document.formTablaTransfer.selDestinoTrans2.value = '<NULL>';
		
		ocultarObj('cantVou');
		document.formTablaTransfer.cantVou.value = '';
		document.getElementById('labelCantVou').innerHTML='';
		ocultarObj('selNroVlo');
		document.formTablaTransfer.selNroVlo.value = '<NULL>';
		document.getElementById('labelNroVlo').innerHTML='';
		ocultarObj('horaVlo');
		document.formTablaTransfer.horaVlo.value = '';
		document.getElementById('labelHoraVlo').innerHTML='';
		pasarFoco('cantPax');
	}	
	
}

function cargarCamposTransfer2(idSelec,idFoco,getNroTransfer){
	var cod = document.getElementById(idSelec);
	fechaVlo = '';
	if(cod.value == '<NULL>'){
		document.getElementById('labelOrdenTrans').innerHTML=' ';
		document.getElementById('ordenTrans').innerHTML='';
		ocultarTablaTransfer();		
	}else{
		if(getNroTransfer == true){
			xajax_selectTransfer(cod.value);
		}	
		mostrarTablaTransfer();
	}
	
	var mis_options;
	var num_options = 0;
	
	if((cod.value == 'IN NAC') || (cod.value == 'IN INT')){
		//xajax_cargarSelNroVlo(cod.value);	
		document.getElementById('labelOrdenTrans').innerHTML=getValueXML('formTablaTransfer','labelOrdenTransIn')+' ';
		
		mis_options=eval('optIn_ori');
		num_options = mis_options.length;
		document.formTablaTransfer.selOrigenTrans.length = num_options; 
		for(i=0;i<num_options;i++){ 
			document.formTablaTransfer.selOrigenTrans.options[i] = mis_options[i];
		}

		mis_options=eval('optIn_des1');
		num_options = mis_options.length;
		document.formTablaTransfer.selDestinoTrans1.length = num_options; 
		for(i=0;i<num_options;i++){ 
			document.formTablaTransfer.selDestinoTrans1.options[i] = mis_options[i];
		}
		
		mis_options=eval('optIn_des2');
		num_options = mis_options.length;
		document.formTablaTransfer.selDestinoTrans2.length = num_options; 
		for(i=0;i<num_options;i++){ 
			document.formTablaTransfer.selDestinoTrans2.options[i] = mis_options[i];
		}
		
		document.formTablaTransfer.selOrigenTrans.value = 'ARP';
		desactivarObj('selOrigenTrans');		
		pasarFoco(idFoco);
	}else 
	if((cod.value == 'OUT AQU')||(cod.value == 'OUT MAR')||(cod.value == 'OUT MRL')||(cod.value == 'OUT DEL')||(cod.value == 'OUT DEC')){
		//xajax_cargarSelNroVlo(cod.value);
		document.getElementById('labelOrdenTrans').innerHTML=getValueXML('formTablaTransfer','labelOrdenTransOut')+' ';
		
		mis_options=eval('optOut_ori');
		num_options = mis_options.length;
		document.formTablaTransfer.selOrigenTrans.length = num_options; 
		for(i=0;i<num_options;i++){ 
			document.formTablaTransfer.selOrigenTrans.options[i] = mis_options[i];
		}

		mis_options=eval('optOut_des1');
		num_options = mis_options.length;
		document.formTablaTransfer.selDestinoTrans1.length = num_options; 
		for(i=0;i<num_options;i++){ 
			document.formTablaTransfer.selDestinoTrans1.options[i] = mis_options[i];
		}
		
		mis_options=eval('optOut_des2');
		num_options = mis_options.length;
		document.formTablaTransfer.selDestinoTrans2.length = num_options; 
		for(i=0;i<num_options;i++){ 
			document.formTablaTransfer.selDestinoTrans2.options[i] = mis_options[i];
		}
		
		document.formTablaTransfer.selDestinoTrans1.value = 'ARP';
		desactivarObj('selDestinoTrans1');
		document.formTablaTransfer.selDestinoTrans2.value = '<NULL>';
		desactivarObj('selDestinoTrans2');		
		ocultarObj('cantVou');
		document.formTablaTransfer.cantVou.value = '';
		document.getElementById('labelCantVou').innerHTML='';
		pasarFoco(idFoco);
	}else
	if(cod.value == 'OTR'){
		document.getElementById('labelOrdenTrans').innerHTML=getValueXML('formTablaTransfer','labelOrdenTransOtr')+' ';
		
		mis_options=eval('optOtr_ori');
		num_options = mis_options.length;
		document.formTablaTransfer.selOrigenTrans.length = num_options; 
		for(i=0;i<num_options;i++){ 
			document.formTablaTransfer.selOrigenTrans.options[i] = mis_options[i];
		}

		mis_options=eval('optOtr_des1');
		num_options = mis_options.length;
		document.formTablaTransfer.selDestinoTrans1.length = num_options; 
		for(i=0;i<num_options;i++){ 
			document.formTablaTransfer.selDestinoTrans1.options[i] = mis_options[i];
		}
		
		mis_options=eval('optOtr_des2');
		num_options = mis_options.length;
		document.formTablaTransfer.selDestinoTrans2.length = num_options; 
		for(i=0;i<num_options;i++){ 
			document.formTablaTransfer.selDestinoTrans2.options[i] = mis_options[i];
		}
		
		document.formTablaTransfer.selOrigenTrans.value = '<NULL>';
		document.formTablaTransfer.selDestinoTrans1.value = '<NULL>';
		document.formTablaTransfer.selDestinoTrans2.value = '<NULL>';
		
		ocultarObj('cantVou');
		document.formTablaTransfer.cantVou.value = '';
		document.getElementById('labelCantVou').innerHTML='';
		ocultarObj('selNroVlo');
		document.formTablaTransfer.selNroVlo.value = '<NULL>';
		document.getElementById('labelNroVlo').innerHTML='';
		ocultarObj('horaVlo');
		document.formTablaTransfer.horaVlo.value = '';
		document.getElementById('labelHoraVlo').innerHTML='';
		pasarFoco('cantPax');
	}	
	
}

function cargarDocuTax(e,idObj){	
	if (((document.all)?e.keyCode:e.which)=="13"){	
		var cod = document.getElementById(idObj);
		xajax_cargarDocuTax(cod.value);
		
	}
}

function cargarNomTax(e,idObj){	
	if (((document.all)?e.keyCode:e.which)=="13"){	
		var cod = document.getElementById(idObj);
		xajax_cargarNomTax(cod.value);
	}
}

function trim (myString)
{
	return myString.replace(/^\s+/g,'').replace(/\s+$/g,'');
}

function verificarCamposObligatorios(p1,p2,p3,p4,p5,
									 p6,p7,p8,p9,p10,
									 p11,p12,p13,p14,p15,
									 p16,p17,p18,p19,p20)
{	
	var variables='';
	
	if (!(p1===undefined)){
		if(trim(p1[0]) == '' || trim(p1[0]) == '<NULL>')
			variables = variables + p1[1].replace(':','') + '\n';
	}
	if (!(p2===undefined)){
		if(trim(p2[0]) == '' || trim(p2[0]) == '<NULL>')
			variables = variables + p2[1].replace(':','') + '\n';
	}
	if (!(p3===undefined)){
		if(trim(p3[0]) == '' || trim(p3[0]) == '<NULL>')
			variables = variables + p3[1].replace(':','') + '\n';
	}
	if (!(p4===undefined)){
		if(trim(p4[0]) == '' || trim(p4[0]) == '<NULL>')
			variables = variables + p4[1].replace(':','') + '\n';
	}
	if (!(p5===undefined)){
		if(trim(p5[0]) == '' || trim(p5[0]) == '<NULL>')
			variables = variables + p5[1].replace(':','') + '\n';
	}
	if (!(p6===undefined)){
		if(trim(p6[0]) == '' || trim(p6[0]) == '<NULL>')
			variables = variables + p6[1].replace(':','') + '\n';
	}
	if (!(p7===undefined)){
		if(trim(p7[0]) == '' || trim(p7[0]) == '<NULL>')
			variables = variables + p7[1].replace(':','') + '\n';
	}
	if (!(p8===undefined)){
		if(trim(p8[0]) == '' || trim(p8[0]) == '<NULL>')
			variables = variables + p8[1].replace(':','') + '\n';
	}
	if (!(p9===undefined)){
		if(trim(p9[0]) == '' || trim(p9[0]) == '<NULL>')
			variables = variables + p9[1].replace(':','') + '\n';
	}
	if (!(p10===undefined)){
		if(trim(p10[0]) == '' || trim(p10[0]) == '<NULL>')
			variables = variables + p10[1].replace(':','') + '\n';
	}
	if (!(p11===undefined)){
		if(trim(p11[0]) == '' || trim(p11[0]) == '<NULL>')
			variables = variables + p11[1].replace(':','') + '\n';
	}
	if (!(p12===undefined)){
		if(trim(p12[0]) == '' || trim(p12[0]) == '<NULL>')
			variables = variables + p12[1].replace(':','') + '\n';
	}
	if (!(p13===undefined)){
		if(trim(p13[0]) == '' || trim(p13[0]) == '<NULL>')
			variables = variables + p13[1].replace(':','') + '\n';
	}
	if (!(p14===undefined)){
		if(trim(p14[0]) == '' || trim(p14[0]) == '<NULL>')
			variables = variables + p14[1].replace(':','') + '\n';
	}
	if (!(p15===undefined)){
		if(trim(p15[0]) == '' || trim(p15[0]) == '<NULL>')
			variables = variables + p15[1].replace(':','') + '\n';
	}
	if (!(p16===undefined)){
		if(trim(p16[0]) == '' || trim(p16[0]) == '<NULL>')
			variables = variables + p16[1].replace(':','') + '\n';
	}
	if (!(p17===undefined)){
		if(trim(p17[0]) == '' || trim(p17[0]) == '<NULL>')
			variables = variables + p17[1].replace(':','') + '\n';
	}
	if (!(p18===undefined)){
		if(trim(p18[0]) == '' || trim(p18[0]) == '<NULL>')
			variables = variables + p18[1].replace(':','') + '\n';
	}
	if (!(p19===undefined)){
		if(trim(p19[0]) == '' || trim(p19[0]) == '<NULL>')
			variables = variables + p19[1].replace(':','') + '\n';
	}
	if (!(p20===undefined)){
		if(trim(p20[0]) == '' || trim(p20[0]) == '<NULL>')
			variables = variables + p20[1].replace(':','') + '\n';
	}
	
	return variables;	
}

function verificarLongitudCampos(p1,p2,p3,p4,p5,
									 p6,p7,p8,p9,p10,
									 p11,p12,p13,p14,p15,
									 p16,p17,p18,p19,p20)
{
	var variables='';
	if (!(p1===undefined)){
		if (!(p1[2]===undefined)){
			if(p1[0].length > p1[2])
				variables = variables + '"' + p1[1].replace(':','') + '"' + ' debe tener ' + p1[2] + ' caracteres maximo' + '\n';
		}
	}
	if (!(p2===undefined)){
		if (!(p2[2]===undefined)){
			if(p2[0].length > p2[2])
				variables = variables + '"' + p2[1].replace(':','') + '"' + ' debe tener ' + p2[2] + ' caracteres maximo' + '\n';
		}
	}
	if (!(p3===undefined)){
		if (!(p3[2]===undefined)){
			if(p3[0].length > p3[2])
				variables = variables + '"' + p3[1].replace(':','') + '"' + ' debe tener ' + p3[2] + ' caracteres maximo' + '\n';
		}
	}
	if (!(p4===undefined)){
		if (!(p4[2]===undefined)){
			if(p4[0].length > p4[2])
				variables = variables + '"' + p4[1].replace(':','') + '"' + ' debe tener ' + p4[2] + ' caracteres maximo' + '\n';
		}
	}
	if (!(p5===undefined)){
		if (!(p5[2]===undefined)){
			if(p5[0].length > p5[2])
				variables = variables + '"' + p5[1].replace(':','') + '"' + ' debe tener ' + p5[2] + ' caracteres maximo' + '\n';
		}
	}
	if (!(p6===undefined)){
		if (!(p6[2]===undefined)){
			if(p6[0].length > p6[2])
				variables = variables + '"' + p6[1].replace(':','') + '"' + ' debe tener ' + p6[2] + ' caracteres maximo' + '\n';
		}
	}
	if (!(p7===undefined)){
		if (!(p7[2]===undefined)){
			if(p7[0].length > p7[2])
				variables = variables + '"' + p7[1].replace(':','') + '"' + ' debe tener ' + p7[2] + ' caracteres maximo' + '\n';
		}
	}
	if (!(p8===undefined)){
		if (!(p8[2]===undefined)){
			if(p8[0].length > p8[2])
				variables = variables + '"' + p8[1].replace(':','') + '"' + ' debe tener ' + p8[2] + ' caracteres maximo' + '\n';
		}
	}
	if (!(p9===undefined)){
		if (!(p9[2]===undefined)){
			if(p9[0].length > p9[2])
				variables = variables + '"' + p9[1].replace(':','') + '"' + ' debe tener ' + p9[2] + ' caracteres maximo' + '\n';
		}
	}
	if (!(p10===undefined)){
		if (!(p10[2]===undefined)){
			if(p10[0].length > p10[2])
				variables = variables + '"' + p10[1].replace(':','') + '"' + ' debe tener ' + p10[2] + ' caracteres maximo' + '\n';
		}
	}
	if (!(p11===undefined)){
		if (!(p11[2]===undefined)){
			if(p11[0].length > p11[2])
				variables = variables + '"' + p11[1].replace(':','') + '"' + ' debe tener ' + p11[2] + ' caracteres maximo' + '\n';
		}
	}
	if (!(p12===undefined)){
		if (!(p12[2]===undefined)){
			if(p12[0].length > p12[2])
				variables = variables + '"' + p12[1].replace(':','') + '"' + ' debe tener ' + p12[2] + ' caracteres maximo' + '\n';
		}
	}
	if (!(p13===undefined)){
		if (!(p13[2]===undefined)){
			if(p13[0].length > p13[2])
				variables = variables + '"' + p13[1].replace(':','') + '"' + ' debe tener ' + p13[2] + ' caracteres maximo' + '\n';
		}
	}
	if (!(p14===undefined)){
		if (!(p14[2]===undefined)){
			if(p14[0].length > p14[2])
				variables = variables + '"' + p14[1].replace(':','') + '"' + ' debe tener ' + p14[2] + ' caracteres maximo' + '\n';
		}
	}
	if (!(p15===undefined)){
		if (!(p15[2]===undefined)){
			if(p15[0].length > p15[2])
				variables = variables + '"' + p15[1].replace(':','') + '"' + ' debe tener ' + p15[2] + ' caracteres maximo' + '\n';
		}
	}
	if (!(p16===undefined)){
		if (!(p16[2]===undefined)){
			if(p16[0].length > p16[2])
				variables = variables + '"' + p16[1].replace(':','') + '"' + ' debe tener ' + p16[2] + ' caracteres maximo' + '\n';
		}
	}
	if (!(p17===undefined)){
		if (!(p17[2]===undefined)){
			if(p17[0].length > p17[2])
				variables = variables + '"' + p17[1].replace(':','') + '"' + ' debe tener ' + p17[2] + ' caracteres maximo' + '\n';
		}
	}
	if (!(p18===undefined)){
		if (!(p18[2]===undefined)){
			if(p18[0].length > p18[2])
				variables = variables + '"' + p18[1].replace(':','') + '"' + ' debe tener ' + p18[2] + ' caracteres maximo' + '\n';
		}
	}
	if (!(p19===undefined)){
		if (!(p19[2]===undefined)){
			if(p19[0].length > p19[2])
				variables = variables + '"' + p19[1].replace(':','') + '"' + ' debe tener ' + p19[2] + ' caracteres maximo' + '\n';
		}
	}
	if (!(p20===undefined)){
		if (!(p20[2]===undefined)){
			if(p20[0].length > p20[2])
				variables = variables + '"' + p20[1].replace(':','') + '"' + ' debe tener ' + p20[2] + ' caracteres maximo' + '\n';
		}
	}
	
	return variables;
}

function mostrarMsg(tagMsg1,otrMsg1,tagMsg2,otrMsg2){
	var msg = getValueXML('mensajes',tagMsg1);
	if (!(otrMsg1===undefined)){
		msg = msg + ' ' + otrMsg1;
	}
	if (!(tagMsg2===undefined)){
		msg = msg + ' ' + getValueXML('mensajes',tagMsg2);
	}
	if (!(otrMsg2===undefined)){
		msg = msg + ' ' + otrMsg2;
	}
	
	alert(msg);
}

function getWidth(tagCampo){
	var val = getValueXML('reportes',tagCampo);
	if(val == '<NULL>')
		return 40;
	var val2 = val.split('::');
	var val3 = val2[0]*1;
	return val3;
}

function getTitulo(tagCampo){
	var val = getValueXML('reportes',tagCampo);
	if(val == '<NULL>')
		return 'NULL';	
	var val2 = val.split('::');
	var val3 = val2[1];
	return val3;
}

function getAlineacion(tagCampo){
	var val = getValueXML('reportes',tagCampo);
	if(val == '<NULL>')
		return 'IZQ';	
	var val2 = val.split('::');
	var val3 = '';
	try{
		val3 = val2[2];
	} catch(e) {
		val3 = 'IZQ';
	}
	if (val3===undefined)
		val3 = 'IZQ';
		
	if(val3 == 'IZQ')
		val3 = 'left';
	if(val3 == 'DER')
		val3 = 'right';
	if(val3 == 'CEN')
		val3 = 'center';
		
	return val3;
}

function getSum(tagCampo){
	var val = getValueXML('reportes',tagCampo);
	if(val == '<NULL>')
		return 'NO';	
	var val2 = val.split('::');
	var val3 = '';
	try{
		val3 = val2[3];
	} catch(e) {
		val3 = 'NO';
	}
	if (val3===undefined)
		val3 = 'NO';
		
	return val3;
}

function getOpe(tagCampo){
	var val = getValueXML('reportes',tagCampo);
	if(val == '<NULL>')
		return 'NO';	
	var val2 = val.split('::');
	var pos1 = 0;
	var pos2 = 0;
	var ope = '+';
	var res = 0;
	
	try{
		pos1 = val2[4];
	} catch(e) {
		pos1 = 0;
	}
	if (pos1===undefined)
		pos1 = 0;
	
	try{
		pos2 = val2[6];
	} catch(e) {
		pos2 = 0;
	}
	if (pos2===undefined)
		pos2 = 0;
	
	try{
		ope = val2[5];
	} catch(e) {
		ope = '+';
	}
	if (ope===undefined)
		ope = '+';
		
	if (ope == '/'){
		res = sumCampo[pos1] / sumCampo[pos2];		
	}
	
	if (ope == '+'){
		res = sumCampo[pos1] + sumCampo[pos2];		
	}
	
	if (ope == '-'){
		res = sumCampo[pos1] - sumCampo[pos2];		
	}
	
	if (ope == '*'){
		res = sumCampo[pos1] * sumCampo[pos2];		
	}
	
	res = Math.round(res*100)/100;
	
	return res;
}

function activarObj(obj){
	document.getElementById(obj).disabled='';
}

function desactivarObj(obj){
	document.getElementById(obj).disabled='disabled';
}

function mostrarObj(obj){
	document.getElementById(obj).style.display='';
}

function ocultarObj(obj){
	document.getElementById(obj).style.display='none';
}

function getValorConPuntos(pValor){
	var val = '';
	var lon = 0;
	var temp2 = '';
	var temp = ''+pValor;
	var banDecimal = false;
	
	temp2 = temp.split('.');
	
	try{
		temp = temp2[0];
	} catch(e) {
		temp = '';
	}
	if (temp===undefined)
		temp = '';
	
	if (!(temp == '')){
		pValor = temp;
		banDecimal = true;
	}
	
	val = ''+pValor;	
	lon =  val.length;
		
	if((lon >= 4 ) && (lon <= 6)){
		val = val.substring(0,lon-3) + '.' + val.substring(lon-3,lon);
	}
	
	if((lon >= 7 ) && (lon <= 9)){
		val = val.substring(0,lon-6) + '.' + val.substring(lon-6,lon-3) + '.' + val.substring(lon-3,lon);
	}
	
	if(lon >=10){
		val = val.substring(0,lon-9) + '.' + val.substring(lon-9,lon-6) + '.' + val.substring(lon-6,lon-3) + '.' + val.substring(lon-3,lon);
	}
	
	if (!(temp2[1]===undefined)){
		val = val + ',' + temp2[1];
	}
	
	return val;   
}

function isMultiple(valor, mult){
  var resp = valor % mult;
  if(resp == 0){
    return true;
  }else{
    return false;
  }
}

function getTextVoucher(addSpace, numVou, tour, fechaVenta, fechaTour, hora, lugar, hotel, agencia, 
                        selNombPax, numPax, numPax2, guia, telAsesor, asesor, obsPax, oficina, numRes){
  var porN1 = '50%';
  var porN2 = '50%';
  var por70 = '70%';
  var por30 = '30%';
  var por40 = '40%';
  var por60 = '60%';
  var por50 = '50%';
  var estilo = 'style=\"color:#000000;font-size:15px;\"';
  var imgHeader = "logovouchergestion"+oficina+".png";
  var imgRight = "logoreportegestiondatosotr"+oficina+".png";
  
  var space = "";
  if(addSpace){
    space = "<tr valign='center'>"+
              "<td width = '100%'><br></td>"+
            "</tr>";
  }
  
  // Recortando valores
  hotel = hotel.substring(0, 27);
  agencia = agencia.substring(0, 20);
  
  asesor = asesor.substring(0, 27);
  guia = guia.substring(0, 50);
  
  obsPax = obsPax.substring(0, 50);
  
  var text = "<table border='1' width = '750px'> <tr> <td>"+
              "<table border='0' width = '100%'>"+
              "<tr valign='center'>"+
              "<td>"+
              
                  "<table border='0' width = '550px'>"+
                    "<tr valign='center'>"+
                      "<td width = '100%'>"+
                        "<table border='0' width = '100%'><tr valign='center'>"+
                          "<td width = '60%'><img src='"+imgHeader+"' id='imgLogo' name='imgLogo'></td>"+
                          "<td width = '40%'><b>Voucher No. " + numVou + "</b><br><b>Reserva: "+numRes+"</b></td>"+
                        "</tr></table>"+
                      "</td>"+
                    "</tr>"+
                    "<tr valign='center'>"+
                      "<td width = '100%'>"+
                        "<table border='0' width = '100%'><tr valign='center'>"+
                          "<td width = '"+por70+"'><div " + estilo + "><b>Tour: </b>" + tour + "</div></td>"+
                          "<td width = '"+por30+"'><div " + estilo + "><b>F. Venta: </b>" + fechaVenta + "</div></td>"+
                        "</tr></table>"+
                      "</td>"+
                    "</tr>"+
                    "<tr valign='center'>"+
                      "<td width = '100%'>"+
                        "<table border='0' width = '100%'><tr valign='center'>"+
                          "<td width = '"+por50+"'><div " + estilo + "><b>Fecha y Hora del Tour: </b>" + fechaTour + " " + hora + "</div></td>"+
                          "<td width = '"+por50+"'><div " + estilo + "><b>Agencia: </b>" + agencia + "</div></td>"+
                        "</tr></table>"+
                      "</td>"+
                    "</tr>"+
                    
                    "<tr valign='center'>"+
                      "<td width = '100%'>"+
                        "<table border='0' width = '100%'><tr valign='center'>"+
                          "<td colspan='2'><div " + estilo + "><b>Lugar: </b>" + lugar + "</div></td>"+
                        "</tr></table>"+
                      "</td>"+
                    "</tr>"+

                    "<tr valign='center'>"+
                      "<td width = '100%'>"+
                        "<table border='0' width = '100%'><tr valign='center'>"+
                          "<td colspan='2'><div " + estilo + "><b>Nombre: </b>" + selNombPax + "</div></td>"+
                        "</tr></table>"+
                      "</td>"+
                    "</tr>"+
                    
                    "<tr valign='center'>"+
                      "<td width = '100%'>"+
                        "<table border='0' width = '100%'><tr valign='center'>"+
                          "<td width = '"+por40+"'><div " + estilo + "><b>Adultos: </b>" + numPax + "&nbsp;&nbsp;&nbsp;&nbsp;<b>Ni&ntilde;os: </b>" + numPax2 + "</div></td>"+
                          "<td width = '"+por60+"'><div " + estilo + "><b>Hotel: </b>" + hotel + "</div></td>"+
                        "</tr></table>"+
                      "</td>"+
                    "</tr>"+
                    
                    "<tr valign='center'>"+
                      "<td width = '100%'>"+
                        "<table border='0' width = '100%'><tr valign='center'>"+
                          "<td colspan='2'><div " + estilo + "><b>Gu&iacute;a: </b>" + guia + "</div></td>"+
                        "</tr></table>"+
                      "</td>"+
                    "</tr>"+
                    "<tr valign='center'>"+
                      "<td width = '100%'>"+
                        "<table border='0' width = '100%'><tr valign='center'>"+
                          "<td width = '"+por40+"'><div " + estilo + "><b>Tel. Asesor: </b>"+telAsesor+"</div></td>"+
                          "<td width = '"+por60+"'><div " + estilo + "><b>Asesor: </b>" + asesor + "</div></td>"+
                        "</tr></table>"+
                      "</td>"+
                    "</tr>"+
                    
                    "<tr valign='center'>"+
                      "<td width = '100%'>"+
                        "<table border='0' width = '100%'><tr valign='center'>"+
                          "<td colspan='2'><div " + estilo + "><b>Obs: </b>" + obsPax + "</div></td>"+
                        "</tr></table>"+
                      "</td>"+
                    "</tr>"+
                  "</table>"+
              "</td>"+
              
              "<td><img src='"+imgRight+"' id='imgLogo' name='imgLogo'></td>"+
              
              "</tr>"+
              
              space+
              
              "</table> </td> </tr> </table>"+
              "<br>";
  return text;
}


function printVoucherTour(addSpace, numVou, tour, fechaVenta, fechaTour, hora, lugar, hotel, agencia, 
                          selNombPax, numPax, numPax2, guia, telAsesor, asesor, obsPax, oficina, numRes){
  
  var ventimp = window.open("https://tourstiempodeviajar.lugo.host/?id=32", "_blank");	
  var txt = "";
  txt = getTextVoucher(addSpace, numVou, tour, fechaVenta, fechaTour, hora, lugar, hotel, agencia, 
                       selNombPax, numPax, numPax2, guia, telAsesor, asesor, obsPax, oficina, numRes);
  
  // Se imprime dos veces el voucher
  ventimp.document.write(txt);  
  ventimp.document.write(txt);
  
  ventimp.document.close();
  sleepPrint(700).then(() => {
      ventimp.print( );
      ventimp.close();
  });  
}

/************************************************************************************************************
(C) www.dhtmlgoodies.com, October 2005

Update log:
Version 1.1 December, 1st 2005: Critical update for the new Firefox 1.5 browser
Version 1.2: December, 21th 2005 : Mouseover effect when mouse moves outside of a submenu items text

This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.

Terms of use:
You are free to use this script as long as the copyright message is kept intact. However, you may not
redistribute, sell or repost it without our permission.

Thank you!

www.dhtmlgoodies.com
Alf Magne Kalleland

************************************************************************************************************/

var dhtmlgoodies_menuObj; // Referenc�a al div del men�
var currentZIndex = 1000;
var liIndex = 0;
var visibleMenus = new Array();
var activeMenuItem = false;
var timeBeforeAutoHide = 1200; // Cantidad de microsegundos antes de que los men�s se oculten automaticamente
var dhtmlgoodies_menu_arrow = 'images/arrow.gif'; //Ruta a la imagen de flecha hacia abajo

var MSIE = navigator.userAgent.indexOf('MSIE')>=0?true:false;
var navigatorVersion = navigator.appVersion.replace(/.*?MSIE ([0-9]\.[0-9]).*/g,'$1')/1;
var menuBlockArray = new Array();
var menuParentOffsetLeft = false;

function getTopPos(inputObj){
	var returnValue = inputObj.offsetTop;
	if(inputObj.tagName=='LI' && inputObj.parentNode.className=='menuBlock1'){
	var aTag = inputObj.getElementsByTagName('A')[0];
	if(aTag)returnValue += aTag.parentNode.offsetHeight;
	}
	while((inputObj = inputObj.offsetParent) != null)returnValue += inputObj.offsetTop;
	return returnValue;
}

function getLeftPos(inputObj){
	var returnValue = inputObj.offsetLeft;
	while((inputObj = inputObj.offsetParent) != null)returnValue += inputObj.offsetLeft;
	return returnValue;
}

function showHideSub(){
	var attr = this.parentNode.getAttribute('currentDepth');
	if(navigator.userAgent.indexOf('Opera')>=0){
		attr = this.parentNode.currentDepth;
	}

	this.className = 'currentDepth' + attr + 'over';

	if(activeMenuItem && activeMenuItem!=this){
		activeMenuItem.className=activeMenuItem.className.replace(/over/,'');
	}
	activeMenuItem = this;

	var numericIdThis = this.id.replace(/[^0-9]/g,'');
	var exceptionArray = new Array();
	// Mostrar subitem LI
	var sub = document.getElementById('subOf' + numericIdThis);
	if(sub){
		visibleMenus.push(sub);
		sub.style.display='';
		sub.parentNode.className = sub.parentNode.className + 'over';
		exceptionArray[sub.id] = true;
	}

	// Showing parent items of this one
	var parent = this.parentNode;
	while(parent && parent.id && parent.tagName=='UL'){
		visibleMenus.push(parent);
		exceptionArray[parent.id] = true;
		parent.style.display='';

		var li = document.getElementById('dhtmlgoodies_listItem' + parent.id.replace(/[^0-9]/g,''));
		if(li.className.indexOf('over')<0)li.className = li.className + 'over';
		parent = li.parentNode;
	}
	hideMenuItems(exceptionArray);
}

function hideMenuItems(exceptionArray){
	/*Ocultar el men� visible en ese momento*/
	var newVisibleMenuArray = new Array();
	for(var no=0;no<visibleMenus.length;no++){
		if(visibleMenus[no].className!='menuBlock1' && visibleMenus[no].id){
			if(!exceptionArray[visibleMenus[no].id]){
				var el = visibleMenus[no].getElementsByTagName('A')[0];
				visibleMenus[no].style.display = 'none';
				var li = document.getElementById('dhtmlgoodies_listItem' + visibleMenus[no].id.replace(/[^0-9]/g,''));
				if(li.className.indexOf('over')>0)li.className = li.className.replace(/over/,'');
			}else{
				newVisibleMenuArray.push(visibleMenus[no]);
			}
		}
	}
	visibleMenus = newVisibleMenuArray;
}


var menuActive = true;
var hideTimer = 0;
function mouseOverMenu(){
	menuActive = true;
}

function mouseOutMenu(){
	menuActive = false;
	timerAutoHide();
}

function timerAutoHide(){
	if(menuActive){
		hideTimer = 0;
		return;
	}

	if(hideTimer<timeBeforeAutoHide){
		hideTimer+=100;
		setTimeout('timerAutoHide()',99);
	}else{
		hideTimer = 0;
		autohideMenuItems();
	}
}

function autohideMenuItems(){
	if(!menuActive){
		hideMenuItems(new Array());
		if(activeMenuItem)activeMenuItem.className=
		activeMenuItem.className.replace(/over/,'');
	}
}


function initSubMenus(inputObj,initOffsetLeft,currentDepth){
	var subUl = inputObj.getElementsByTagName('UL');
	if(subUl.length>0){
		var ul = subUl[0];

		ul.id = 'subOf' + inputObj.id.replace(/[^0-9]/g,'');
		ul.setAttribute('currentDepth' ,currentDepth);
		ul.currentDepth = currentDepth;
		ul.className='menuBlock' + currentDepth;
		ul.onmouseover = mouseOverMenu;
		ul.onmouseout = mouseOutMenu;
		currentZIndex+=1;
		ul.style.zIndex = currentZIndex;
		menuBlockArray.push(ul);
		var topPos = getTopPos(inputObj);
		var leftPos = getLeftPos(inputObj)/1 + initOffsetLeft/1;
		ul = dhtmlgoodies_menuObj.appendChild(ul);
		ul.style.position = 'absolute';
		ul.style.left = leftPos + 'px';
		ul.style.top = topPos + 'px';
		var li = ul.getElementsByTagName('LI')[0];
		while(li){
			if(li.tagName=='LI'){
				li.className='currentDepth' + currentDepth;
				li.id = 'dhtmlgoodies_listItem' + liIndex;
				liIndex++;
				var uls = li.getElementsByTagName('UL');
				li.onmouseover = showHideSub;
				if(uls.length>0){
					var offsetToFunction = li.getElementsByTagName('A')[0].offsetWidth+2;
					if(navigatorVersion<6 && MSIE)offsetToFunction+=15; // MSIE 5.x fix
					initSubMenus(li,offsetToFunction,(currentDepth+1));
				}
				if(MSIE){
					var a = li.getElementsByTagName('A')[0];
					a.style.width=li.offsetWidth+'px';
					a.style.display='block';
				}
			}
			li = li.nextSibling;
		}
		ul.style.display = 'none';
		if(!document.all){
			//dhtmlgoodies_menuObj.appendChild(ul);
		}
	}
}

function resizeMenu(){
	var offsetParent = getLeftPos(dhtmlgoodies_menuObj);
	for(var no=0;no<menuBlockArray.length;no++){
		var leftPos = menuBlockArray[no].style.left.replace('px','')/1;
		menuBlockArray[no].style.left = leftPos + offsetParent - menuParentOffsetLeft + 'px';
	}
	menuParentOffsetLeft = offsetParent;
}

/*
Inicializaci�n del men�
*/
function initDhtmlGoodiesMenu(){
	dhtmlgoodies_menuObj = document.getElementById('dhtmlgoodies_menu');
	var aTags = dhtmlgoodies_menuObj.getElementsByTagName('A');
	for(var no=0;no<aTags.length;no++){
		var subUl = aTags[no].parentNode.getElementsByTagName('UL');
		if(subUl.length>0 && aTags[no].parentNode.parentNode.parentNode.id != 'dhtmlgoodies_menu'){
			var img = document.createElement('IMG');
			img.src = dhtmlgoodies_menu_arrow;
			img.border = '0';
			aTags[no].appendChild(img);
		}
	}

	var mainMenu = dhtmlgoodies_menuObj.getElementsByTagName('UL')[0];
	mainMenu.className='menuBlock1';
	mainMenu.style.zIndex = currentZIndex;
	mainMenu.setAttribute('currentDepth' ,1);
	mainMenu.currentDepth = '1';
	mainMenu.onmouseover = mouseOverMenu;
	mainMenu.onmouseout = mouseOutMenu;
	var mainMenuItemsArray = new Array();
	var mainMenuItem = mainMenu.getElementsByTagName('LI')[0];
	mainMenu.style.height = mainMenuItem.offsetHeight + 2 + 'px';
	while(mainMenuItem){
		mainMenuItem.className='currentDepth1';
		mainMenuItem.id = 'dhtmlgoodies_listItem' + liIndex;
		mainMenuItem.onmouseover = showHideSub;
		liIndex++;
		if(mainMenuItem.tagName=='LI'){
			mainMenuItem.style.cssText = 'float:left;';
			mainMenuItem.style.styleFloat = 'left';
			mainMenuItemsArray[mainMenuItemsArray.length] = mainMenuItem;
			initSubMenus(mainMenuItem,0,2);
		}
		mainMenuItem = mainMenuItem.nextSibling;
	}
	for(var no=0;no<mainMenuItemsArray.length;no++){
		initSubMenus(mainMenuItemsArray[no],0,2);
	}

	menuParentOffsetLeft = getLeftPos(dhtmlgoodies_menuObj);
	window.onresize = resizeMenu;
	dhtmlgoodies_menuObj.style.visibility = 'visible';
}
window.onload = initDhtmlGoodiesMenu;

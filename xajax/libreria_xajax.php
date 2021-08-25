<?php 
// 1.- Incluimos nuestra libreria.  
//include 'xajax/xajax_core/xajax.inc.php'; 
include 'xajax_core/xajax.inc.php'; 
 
// 2.- Instanciamos un nuevo objeto XAJAX.
$xajax = new xajax();  

// 3.- Registramos nuestras funciones. 

$xajax->register(XAJAX_FUNCTION, 'setLanguage');

$xajax->register(XAJAX_FUNCTION, 'cargarTablaReservas');
$xajax->register(XAJAX_FUNCTION, 'registrarReserva');
$xajax->register(XAJAX_FUNCTION, 'llenarTablaReservas');
$xajax->register(XAJAX_FUNCTION, 'eliminarReserva');
$xajax->register(XAJAX_FUNCTION, 'desactivarRes');
$xajax->register(XAJAX_FUNCTION, 'obtenerNroReservaX');
$xajax->register(XAJAX_FUNCTION, 'liberarNroReservaX');
$xajax->register(XAJAX_FUNCTION, 'iniIngresarReserva');


$xajax->register(XAJAX_FUNCTION, 'llenarTablaReservasNom');

$xajax->register(XAJAX_FUNCTION, 'registrarAgencia');
$xajax->register(XAJAX_FUNCTION, 'actualizarAgencia');
$xajax->register(XAJAX_FUNCTION, 'retirarAgencia');
$xajax->register(XAJAX_FUNCTION, 'llenarTablaAgencias');

$xajax->register(XAJAX_FUNCTION, 'registrarServicio');
$xajax->register(XAJAX_FUNCTION, 'actualizarServicio');
$xajax->register(XAJAX_FUNCTION, 'retirarServicio');
$xajax->register(XAJAX_FUNCTION, 'llenarTablaServicios');

$xajax->register(XAJAX_FUNCTION, 'registrarVuelo');
$xajax->register(XAJAX_FUNCTION, 'retirarVuelo');
$xajax->register(XAJAX_FUNCTION, 'llenarTablaVuelos');
$xajax->register(XAJAX_FUNCTION, 'llenarTablaVuelosSearch');
$xajax->register(XAJAX_FUNCTION, 'cargarSelHoraVlo');
$xajax->register(XAJAX_FUNCTION, 'cargarSelNroVlo');

$xajax->register(XAJAX_FUNCTION, 'cargarSelVloLlega');
$xajax->register(XAJAX_FUNCTION, 'cargarSelVloSale');


$xajax->register(XAJAX_FUNCTION, 'registrarHotel');
$xajax->register(XAJAX_FUNCTION, 'actualizarHotel');
$xajax->register(XAJAX_FUNCTION, 'retirarHotel');
$xajax->register(XAJAX_FUNCTION, 'llenarTablaHoteles');

$xajax->register(XAJAX_FUNCTION, 'registrarUsuario');
$xajax->register(XAJAX_FUNCTION, 'actualizarUsuario');
$xajax->register(XAJAX_FUNCTION, 'retirarUsuario');
$xajax->register(XAJAX_FUNCTION, 'llenarTablaUsuarios');

$xajax->register(XAJAX_FUNCTION, 'registrarNacionalidad');
$xajax->register(XAJAX_FUNCTION, 'actualizarNacionalidad');
$xajax->register(XAJAX_FUNCTION, 'retirarNacionalidad');
$xajax->register(XAJAX_FUNCTION, 'llenarTablaNacionalidades');

$xajax->register(XAJAX_FUNCTION, 'registrarProveedor');
$xajax->register(XAJAX_FUNCTION, 'actualizarProveedor');
$xajax->register(XAJAX_FUNCTION, 'retirarProveedor');
$xajax->register(XAJAX_FUNCTION, 'llenarTablaProveedores');

$xajax->register(XAJAX_FUNCTION, 'desactivarResRes');
$xajax->register(XAJAX_FUNCTION, 'activarResRes');

$xajax->register(XAJAX_FUNCTION, 'selectTransfer');
$xajax->register(XAJAX_FUNCTION, 'registrarTransfer');
$xajax->register(XAJAX_FUNCTION, 'actualizarTransfer');
$xajax->register(XAJAX_FUNCTION, 'retirarTransfer');
$xajax->register(XAJAX_FUNCTION, 'desactivarTransfer');
$xajax->register(XAJAX_FUNCTION, 'llenarTablaTransfer');
$xajax->register(XAJAX_FUNCTION, 'llenarTablaTransferNom');
$xajax->register(XAJAX_FUNCTION, 'liberarNroTransferX');
$xajax->register(XAJAX_FUNCTION, 'cargarDocuTax');
$xajax->register(XAJAX_FUNCTION, 'cargarNomTax');

$xajax->register(XAJAX_FUNCTION, 'sacarReporteX');
$xajax->register(XAJAX_FUNCTION, 'sacarReporteY');
$xajax->register(XAJAX_FUNCTION, 'borrarReporte');
$xajax->register(XAJAX_FUNCTION, 'getExcel');
$xajax->register(XAJAX_FUNCTION, 'guardarSuma');

$xajax->register(XAJAX_FUNCTION, 'registrarConsecutivo');
$xajax->register(XAJAX_FUNCTION, 'llenarTablaConsecutivosSearch');
$xajax->register(XAJAX_FUNCTION, 'borrarConsecutivosSelec');
$xajax->register(XAJAX_FUNCTION, 'borrarConsecutivo');
$xajax->register(XAJAX_FUNCTION, 'borrarConsecutivoUnit');

$xajax->register(XAJAX_FUNCTION, 'cargarSelProveedor');
$xajax->register(XAJAX_FUNCTION, 'cargarCampoCupos');
$xajax->register(XAJAX_FUNCTION, 'registrarTour');
$xajax->register(XAJAX_FUNCTION, 'registrarTourRango');
$xajax->register(XAJAX_FUNCTION, 'registrarVentaTour');
$xajax->register(XAJAX_FUNCTION, 'cargarSelFechaTour');
$xajax->register(XAJAX_FUNCTION, 'cargarSelFechaTour2');
$xajax->register(XAJAX_FUNCTION, 'cargarSelFechaTour3');
$xajax->register(XAJAX_FUNCTION, 'cargarSelFechaTour4');
$xajax->register(XAJAX_FUNCTION, 'cargarCampoCuposTour');
$xajax->register(XAJAX_FUNCTION, 'cancelarProgramacionTour');
$xajax->register(XAJAX_FUNCTION, 'cargarCampoSelNomPax');
$xajax->register(XAJAX_FUNCTION, 'cargarCampoNumPax');
$xajax->register(XAJAX_FUNCTION, 'cancelarAsistenciaTour');
$xajax->register(XAJAX_FUNCTION, 'preCancelarAsistenciaTour');
$xajax->register(XAJAX_FUNCTION, 'cargarLugarTour');
$xajax->register(XAJAX_FUNCTION, 'obtenerNroVoucherX');
$xajax->register(XAJAX_FUNCTION, 'liberarNroVoucherX');

$xajax->register(XAJAX_FUNCTION, 'cargarSelNombPax');
$xajax->register(XAJAX_FUNCTION, 'cargarSelNombPaxXDoc');
$xajax->register(XAJAX_FUNCTION, 'confirmarReservaTour');
$xajax->register(XAJAX_FUNCTION, 'cargarSelTour');

$xajax->register(XAJAX_FUNCTION, 'crearConsecutivosX');

$xajax->register(XAJAX_FUNCTION, 'cambiarPassword');

$xajax->register(XAJAX_FUNCTION, 'verificarReservasExistentes');
$xajax->register(XAJAX_FUNCTION, 'cargarInfoContacto');

$xajax->register(XAJAX_FUNCTION, 'registrarPaquete');
$xajax->register(XAJAX_FUNCTION, 'actualizarPaquete');
$xajax->register(XAJAX_FUNCTION, 'retirarPaquete');
$xajax->register(XAJAX_FUNCTION, 'llenarTablaPaquetes');

//$xajax->register(XAJAX_FUNCTION, 'queryDB');

// 4.- Procesamos el registro. 
$xajax->processRequest();  

// 5.- Especificamos la ruta de nuestra libreria JS 
$xajax->configure('javascript URI','xajax/');  

?>
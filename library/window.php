<?php
	
function getPage($pID = 0){
    return $pID;
}

$reserva = false;

function getSession(){
	if($_SESSION["autentificado"])
		return $_SESSION["autentificado"];
	else
		return "0";	
}

$page = @getPage($_GET['id']);

if ((@getSession()!="1") and ($page != "10")){
	include "pages/inicio.php";
	echo"<script> document.getElementById('labelUser').innerHTML='';</script>";
	echo"<script> document.getElementById('labelUserName').innerHTML='';</script>";
}
else{
	@liberarNroReserva();
	@liberarNroVoucher();
	/*
	liberarNroTransfer('IN NAC');
	liberarNroTransfer('IN INT');
	liberarNroTransfer('OUT AQU');
	liberarNroTransfer('OUT MAR');
	liberarNroTransfer('OUT MRL');
	liberarNroTransfer('OUT DEL');
	liberarNroTransfer('OUT DEC');
	liberarNroTransfer('OTR');
	*/
	printVarJSfromDB('VAR_JS_GENERAL');
	// Inicio
	if ($page == "0"){
		include "pages/inicio.php";
		
	// Reservas
	} elseif ($page == "1"){
			include "pages/reservas.php";	
				
	// Transfer
	} elseif ($page == "2"){
			include "pages/transfer.php";
			
	// Tours
	} elseif ($page == "31"){
			include "pages/tours1.php";
	
	// Tours
	} elseif ($page == "32"){
			include "pages/tours2.php";
			
	// Tours
	} elseif ($page == "33"){
			include "pages/tours3.php";
			
		// Tours
	} elseif ($page == "34"){
			include "pages/tours4.php";
			
		// Tours
	} elseif ($page == "35"){
			include "pages/tours5.php";
			
	// Reportes
	} elseif (substr($page, 0, 1)  == "4"){
			include "pages/reportes.php";
	// Tablas
	} elseif (substr($page, 0, 1)  == "5"){
			include "pages/tablas.php";
			
	// Cambiar password
	} elseif ($page == "6"){
			include "pages/password.php";
												
	// Iniciar sesion
	} elseif ($page == "10"){
		// Comprobamos el usuario y password
		$login = getLoginStatus($_POST['user'], $_POST['pass']);
		// Creamos el mensaje de respuesta   
		if($login){ 
			// Creamos la sesion
			
			$_SESSION["autentificado"]="1";
			$_SESSION["user"]=$_POST['user'];
			$_SESSION["username"] = $_SESSION["user"]." - ".getNameUser($_SESSION["user"]);
			$_SESSION["usertel"] = getTelUser($_SESSION["user"]);
      
      
      $_SESSION["oficina"]=$_POST['oficina'];
			$_SESSION["oficinaname"] = getNomOfi($_SESSION["oficina"]);
			$_SESSION["oficinaprefijo"] = getPrefijoOfi($_SESSION["oficina"]);
			
			$_SESSION["numres"] = '0';
			
			$_SESSION["numvou"] = '0';
      
      
      
			resetQueriesVuelos();
			resetQueriesHoteles();
			resetQueriesProveedores();
			resetQueriesServicios();
			resetQueriesUsuarios();
			resetQueriesNacionalidades();
			resetQueriesClientes();
			
			/*
			$_SESSION["IN NAC"] = '0';
			$_SESSION["IN INT"] = '0';
			$_SESSION["OUT AQU"] = '0';
			$_SESSION["OUT MAR"] = '0';
			$_SESSION["OUT MRL"] = '0';
			$_SESSION["OUT DEL"] = '0';
			$_SESSION["OUT DEC"] = '0';
			$_SESSION["OTR"] = '0';
			*/
			
			$_SESSION["objPHPExcel"] = array();
			$_SESSION["repPHPExcel"] = 'query';
			$_SESSION["numPHPExcel"] = 0;
			
			include "db/cache.php";
						
			liberarConsecReservAntiguos();
			
			echo"<script> document.getElementById('labelUserName').innerHTML='".$_SESSION['username']."';</script>";			

			echo"<script> document.getElementById('telUserName').value='".$_SESSION['usertel']."';</script>";
			
			echo"<script> document.getElementById('labelUser').innerHTML='".getValueXML('formHeader','labelUser')."';</script>";
      
      echo"<script> document.getElementById('labelOfiName').innerHTML='".$_SESSION['oficinaname']."';</script>";			
			echo"<script> document.getElementById('labelOfi').innerHTML='".getValueXML('formHeader','labelOfi')."';</script>";
      
			// Pasamos a la pagina de resevas
			include "pages/reservas.php";
			//include "pages/tablas.php";
						
		} 
		else{ 
			echo "<script>mostrarMsg('errorInicioSesion')</script>";			
			include "pages/inicio.php"; 
		} 	
			
						
	// Cerrar sesion	
	} elseif ($page == "99"){
		//session_start();
		liberarNroReserva();
		liberarNroVoucher();
		/*
		liberarNroTransfer('IN NAC');
		liberarNroTransfer('IN INT');
		liberarNroTransfer('OUT AQU');
		liberarNroTransfer('OUT MAR');
		liberarNroTransfer('OUT MRL');
		liberarNroTransfer('OUT DEL');
		liberarNroTransfer('OUT DEC');
		liberarNroTransfer('OTR');
		*/
		registrarSesionTxt(0, $_SESSION["user"], "Cierre de sesion");
		session_destroy();	
		
		
		/*echo"<script> document.formHeader.user.value=''; </script>";*/
		echo"<script> document.getElementById('labelUserName').innerHTML='';</script>";
		echo"<script> document.getElementById('labelUser').innerHTML='';</script>";		
		include "pages/inicio.php";	
		
		desconectarFinDB();
			
	// Pagina por default
	} else {
		include "pages/inicio.php";
	}	
}	
?>
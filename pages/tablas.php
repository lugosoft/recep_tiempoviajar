<?php
	$verifPermiso = false;
	$verifPermiso = verificarPermiso($_SESSION["user"], 'tablas');
	if ($verifPermiso == false){
		echo"<script>mostrarMsg('errorPaginaNoPermitida');</script>";
		echo"<a class='textoNoPermisos'>".getValueXML('mensajes', 'errorPaginaNoPermitida')."</a>";
		return;
	}
?>

<?php
	inicializarProveedores();
	//$serviciosBase = array();
	$proveedoresBase = getArrayProveedores();	
?>
<script>

	function setProveedorCodSer(codPro,dato,datoCosto)
	{
		<?php
		$proveedoresBase = getArrayProveedores();
		foreach ($proveedoresBase as &$pro){
			echo"if(codPro == '".$pro['cod']."'){\n
				setProveedorSer(".$pro['it'].",dato);\n
				setProveedorCosSer(".$pro['it'].",datoCosto);\n
			}\n";
		}
		?>
	};
	
	function checkAllConsecutivos()
	{
		var valCheck = false; 
		if(document.formConsultaConsecutivo.miCheckAll.checked){
			valCheck = true; 
		}else{
			valCheck = false; 
		}
		
		for(i=1;i<=50;i++){
			var chk = document.getElementById('miCheck'+i);	
			if(chk.style.display != 'none')
				document.getElementById('miCheck'+i).checked = valCheck;
		}	
	};
	
	
	function borrarConsecutivosSelec(tipo){
		var datosConsec = '';
		for(i=1;i<=50;i++){
			var chk = document.getElementById('miCheck'+i);	
			if(chk.checked){	
				it = ''+i;
				valor = document.getElementById('numConsec'+i).value;
				datosConsec = datosConsec + it + '/,/' + valor+ '/,//;/';
			}			
		}
		//alert(datosConsec + ' - ' + tipo);		
		if(datosConsec == '')
			mostrarMsg('errorNoSeleccionConsecutivo');
		else
			xajax_borrarConsecutivosSelec(datosConsec, tipo);
	};		
	
	function mostrarTablas(tabla){
		
		document.getElementById('tablaAgencias').style.display='none';			
		document.getElementById('tablaServicios').style.display='none';	
		document.getElementById('tablaHoteles').style.display='none';	
		document.getElementById('tablaProveedores').style.display='none';
    document.getElementById('tablaPaquetes').style.display='none';
		document.getElementById('tablaUsuarios').style.display='none';
		document.getElementById('tablaNacionalidades').style.display='none';
		document.getElementById('tablaVuelos').style.display='none';
		document.getElementById('tablaConsecutivos').style.display='none';
		
		
		document.getElementById(tabla).style.display='block';	
				
	};
	
	<?php 
		limpiarProveedoresServicio();
	?>
	
	function activarSelCliente(idSelec){
		var cod = document.getElementById(idSelec);		
		if(cod.value == 'CLI'){
			activarObj('selCliente');
		}
		else{
			document.formTablaUsuarios.selCliente.value = '<NULL>'; 
			desactivarObj('selCliente');
		}
	}
			
	function ingresarEnTabla(){
		if(tabla == 'agencias'){
			iniIngresarAgencia();
		}
		if(tabla == 'servicios'){
			iniIngresarServicio();			
			limpiarProveedoresServicio();
		}
		if(tabla == 'hoteles'){
			iniIngresarHotel();
		}
		if(tabla == 'usuarios'){
			iniIngresarUsuario();
		}
		if(tabla == 'nacionalidades'){
			iniIngresarNacionalidad();
		}
		if(tabla == 'proveedores'){
			iniIngresarProveedor();
		}
		if(tabla == 'vuelos'){
			iniIngresarVuelo();
		}
		if(tabla == 'consecutivos'){
			iniIngresarConsecutivo();
		}
    if(tabla == 'paquetes'){
			iniIngresarPaquete();
		}
	};
	
	function registrarEnTabla(){
		var r = '';
		if(tabla == 'agencias'){
			var codAge = document.formTablaAgencias.codAge.value.toUpperCase();
			var nomAge = document.formTablaAgencias.nomAge.value;
			var nitAge = document.formTablaAgencias.nitAge.value;
			
			var dirAge = document.formTablaAgencias.dirAge.value;
			var ciuAge = document.formTablaAgencias.ciuAge.value;
			var tel1Age = document.formTablaAgencias.tel1Age.value;
			var tel2Age = document.formTablaAgencias.tel2Age.value;
			var celAge = document.formTablaAgencias.celAge.value;
			var contacAge = document.formTablaAgencias.contacAge.value;
									
			r = verificarCamposObligatorios(new Array(codAge,getValueXML('formTablaAgencias','codAge')), 
                                      new Array(nomAge,getValueXML('formTablaAgencias','nomAge')),
                                      new Array(nitAge,getValueXML('formTablaAgencias','nitAge')),
                                      new Array(dirAge,getValueXML('formTablaAgencias','dirAge')),
                                      new Array(ciuAge,getValueXML('formTablaAgencias','ciuAge')),
                                      new Array(tel1Age,getValueXML('formTablaAgencias','tel1Age')),
                                      new Array(contacAge,getValueXML('formTablaAgencias','contacAge'))
      );
			
			if(r!=''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
			
			r = verificarLongitudCampos(new Array(codAge,getValueXML('formTablaAgencias','codAge'),7), 
										new Array(nomAge,getValueXML('formTablaAgencias','nomAge'),100),
										new Array(nitAge,getValueXML('formTablaAgencias','nitAge'),20),
										new Array(ciuAge,getValueXML('formTablaAgencias','ciuAge'),50),
										new Array(tel1Age,getValueXML('formTablaAgencias','tel1Age'),10),
										new Array(tel2Age,getValueXML('formTablaAgencias','tel2Age'),10),
										new Array(celAge,getValueXML('formTablaAgencias','celAge'),10),
										new Array(contacAge,getValueXML('formTablaAgencias','contacAge'),50));
			
			if(r!=''){
				alert('Error\n'+r);
				return;
			}
			
			if(codAge.length != 5){
				mostrarMsg('errorLongitudAgencia','5','errorLongitud');
				return;
			}
			
			
			xajax_registrarAgencia(	document.formTablaAgencias.selTipoAge.value, codAge , nomAge , 
									document.formTablaAgencias.dirAge.value , document.formTablaAgencias.ciuAge.value , 
									document.formTablaAgencias.tel1Age.value , document.formTablaAgencias.tel2Age.value , 
									document.formTablaAgencias.celAge.value , document.formTablaAgencias.contacAge.value , 
                  document.formTablaAgencias.nitAge.value);
		}
		if(tabla == 'servicios'){
			var codSer = document.formTablaServicios.codSer.value.toUpperCase();
			var nomSer = document.formTablaServicios.nomSer.value;
			r = verificarCamposObligatorios(new Array(codSer,getValueXML('formTablaServicios','codSer')), 
											new Array(nomSer,getValueXML('formTablaServicios','nomSer')));
			
			if(r!=''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
			
			r = verificarLongitudCampos(new Array(codSer,getValueXML('formTablaServicios','codSer'),7), 
										new Array(nomSer,getValueXML('formTablaServicios','nomSer'),40)
										);
			
			if(r!=''){
				alert('Error\n'+r);
				return;
			}
			
			if(codSer.length != 5){
				mostrarMsg('errorLongitudServicio','5','errorLongitud');
				return;
			}
			
			var datosProveedoresSer = '';
			<?php	
				$i = 1;
				echo"datosProveedoresSer = datosProveedoresSer ";
				foreach ($proveedoresBase as &$pro){
					if($i < 2){
						echo"+ '".$pro['cod']."' + ':' + getProveedorSer(".$pro['it'].") + ':' + getProveedorCosSer(".$pro['it'].") + ':' ";
					}else{
						echo"+ '/,/' + '".$pro['cod']."' + ':' + getProveedorSer(".$pro['it'].") + ':' + getProveedorCosSer(".$pro['it'].") + ':' ";
					}
					$i++;
				}	
				echo" + '/,//;/';\n";
			?>		
			xajax_registrarServicio(document.formTablaServicios.codSer.value , document.formTablaServicios.nomSer.value , 
									document.formTablaServicios.selDefecto.value , document.formTablaServicios.ordenSale.value , 
									datosProveedoresSer, 
									document.formTablaServicios.precXPaxAd.value, document.formTablaServicios.precXPaxIn.value);	
		}
		if(tabla == 'hoteles'){
			var codHot = document.formTablaHoteles.codHot.value.toUpperCase();
			var nomHot = document.formTablaHoteles.nomHot.value;
			
			var dirHot = document.formTablaHoteles.dirHot.value;
			var tel1Hot = document.formTablaHoteles.tel1Hot.value;
			var tel2Hot = document.formTablaHoteles.tel2Hot.value;
			var celHot = document.formTablaHoteles.celHot.value;
			var conHot = document.formTablaHoteles.conHot.value;
			
			
			r = verificarCamposObligatorios(new Array(codHot,getValueXML('formTablaHoteles','codHot')), 
											new Array(nomHot,getValueXML('formTablaHoteles','nomHot')));
			
			if(r!=''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
			
			if(codHot.length != 5){
				mostrarMsg('errorLongitudHotel','5','errorLongitud');
				return;
			}
				
			r = verificarLongitudCampos(new Array(codHot,getValueXML('formTablaHoteles','codHot'),7), 
										new Array(nomHot,getValueXML('formTablaHoteles','nomHot'),30),
										new Array(dirHot,getValueXML('formTablaHoteles','dirHot'),50),
										new Array(tel1Hot,getValueXML('formTablaHoteles','tel1Hot'),10),
										new Array(tel2Hot,getValueXML('formTablaHoteles','tel2Hot'),10),
										new Array(celHot,getValueXML('formTablaHoteles','celHot'),10),
										new Array(conHot,getValueXML('formTablaHoteles','conHot'),50)
										);
											
			if(r!=''){
				alert('Error\n'+r);
				return;
			}
			
			xajax_registrarHotel(   codHot , document.formTablaHoteles.nomHot.value , 
									document.formTablaHoteles.dirHot.value , document.formTablaHoteles.tel1Hot.value , 
									document.formTablaHoteles.tel2Hot.value , document.formTablaHoteles.celHot.value , 
									document.formTablaHoteles.conHot.value, document.formTablaHoteles.selTipoUbi.value,
                  document.formTablaHoteles.selOficina.value);	
		}
		if(tabla == 'usuarios'){
			var codUsr = document.formTablaUsuarios.codUsr.value.toLowerCase();
			var clave = document.formTablaUsuarios.clave.value;
			var nombre = document.formTablaUsuarios.nombre.value;
			var apellidos = document.formTablaUsuarios.apellidos.value;
			var codRol = document.formTablaUsuarios.codRol.value;
			var selCliente = document.formTablaUsuarios.selCliente.value
			
			if(codRol == 'CLI'){
				r = verificarCamposObligatorios(new Array(codUsr,getValueXML('formTablaUsuarios','codUsr')), 
												new Array(clave,getValueXML('formTablaUsuarios','clave')),
												new Array(nombre,getValueXML('formTablaUsuarios','nombre')), 
												new Array(apellidos,getValueXML('formTablaUsuarios','apellidos')),
												new Array(selCliente,getValueXML('formTablaDatosReporte','selCliente'))
												);
			} else{
				r = verificarCamposObligatorios(new Array(codUsr,getValueXML('formTablaUsuarios','codUsr')), 
												new Array(clave,getValueXML('formTablaUsuarios','clave')),
												new Array(nombre,getValueXML('formTablaUsuarios','nombre')), 
												new Array(apellidos,getValueXML('formTablaUsuarios','apellidos'))
												);
				selCliente = '<NULL>';
			}
			
			if(r!=''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
			
			r = verificarLongitudCampos(new Array(codUsr,getValueXML('formTablaUsuarios','codUsr'),15), 
										new Array(clave,getValueXML('formTablaUsuarios','clave'),15),
										new Array(nombre,getValueXML('formTablaUsuarios','nombre'),20), 
										new Array(apellidos,getValueXML('formTablaUsuarios','apellidos'),15)
										);
			
			if(r!=''){
				alert('Error\n'+r);
				return;
			}
			
			
			xajax_registrarUsuario( document.formTablaUsuarios.codUsr.value , document.formTablaUsuarios.clave.value , 
									document.formTablaUsuarios.codRol.value , document.formTablaUsuarios.nombre.value , 
									document.formTablaUsuarios.apellidos.value, selCliente);	
		}
		if(tabla == 'nacionalidades'){
			var codNac = document.formTablaNacionalidades.codNac.value.toUpperCase();
			var nacional = document.formTablaNacionalidades.nacional.value;
			r = verificarCamposObligatorios(new Array(codNac,getValueXML('formTablaNacionalidades','codNac')), 
											new Array(nacional,getValueXML('formTablaNacionalidades','nacional')));
			
			if(r!=''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
			
			if(codNac.length != 3){
				mostrarMsg('errorLongitudNac','3','errorLongitud');
				return;
			}
			
			r = verificarLongitudCampos(new Array(codNac,getValueXML('formTablaNacionalidades','codNac'),3), 
										new Array(nacional,getValueXML('formTablaNacionalidades','nacional'),20)
										);
			
			if(r!=''){
				alert('Error\n'+r);
				return;
			}
			
			xajax_registrarNacionalidad( codNac, document.formTablaNacionalidades.nacional.value);
		}
		if(tabla == 'proveedores'){
			var codPro = document.formTablaProveedores.codPro.value.toUpperCase();
			var nomPro = document.formTablaProveedores.nomPro.value;
			
			var dirPro = document.formTablaProveedores.dirPro.value ;
			var tel1Pro = document.formTablaProveedores.tel1Pro.value;
			var tel2Pro = document.formTablaProveedores.tel2Pro.value;
			var celPro = document.formTablaProveedores.celPro.value;
			var conPro = document.formTablaProveedores.conPro.value;
			
			r = verificarCamposObligatorios(new Array(codPro,getValueXML('formTablaProveedores','codPro')), 
                                      new Array(nomPro,getValueXML('formTablaProveedores','nomPro')),
                                      new Array(nomPro,getValueXML('formTablaProveedores','tel2Pro'))
                                      );
			
			if(r!=''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
			
			if(codPro.length != 5){
				mostrarMsg('errorLongitudProveedor','5','errorLongitud');
				return;
			}
      
			r = verificarLongitudCampos(new Array(codPro,getValueXML('formTablaProveedores','codPro'),7), 
										new Array(nomPro,getValueXML('formTablaProveedores','nomPro'),30),
										new Array(dirPro,getValueXML('formTablaProveedores','dirPro'),50),
										new Array(tel1Pro,getValueXML('formTablaProveedores','tel1Pro'),10),
										new Array(tel2Pro,getValueXML('formTablaProveedores','tel2Pro'),10),
										new Array(celPro,getValueXML('formTablaProveedores','celPro'),10),
										new Array(conPro,getValueXML('formTablaProveedores','conPro'),50)
										);
			
			if(r!=''){
				alert('Error\n'+r);
				return;
			}
			
			xajax_registrarProveedor(codPro, document.formTablaProveedores.nomPro.value , 
									document.formTablaProveedores.dirPro.value , document.formTablaProveedores.tel1Pro.value , 
									document.formTablaProveedores.tel2Pro.value , document.formTablaProveedores.celPro.value , 
									document.formTablaProveedores.conPro.value);
		}
    
    if(tabla == 'paquetes'){
			var codPaq = document.formTablaPaquetes.codPaq.value.toUpperCase();
			var nomPaq = document.formTablaPaquetes.nomPaq.value;
			var desPaq = document.formTablaPaquetes.desPaq.value ;
			var selOfiPaq = document.formTablaPaquetes.selOfiPaq.value ;
      
			
			r = verificarCamposObligatorios(new Array(codPaq,getValueXML('formTablaPaquetes','codPaq')), 
                                      new Array(nomPaq,getValueXML('formTablaPaquetes','nomPaq')),
                                      new Array(desPaq,getValueXML('formTablaPaquetes','desPaq'))
                                      );
			
			if(r!=''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
			
			if(codPaq.length > 7){
				mostrarMsg('errorLongitudPaquete','7','errorLongitud');
				return;
			}
      
			r = verificarLongitudCampos(new Array(codPaq,getValueXML('formTablaPaquetes','codPaq'),7), 
                                  new Array(nomPaq,getValueXML('formTablaPaquetes','nomPaq'),50),
                                  new Array(desPaq,getValueXML('formTablaPaquetes','desPaq'),500)
                                  );
			
			if(r!=''){
				alert('Error\n'+r);
				return;
			}
			
			xajax_registrarPaquete(codPaq, nomPaq, desPaq, selOfiPaq);
		}
    
		if(tabla == 'vuelos'){
			var selTipoVlo = document.formTablaVuelos.selTipoVlo.value;
			var nroVlo = document.formTablaVuelos.nroVlo.value.toUpperCase();
			var horaVlo = document.formTablaVuelos.horaVlo.value;
			
			r = verificarCamposObligatorios(new Array(selTipoVlo,getValueXML('formTablaVuelos','selTipoVlo')),
											new Array(horaVlo,getValueXML('formTablaTransfer','horaVlo')),
											new Array(nroVlo,getValueXML('formTablaVuelos','nroVlo')));
			
			if(r!=''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
			
			if(nroVlo.length != 6){
				mostrarMsg('errorLongitudVlo','6','errorLongitud');
				return;
			}
			
			r = verificarLongitudCampos(new Array(horaVlo,getValueXML('formTablaTransfer','horaVlo'),8),
										new Array(nroVlo,getValueXML('formTablaVuelos','nroVlo'),10)
										);
			
			if(r!=''){
				alert('Error\n'+r);
				return;
			}
			
			xajax_registrarVuelo(selTipoVlo, nroVlo, document.formTablaVuelos.horaVlo.value);
		}
		if(tabla == 'consecutivos'){
			var selTipoConsec = document.formTablaConsecutivos.selTipoConsec.value;
			var desde = document.formTablaConsecutivos.desde.value;
			var hasta = document.formTablaConsecutivos.hasta.value;
			
			r = verificarCamposObligatorios(new Array(selTipoConsec,getValueXML('formTablaConsecutivos','selTipoConsec')), 
											new Array(desde,getValueXML('formTablaConsecutivos','desde')),
											new Array(hasta,getValueXML('formTablaConsecutivos','hasta')));
			
			if(r!=''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
			xajax_registrarConsecutivo( selTipoConsec , desde, hasta);
		}
	};
	
	function actualizarEnTabla(){
		if(tabla == 'agencias'){
			var codAge = document.formTablaAgencias.codAge.value.toUpperCase();
			var nomAge = document.formTablaAgencias.nomAge.value;
			r = verificarCamposObligatorios(new Array(codAge,getValueXML('formTablaAgencias','codAge')), 
											new Array(nomAge,getValueXML('formTablaAgencias','nomAge')));
			
			if(r!=''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
			xajax_actualizarAgencia(document.formTablaAgencias.selTipoAge.value, 
									document.formTablaAgencias.codAge.value.toUpperCase() , document.formTablaAgencias.nomAge.value , 
									document.formTablaAgencias.dirAge.value , document.formTablaAgencias.ciuAge.value , 
									document.formTablaAgencias.tel1Age.value , document.formTablaAgencias.tel2Age.value , 
									document.formTablaAgencias.celAge.value , document.formTablaAgencias.contacAge.value , 
                  document.formTablaAgencias.nitAge.value);					
		}
		if(tabla == 'servicios'){
			var codSer = document.formTablaServicios.codSer.value;
			var nomSer = document.formTablaServicios.nomSer.value;
			r = verificarCamposObligatorios(new Array(codSer,getValueXML('formTablaServicios','codSer')), 
											new Array(nomSer,getValueXML('formTablaServicios','nomSer')));
			
			if(r!=''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
			var datosProveedoresSer = '';
			<?php	
				$i = 1;
				echo"datosProveedoresSer = datosProveedoresSer ";
				foreach ($proveedoresBase as &$pro){
					if($i < 2){
						echo"+ '".$pro['cod']."' + ':' + getProveedorSer(".$pro['it'].") + ':' + getProveedorCosSer(".$pro['it'].") + ':' ";
					}else{
						echo"+ '/,/' + '".$pro['cod']."' + ':' + getProveedorSer(".$pro['it'].") + ':' + getProveedorCosSer(".$pro['it'].") + ':' ";
					}
					$i++;
				}	
				echo" + '/,//;/';\n";
			?>		
			xajax_actualizarServicio(document.formTablaServicios.codSer.value , document.formTablaServicios.nomSer.value , 
									document.formTablaServicios.selDefecto.value , document.formTablaServicios.ordenSale.value , 
									datosProveedoresSer,
									document.formTablaServicios.precXPaxAd.value, document.formTablaServicios.precXPaxIn.value);	
		}
		if(tabla == 'hoteles'){
			var codHot = document.formTablaHoteles.codHot.value;
			var nomHot = document.formTablaHoteles.nomHot.value;
			r = verificarCamposObligatorios(new Array(codHot,getValueXML('formTablaHoteles','codHot')), 
											new Array(nomHot,getValueXML('formTablaHoteles','nomHot')));
			
			if(r!=''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
			xajax_actualizarHotel(  document.formTablaHoteles.codHot.value , document.formTablaHoteles.nomHot.value , 
									document.formTablaHoteles.dirHot.value , document.formTablaHoteles.tel1Hot.value , 
									document.formTablaHoteles.tel2Hot.value , document.formTablaHoteles.celHot.value , 
									document.formTablaHoteles.conHot.value , document.formTablaHoteles.selTipoUbi.value,
                  document.formTablaHoteles.selOficina.value);	
		}
		if(tabla == 'usuarios'){
			var codUsr = document.formTablaUsuarios.codUsr.value;
			var clave = document.formTablaUsuarios.clave.value;
			var nombre = document.formTablaUsuarios.nombre.value;
			var apellidos = document.formTablaUsuarios.apellidos.value;											
			var codRol = document.formTablaUsuarios.codRol.value;
			var selCliente = document.formTablaUsuarios.selCliente.value
			
			if(codRol == 'CLI'){
				r = verificarCamposObligatorios(new Array(codUsr,getValueXML('formTablaUsuarios','codUsr')), 
												new Array(clave,getValueXML('formTablaUsuarios','clave')),
												new Array(nombre,getValueXML('formTablaUsuarios','nombre')), 
												new Array(apellidos,getValueXML('formTablaUsuarios','apellidos')),
												new Array(selCliente,getValueXML('formTablaDatosReporte','selCliente'))
												);
			} else{
				r = verificarCamposObligatorios(new Array(codUsr,getValueXML('formTablaUsuarios','codUsr')), 
												new Array(clave,getValueXML('formTablaUsuarios','clave')),
												new Array(nombre,getValueXML('formTablaUsuarios','nombre')), 
												new Array(apellidos,getValueXML('formTablaUsuarios','apellidos'))
												);
				selCliente = '<NULL>';
			}
			
			if(r!=''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
			xajax_actualizarUsuario(document.formTablaUsuarios.codUsr.value , document.formTablaUsuarios.clave.value , 
									document.formTablaUsuarios.codRol.value , document.formTablaUsuarios.nombre.value , 
									document.formTablaUsuarios.apellidos.value, selCliente);	
		}
		if(tabla == 'nacionalidades'){
			var codNac = document.formTablaNacionalidades.codNac.value;
			var nacional = document.formTablaNacionalidades.nacional.value;
			r = verificarCamposObligatorios(new Array(codNac,getValueXML('formTablaNacionalidades','codNac')), 
											new Array(nacional,getValueXML('formTablaNacionalidades','nacional')));
			
			if(r!=''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
			xajax_actualizarNacionalidad( document.formTablaNacionalidades.codNac.value , document.formTablaNacionalidades.nacional.value);
		}
		if(tabla == 'proveedores'){
			var codPro = document.formTablaProveedores.codPro.value;
			var nomPro = document.formTablaProveedores.nomPro.value;
			r = verificarCamposObligatorios(new Array(codPro,getValueXML('formTablaProveedores','codPro')), 
											new Array(nomPro,getValueXML('formTablaProveedores','nomPro')));
			
			if(r!=''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
			xajax_actualizarProveedor( 	document.formTablaProveedores.codPro.value , document.formTablaProveedores.nomPro.value , 
										document.formTablaProveedores.dirPro.value , document.formTablaProveedores.tel1Pro.value , 
										document.formTablaProveedores.tel2Pro.value , document.formTablaProveedores.celPro.value , 
										document.formTablaProveedores.conPro.value);
		}
    
    if(tabla == 'paquetes'){
			var codPaq = document.formTablaPaquetes.codPaq.value.toUpperCase();
			var nomPaq = document.formTablaPaquetes.nomPaq.value;
			var desPaq = document.formTablaPaquetes.desPaq.value ;
			var selOfiPaq = document.formTablaPaquetes.selOfiPaq.value ;
      
			
			r = verificarCamposObligatorios(new Array(codPaq,getValueXML('formTablaPaquetes','codPaq')), 
                                      new Array(nomPaq,getValueXML('formTablaPaquetes','nomPaq')),
                                      new Array(desPaq,getValueXML('formTablaPaquetes','desPaq'))
                                      );
			
			if(r!=''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
			xajax_actualizarPaquete(codPaq,nomPaq,desPaq,selOfiPaq);
		}
    
	};
	
	function retirarEnTabla(){
		if(tabla == 'agencias'){
			xajax_retirarAgencia(document.formTablaAgencias.codAge.value);					
		}
		if(tabla == 'servicios'){
			xajax_retirarServicio(document.formTablaServicios.codSer.value);					
		}
		if(tabla == 'hoteles'){
			xajax_retirarHotel(document.formTablaHoteles.codHot.value);					
		}
		if(tabla == 'usuarios'){
			xajax_retirarUsuario(document.formTablaUsuarios.codUsr.value);					
		}
		if(tabla == 'nacionalidades'){
			xajax_retirarNacionalidad(document.formTablaNacionalidades.codNac.value);	
		}
		if(tabla == 'proveedores'){
			xajax_retirarProveedor(document.formTablaProveedores.codPro.value);	
		}
    if(tabla == 'paquetes'){
			xajax_retirarPaquete(document.formTablaPaquetes.codPaq.value);	
		}
		if(tabla == 'vuelos'){	
			xajax_retirarVuelo(document.formTablaVuelos.selTipoVlo.value, document.formTablaVuelos.nroVlo.value);		
		}
	};	
	
	function cancelarEnTabla(){
		if(tabla == 'agencias'){
			iniCancelarAgencia();
		}
		if(tabla == 'servicios'){
			iniCancelarServicio();
		}
		if(tabla == 'hoteles'){
			iniCancelarHotel();
		}
		if(tabla == 'usuarios'){
			iniCancelarUsuario();
		}
		if(tabla == 'nacionalidades'){
			iniCancelarNacionalidad();
		}
		if(tabla == 'proveedores'){
			iniCancelarProveedor();
		}
    if(tabla == 'paquetes'){
			iniCancelarPaquete();
		}
		if(tabla == 'vuelos'){
			iniCancelarVuelo();
		}
		if(tabla == 'consecutivos'){
			iniCancelarConsecutivo();
		}
	};
	
	function setValorPro(){
		<?php	
		
			foreach ($proveedoresBase as &$pro){
				echo"if (getProveedorSer(".$pro['it'].")=='true'){\n
						var costo = getProveedorCosSer(".$pro['it'].");\n
						document.formProveedores.option".$pro['cod'].".checked = true;\n
						document.getElementById('cell".$pro['cod']."').style.backgroundColor='#CBEEF5';\n
						document.getElementById('cell".$pro['cod']."CosSer').style.backgroundColor='#CBEEF5';\n
						document.getElementById('cosSer".$pro['cod']."').value=costo;\n
						document.getElementById('cell".$pro['cod']."CosSer').style.display='';\n
					 }else{\n
						document.formProveedores.option".$pro['cod'].".checked = false;\n
						document.getElementById('cell".$pro['cod']."').style.backgroundColor='#FFFFFF';\n
						document.getElementById('cell".$pro['cod']."CosSer').style.backgroundColor='#FFFFFF';\n
						document.getElementById('cosSer".$pro['cod']."').value='';\n
						document.getElementById('cell".$pro['cod']."CosSer').style.display='none';\n
					 }\n
					 
					";
			}
										
		?>
		document.getElementById('textoNomProveedores').innerHTML=getValueXML('formProveedores','textoSelectProveedoresSer')+' '+document.formTablaServicios.nomSer.value+':';	
	};
	
	function seleccionarProveedorSer(itpro,dato,celda)
	{
		var celda2 = ''+celda+'CosSer'; 
		if (dato == true){
			setProveedorSer(itpro,'true');
			document.getElementById(celda).style.backgroundColor='#CBEEF5';
			document.getElementById(celda2).style.backgroundColor='#CBEEF5';
			document.getElementById(celda2).style.display='';
		}
		else{ 
			setProveedorSer(itpro,'false');
			document.getElementById(celda).style.backgroundColor='#FFFFFF';
			document.getElementById(celda2).style.backgroundColor='#FFFFFF';
			document.getElementById(celda2).style.display='none';
		}	
	};
	
	function seleccionarProveedorSerCheck(itpro,idCheck,celda)
	{
		var celda2 = ''+celda+'CosSer'; 
		if (document.getElementById(idCheck).checked == true){
			document.getElementById(idCheck).checked = false;
			setProveedorSer(itpro,'false');
			document.getElementById(celda).style.backgroundColor='#FFFFFF';
			document.getElementById(celda2).style.backgroundColor='#FFFFFF';
			document.getElementById(celda2).style.display='none';
		}		
		else{				
			document.getElementById(idCheck).checked = true;
			setProveedorSer(itpro,'true');
			document.getElementById(celda).style.backgroundColor='#CBEEF5';
			document.getElementById(celda2).style.backgroundColor='#CBEEF5';
			document.getElementById(celda2).style.display='';
		}
	};
	
	function seleccionarProveedorCosSer(itpro,dato)
	{
		setProveedorCosSer(itpro,dato);	
	};

	function llenarTablaVuelosSearch(tipoVlo, nVlo){
		xajax_llenarTablaVuelosSearch(tipoVlo, nVlo);
	};
	
	$(document).ready(function(){
		//Examples of how to assign the ColorBox event to elements
		$(".boxConsultarAgencia").colorbox({width:"400px", inline:true, href:"#consultaAgencia"});
		$(".boxConsultarServicio").colorbox({width:"400px",  inline:true, href:"#consultaServicio"});
		$(".boxConsultarHotel").colorbox({width:"400px", inline:true, href:"#consultaHotel"});
		$(".boxConsultarProveedor").colorbox({width:"400px", inline:true, href:"#consultaProveedor"});
		$(".boxConsultarPaquete").colorbox({width:"400px", inline:true, href:"#consultaPaquete"});
		$(".boxConsultarUsuario").colorbox({width:"400px", inline:true, href:"#consultaUsuario"});
		$(".boxConsultarNacionalidad").colorbox({width:"400px", inline:true, href:"#consultaNacionalidad"});
		$(".boxProveedores").colorbox({width:"500px", width:"500px", inline:true, href:"#selectProveedores"});
		$(".boxConsultarVuelo").colorbox({height:"700px", width:"440px", inline:true, href:"#consultaVuelo"});
		$(".boxConsultarConsecutivo").colorbox({height:"550px", width:"600px", inline:true, href:"#consultaConsecutivo"});		
		
		$(".closebuttonAgencia").live('click', function(){
			opcionBox = 'conAgencia'; resultadoBox = '0'; xajax_llenarTablaAgencias(document.formConsultaAgencia.conAgencia.value); 
		});
		
		$(".closebuttonServicio").live('click', function(){
			opcionBox = 'conServicio'; resultadoBox = '0'; xajax_llenarTablaServicios(document.formConsultaServicio.conServicio.value); 
		});
		
		$(".closebuttonHotel").live('click', function(){
			opcionBox = 'conHotel'; resultadoBox = '0'; xajax_llenarTablaHoteles(document.formConsultaHotel.conHotel.value); 
		});
		
		$(".closebuttonUsuario").live('click', function(){
			opcionBox = 'conUsuario'; resultadoBox = '0'; xajax_llenarTablaUsuarios(document.formConsultaUsuario.conUsuario.value); 
		});
		
		$(".closebuttonNacionalidad").live('click', function(){
			opcionBox = 'conNacionalidad'; resultadoBox = '0'; xajax_llenarTablaNacionalidades(document.formConsultaNacionalidad.conNacionalidad.value); 
		});
		
		$(".closebuttonProveedor").live('click', function(){
			opcionBox = 'conProveedor'; resultadoBox = '0'; xajax_llenarTablaProveedores(document.formConsultaProveedor.conProveedor.value); 
		});
    
    $(".closebuttonPaquete").live('click', function(){
			opcionBox = 'conPaquete'; resultadoBox = '0'; xajax_llenarTablaPaquetes(document.formConsultaPaquete.conPaquete.value); 
		});
		
		$(".closebuttonVuelo").live('click', function(){
			opcionBox = 'conVuelo'; resultadoBox = '0'; 
			xajax_llenarTablaVuelos(document.formConsultaVuelo.selTipoVloHidden.value, document.formConsultaVuelo.nroVloHidden.value); 
		});
		
		$(".closebuttonConsecutivo").live('click', function(){
			$.fn.colorbox.close();
		});
		
		$(document).bind('cbox_closed', function() {
			if(opcionBox == 'conAgencia'){
				if(resultadoBox == '0'){
					alert('Cliente no encontrado.');
				}else{
					document.formTablaAgencias.btnIngresarTabla.disabled='';
					document.formTablaAgencias.btnGuardarTabla.disabled='disabled';
					document.formTablaAgencias.btnConsultarAgencia.disabled='';
					document.formTablaAgencias.btnActualizarTabla.disabled='';
					document.formTablaAgencias.btnRetirarTabla.disabled='';
					document.formTablaAgencias.btnCancelarTabla.disabled='';
				}	
			}
			if(opcionBox == 'conServicio'){
				if(resultadoBox == '0'){
					alert('Servicio no encontrado.');
				}else{
					document.formTablaServicios.btnIngresarTabla.disabled='';
					document.formTablaServicios.btnGuardarTabla.disabled='disabled';
					document.formTablaServicios.btnConsultarServicio.disabled='';
					document.formTablaServicios.btnActualizarTabla.disabled='';
					document.formTablaServicios.btnRetirarTabla.disabled='';
					document.formTablaServicios.btnCancelarTabla.disabled='';
				}	
			}
			if(opcionBox == 'conHotel'){
				if(resultadoBox == '0'){
					alert('Hotel no encontrado.');
				}else{
					document.formTablaHoteles.btnIngresarTabla.disabled='';
					document.formTablaHoteles.btnGuardarTabla.disabled='disabled';
					document.formTablaHoteles.btnConsultarHotel.disabled='';
					document.formTablaHoteles.btnActualizarTabla.disabled='';
					document.formTablaHoteles.btnRetirarTabla.disabled='';
					document.formTablaHoteles.btnCancelarTabla.disabled='';
				}	
			}
			if(opcionBox == 'conUsuario'){
				if(resultadoBox == '0'){
					alert('Usuario no encontrado.');
				}else{
					document.formTablaUsuarios.btnIngresarTabla.disabled='';
					document.formTablaUsuarios.btnGuardarTabla.disabled='disabled';
					document.formTablaUsuarios.btnConsultarUsuario.disabled='';
					document.formTablaUsuarios.btnActualizarTabla.disabled='';
					document.formTablaUsuarios.btnRetirarTabla.disabled='';
					document.formTablaUsuarios.btnCancelarTabla.disabled='';
				}	
			}
			if(opcionBox == 'conNacionalidad'){
				if(resultadoBox == '0'){
					alert('Nacionalidad no encontrada.');
				}else{
					document.formTablaNacionalidades.btnIngresarTabla.disabled='';
					document.formTablaNacionalidades.btnGuardarTabla.disabled='disabled';
					document.formTablaNacionalidades.btnConsultarNacionalidad.disabled='';
					document.formTablaNacionalidades.btnActualizarTabla.disabled='';
					document.formTablaNacionalidades.btnRetirarTabla.disabled='';
					document.formTablaNacionalidades.btnCancelarTabla.disabled='';
				}	
			}
			if(opcionBox == 'conProveedor'){
				if(resultadoBox == '0'){
					alert('Proveedor no encontrado.');
				}else{
					document.formTablaProveedores.btnIngresarTabla.disabled='';
					document.formTablaProveedores.btnGuardarTabla.disabled='disabled';
					document.formTablaProveedores.btnConsultarProveedor.disabled='';
					document.formTablaProveedores.btnActualizarTabla.disabled='';
					document.formTablaProveedores.btnRetirarTabla.disabled='';
					document.formTablaProveedores.btnCancelarTabla.disabled='';
				}	
			}
			if(opcionBox == 'conPaquete'){
				if(resultadoBox == '0'){
					alert('Paquete no encontrado.');
				}else{
					document.formTablaPaquetes.btnIngresarTabla.disabled='';
					document.formTablaPaquetes.btnGuardarTabla.disabled='disabled';
					document.formTablaPaquetes.btnConsultarPaquete.disabled='';
					document.formTablaPaquetes.btnActualizarTabla.disabled='';
					document.formTablaPaquetes.btnRetirarTabla.disabled='';
					document.formTablaPaquetes.btnCancelarTabla.disabled='';
				}	
			}
			if(opcionBox == 'conVuelo'){
				if(resultadoBox == '0'){
					alert('Vuelo no encontrado.');
				}else{
					document.formTablaVuelos.btnIngresarTabla.disabled='';
					document.formTablaVuelos.btnGuardarTabla.disabled='disabled';
					document.formTablaVuelos.btnConsultarVuelo.disabled='';
					document.formTablaVuelos.btnActualizarTabla.disabled='disabled';
					document.formTablaVuelos.btnRetirarTabla.disabled='';
					document.formTablaVuelos.btnCancelarTabla.disabled='';
				}	
			}
		});
		
		$(document).bind('cbox_complete', function(){
			if(opcionBox == 'conAgenciasIni'){
				document.formConsultaAgencia.conAgencia.value = '';
				pasarFoco('conAgencia');
			}
			if(opcionBox == 'conServiciosIni'){
				document.formConsultaServicio.conServicio.value = '';
				pasarFoco('conServicio');
			}
			if(opcionBox == 'conHotelesIni'){
				document.formConsultaHotel.conHotel.value = '';
				pasarFoco('conHotel');
			}
			if(opcionBox == 'conUsuariosIni'){
				document.formConsultaUsuario.conUsuario.value = '';
				pasarFoco('conUsuario');
			}
			if(opcionBox == 'conNacionalidadesIni'){
				document.formConsultaNacionalidad.conNacionalidad.value = '';
				pasarFoco('conNacionalidad');
			}
			if(opcionBox == 'conProveedoresIni'){
				document.formConsultaProveedor.conProveedor.value = '';
				pasarFoco('conProveedor');
			}
      if(opcionBox == 'conPaquetesIni'){
				document.formConsultaPaquete.conPaquete.value = '';
				pasarFoco('conPaquete');
			}
			if(opcionBox == 'conVuelosIni'){
				document.formConsultaVuelo.conSelTipoVlo.value = 'IN';
				document.formConsultaVuelo.conNroVlo.value = '';
				pasarFoco('conSelTipoVlo');
			}
			if(opcionBox == 'selecProveedores'){
				//NULL
			}			
		});
		
	});	
			
</script>
<br>
<div id='tablaAgencias' style='display:none; background:#fff;'>	
	<form name="formTablaAgencias" id="formTablaAgencias">
	<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
	<tr>
	<td width="20%">&nbsp;
		
	</td>
	
	<td width="60%">
		<table border="1" width="100%" height="100%" cellpadding="0" cellspacing="0">
		<tr>
		<td>
		
		<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
			<tr bgcolor="#1373A6">
				<td align="center">
				<p class="textoTituloTablas"> 
					<?php printValueXML('formTablaAgencias','etiqAgencias'); ?>	
				</p>
				</td>	
			</tr>
					
			<tr>
				<td>
				<p class="textoFormTablas">
					<?php printValueXML('formTablaAgencias','selTipoAge'); ?>
					<select name="selTipoAge" id="selTipoAge" class="selSelTipoAge">
						<option value='AG' selected='selected'>Agencia</option>
						<!-- <option value='CF'>Cliente Final</option> -->
					</select>&nbsp;&nbsp;
					<?php printValueXML('formTablaAgencias','codAge'); ?> <input type="text" id="codAge" name="codAge" placeholder="5 char" maxlength="5" class="cajaCodAge" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaAgencias.nitAge.id)" />&nbsp;&nbsp;					
          <?php printValueXML('formTablaAgencias','nitAge'); ?> <input type="text" id="nitAge" name="nitAge" class="cajaNitAge" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaAgencias.nomAge.id)" />
				</p>
				</td>	
			</tr>
      <tr>
				<td>
				<p class="textoFormTablas">
					<?php printValueXML('formTablaAgencias','nomAge'); ?> <input type="text" id="nomAge" name="nomAge" class="cajaNomAge" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaAgencias.tel2Age.id)" />&nbsp;&nbsp;&nbsp;&nbsp;
          <?php printValueXML('formTablaAgencias','tel2Age'); ?> <input type="text" id="tel2Age" name="tel2Age" class="cajaNitAge" placeholder="opcional" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaAgencias.dirAge.id)" />
				</p>	
				</td>	
			</tr>	
			<tr>
				<td>
				<p class="textoFormTablas">
					<?php printValueXML('formTablaAgencias','dirAge'); ?> <input type="text" id="dirAge" name="dirAge" class="cajaDirAge" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaAgencias.ciuAge.id)" />&nbsp;&nbsp;
					<?php printValueXML('formTablaAgencias','ciuAge'); ?> <input type="text" id="ciuAge" name="ciuAge" class="cajaCiuAge" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaAgencias.tel1Age.id)" />
				</p>	
				</td>	
			</tr>	
			<tr>
				<td>
				<p class="textoFormTablas">
					<?php printValueXML('formTablaAgencias','tel1Age'); ?> <input type="text" id="tel1Age" name="tel1Age" class="cajaTelAge" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaAgencias.tel2Age.id)" />&nbsp;&nbsp;
					<?php printValueXML('formTablaAgencias','celAge'); ?> <input type="text" id="celAge" name="celAge" class="cajaCelAge" placeholder="opcional" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaAgencias.contacAge.id)" />
				</p>	
				</td>	
			</tr>
			<tr>
				<td>
				<p class="textoFormTablas">
					<?php printValueXML('formTablaAgencias','contacAge'); ?> <input type="text" id="contacAge" name="contacAge" class="cajaContacAge" onKeyUp="" />
				</p>	
				</td>	
			</tr>
			
			<?php include "library/botonesTablas1.php"; ?>								
					<input type="button" class="boxConsultarAgencia boton btnTablas2" id="btnConsultarAgencia" name="btnConsultarAgencia" value="<?php printValueXML('formTablas','btnConsultar') ?>" onclick="opcionBox = 'conAgenciasIni';" />&nbsp;&nbsp;&nbsp;										
			<?php include "library/botonesTablas2.php"; ?>							
										
		</table>	
		
		</td>	
		</tr>		
		</table>					
	</td>
	
	<td width="20%">&nbsp;
		
	</td>
	</tr>
	</table>
	</form>		
</div>


<div id='tablaServicios' style='display:none; background:#fff;'>	
	<form name="formTablaServicios" id="formTablaServicios">
	<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
	<tr>
	<td width="20%">&nbsp;
		
	</td>
	
	<td width="60%">
		<table border="1" width="100%" height="100%" cellpadding="0" cellspacing="0">
		<tr>
		<td>
		
		<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
			<tr bgcolor="#1373A6">
				<td align="center">
				<p class="textoTituloTablas"> 
					<?php printValueXML('formTablaServicios','etiqServicios'); ?>	
				</p>
				</td>	
			</tr>
					
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formTablaServicios','codSer'); ?> <input type="text" id="codSer" name="codSer" placeholder="5 char" maxlength="5" class="cajaCodSer" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaServicios.nomSer.id)" />&nbsp;&nbsp;
					<?php printValueXML('formTablaServicios','nomSer'); ?> <input type="text" id="nomSer" name="nomSer" class="cajaNomSer" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaServicios.ordenSale.id)" />
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formTablaServicios','selDefecto'); ?>
					<select name="selDefecto" id="selDefecto" class="selSelDefecto">
						<option value='NO' selected='selected'>NO</option>
						<option value='SI'>SI</option>
					</select>&nbsp;&nbsp;
					<?php printValueXML('formTablaServicios','ordenSale'); ?> <input type="text" id="ordenSale" name="ordenSale" class="cajaOrdenSale" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaServicios.ordenSale.id)" />&nbsp;&nbsp;
					<input type="button" class="boxProveedores boton btnTablas3" id="btnSelecProveedores" name="btnSelecProveedores" value="<?php printValueXML('formTablaServicios','btnProveedores'); ?>" onclick="setValorPro(); opcionBox = 'selecProveedores';"/>
				</p>
				</td>	
			</tr>

			<tr>
				<td>
				<p class="textoFormTablas" style="visibility: hidden;"> 
					Precio X Adulto:&nbsp;<input type="text" id="precXPaxAd" name="precXPaxAd" class="cajaPrecXPax" />&nbsp;&nbsp;&nbsp;
					Precio X Ni&ntilde;o:&nbsp;<input type="text" id="precXPaxIn" name="precXPaxIn" class="cajaPrecXPax" />
				</p>
				</td>	
			</tr>

			<?php include "library/botonesTablas1.php"; ?>								
					<input type="button" class="boxConsultarServicio boton btnTablas2" id="btnConsultarServicio" name="btnConsultarServicio" value="<?php printValueXML('formTablas','btnConsultar') ?>" onclick="opcionBox = 'conServiciosIni';" />&nbsp;&nbsp;&nbsp;										
			<?php include "library/botonesTablas2.php"; ?>	
							
		</table>	
		
		</td>	
		</tr>		
		</table>					
	</td>
	
	<td width="20%">&nbsp;
		
	</td>
	</tr>
	</table>
	</form>	
</div>

<div id='tablaHoteles' style='display:none; background:#fff;'>
	<form name="formTablaHoteles" id="formTablaHoteles">
	<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
	<tr>
	<td width="20%">&nbsp;
		
	</td>
	
	<td width="60%">
		<table border="1" width="100%" height="100%" cellpadding="0" cellspacing="0">
		<tr>
		<td>
		
		<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
			<tr bgcolor="#1373A6">
				<td align="center">
				<p class="textoTituloTablas"> 
					<?php printValueXML('formTablaHoteles','etiqHoteles'); ?>
				</p>
				</td>	
			</tr>
					
			<tr>
				<td>
				<p class="textoFormTablas">
					<?php printValueXML('formTablaHoteles','selTipoUbi'); ?>
					<select name="selTipoUbi" id="selTipoUbi" class="selSelTipoUbi">
						<option value='HOT' selected='selected'>Hotel</option>
						<!--<option value='OTR'>Otra</option>-->
					</select>&nbsp;&nbsp;				
					<?php printValueXML('formTablaHoteles','codHot'); ?> <input type="text" id="codHot" name="codHot" class="cajaCodHot" placeholder="5 char" maxlength="5" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaHoteles.nomHot.id)" />&nbsp;&nbsp;
					<?php printValueXML('formTablaHoteles','nomHot'); ?> <input type="text" id="nomHot" name="nomHot" class="cajaNomHot" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaHoteles.dirHot.id)" />&nbsp;&nbsp;
          <?php printValueXML('formTablaHoteles','selOficina'); ?>
					<select name="selOficina" id="selOficina" class="selSelOficina">
						<?php printOpcionesCodOfi($_SESSION["oficina"]); ?>
					</select>
          
				</p>
				</td>	
			</tr>
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formTablaHoteles','dirHot'); ?> <input type="text" id="dirHot" placeholder="opcional" name="dirHot" class="cajaDirHot" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaHoteles.tel1Hot.id)" />&nbsp;&nbsp;
					<?php printValueXML('formTablaHoteles','tel1Hot'); ?> <input type="text" id="tel1Hot" placeholder="opcional" name="tel1Hot" class="cajaTel1Hot" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaHoteles.tel2Hot.id)" />&nbsp;&nbsp;
				</p>
				</td>	
			</tr>
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formTablaHoteles','tel2Hot'); ?> <input type="text" id="tel2Hot" placeholder="opcional" name="tel2Hot" class="cajaTel2Hot" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaHoteles.celHot.id)" />&nbsp;&nbsp;
					<?php printValueXML('formTablaHoteles','celHot'); ?> <input type="text" id="celHot" placeholder="opcional" name="celHot" class="cajaCelHot" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaHoteles.conHot.id)" />
				</p>
				</td>	
			</tr>
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formTablaHoteles','conHot'); ?> <input type="text" id="conHot" placeholder="opcional" name="conHot" class="cajaConHot" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaHoteles.conHot.id)" />
				</p>
				</td>	
			</tr>
			<?php include "library/botonesTablas1.php"; ?>								
					<input type="button" class="boxConsultarHotel boton btnTablas2" id="btnConsultarHotel" name="btnConsultarHotel" value="<?php printValueXML('formTablas','btnConsultar') ?>" onclick="opcionBox = 'conHotelesIni';" />&nbsp;&nbsp;&nbsp;										
			<?php include "library/botonesTablas2.php"; ?>								
		</table>	
		
		</td>	
		</tr>		
		</table>					
	</td>
	
	<td width="20%">&nbsp;
		
	</td>
	</tr>
	</table>
	</form>	
</div>

<div id='tablaProveedores' style='display:none; background:#fff;'>
	<form name="formTablaProveedores" id="formTablaProveedores">
	<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
	<tr>
	<td width="20%">&nbsp;
		
	</td>
	
	<td width="60%">
		<table border="1" width="100%" height="100%" cellpadding="0" cellspacing="0">
		<tr>
		<td>
		
		<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
			<tr bgcolor="#1373A6">
				<td align="center">
				<p class="textoTituloTablas"> 
					<?php printValueXML('formTablaProveedores','etiqProveedores'); ?>
				</p>
				</td>	
			</tr>
					
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formTablaProveedores','codPro'); ?> <input type="text" id="codPro" name="codPro" class="cajaCodPro" placeholder="5 char" maxlength="5" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaProveedores.nomPro.id)" />&nbsp;&nbsp;
					<?php printValueXML('formTablaProveedores','nomPro'); ?> <input type="text" id="nomPro" name="nomPro" class="cajaNomPro" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaProveedores.dirPro.id)" />&nbsp;&nbsp;
          <?php printValueXML('formTablaProveedores','tel2Pro'); ?> <input type="text" id="tel2Pro" name="tel2Pro" class="cajaTel2Pro" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaProveedores.celPro.id)" />
				</p>
				</td>	
			</tr>
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formTablaProveedores','dirPro'); ?> <input type="text" id="dirPro" name="dirPro" placeholder="opcional" class="cajaDirPro" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaProveedores.tel1Pro.id)" />&nbsp;&nbsp;
					<?php printValueXML('formTablaProveedores','tel1Pro'); ?> <input type="text" id="tel1Pro" name="tel1Pro" placeholder="opcional" class="cajaTel1Pro" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaProveedores.tel2Pro.id)" />&nbsp;&nbsp;
				</p>
				</td>	
			</tr>
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formTablaProveedores','celPro'); ?> <input type="text" id="celPro" name="celPro" placeholder="opcional" class="cajaCelPro" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaProveedores.conPro.id)" />
				</p>
				</td>	
			</tr>
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formTablaProveedores','conPro'); ?> <input type="text" id="conPro" name="conPro" placeholder="opcional" class="cajaConPro" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaProveedores.conPro.id)" />
				</p>
				</td>	
			</tr>
			<?php include "library/botonesTablas1.php"; ?>								
					<input type="button" class="boxConsultarProveedor boton btnTablas2" id="btnConsultarProveedor" name="btnConsultarProveedor" value="<?php printValueXML('formTablas','btnConsultar') ?>" onclick="opcionBox = 'conProveedoresIni';" />&nbsp;&nbsp;&nbsp;										
			<?php include "library/botonesTablas2.php"; ?>							
		</table>	
		
		</td>	
		</tr>		
		</table>					
	</td>
	
	<td width="20%">&nbsp;
		
	</td>
	</tr>
	</table>
	</form>
</div>

<div id='tablaPaquetes' style='display:none; background:#fff;'>
	<form name="formTablaPaquetes" id="formTablaPaquetes">
	<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
	<tr>
	<td width="20%">&nbsp;
		
	</td>
	
	<td width="60%">
		<table border="1" width="100%" height="100%" cellpadding="0" cellspacing="0">
		<tr>
		<td>
		
		<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
			<tr bgcolor="#1373A6">
				<td align="center">
				<p class="textoTituloTablas"> 
					<?php printValueXML('formTablaPaquetes','etiqPaquetes'); ?>
				</p>
				</td>	
			</tr>
					
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formTablaPaquetes','codPaq'); ?> <input type="text" id="codPaq" name="codPaq" class="cajaCodPaq" placeholder="7 char max" maxlength="7" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaPaquetes.nomPaq.id)" />&nbsp;&nbsp;
					<?php printValueXML('formTablaPaquetes','nomPaq'); ?> <input type="text" id="nomPaq" name="nomPaq" class="cajaNomPaq" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaPaquetes.desPaq.id)" />&nbsp;&nbsp;
          <?php printValueXML('formTablaPaquetes','selOficina'); ?>
					<select name="selOfiPaq" id="selOfiPaq" class="selSelOficina">
						<?php printOpcionesCodOfi($_SESSION["oficina"]); ?>
					</select>
				</p>
				</td>	
			</tr>
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formTablaPaquetes','desPaq'); ?> <input type="text" id="desPaq" name="desPaq" class="cajaDesPaq" />
				</p>
				</td>	
			</tr>
			<?php include "library/botonesTablas1.php"; ?>								
					<input type="button" class="boxConsultarPaquete boton btnTablas2" id="btnConsultarPaquete" name="btnConsultarPaquete" value="<?php printValueXML('formTablas','btnConsultar') ?>" onclick="opcionBox = 'conPaquetesIni';" />&nbsp;&nbsp;&nbsp;										
			<?php include "library/botonesTablas2.php"; ?>							
		</table>	
		
		</td>	
		</tr>		
		</table>					
	</td>
	
	<td width="20%">&nbsp;
		
	</td>
	</tr>
	</table>
	</form>
</div>

<?php
	/*$verifPermiso = false;
	$verifPermiso = verificarPermiso($_SESSION["user"], 'USU');
	if ($verifPermiso == true){
		
	}*/
	include "pages/tablaUsuarios.php";
?>


<div id='tablaNacionalidades' style='display:none; background:#fff;'>
	<form name="formTablaNacionalidades" id="formTablaNacionalidades">
	<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
	<tr>
	<td width="20%">&nbsp;
		
	</td>
	
	<td width="60%">
		<table border="1" width="100%" height="100%" cellpadding="0" cellspacing="0">
		<tr>
		<td>
		
		<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
			<tr bgcolor="#1373A6">
				<td align="center">
				<p class="textoTituloTablas"> 
					<?php printValueXML('formTablaNacionalidades','etiqNacionalidades'); ?>
				</p>
				</td>	
			</tr>
					
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formTablaNacionalidades','codNac'); ?> <input type="text" id="codNac" placeholder="3 char" maxlength="3" name="codNac" class="cajaCodNac" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaNacionalidades.nacional.id)" />&nbsp;&nbsp;
					<?php printValueXML('formTablaNacionalidades','nacional'); ?> <input type="text" id="nacional" name="nacional" class="cajaNacional" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaNacionalidades.nacional.id)" />
				</p>
				</td>	
			</tr>
			<?php include "library/botonesTablas1.php"; ?>								
					<input type="button" class="boxConsultarNacionalidad boton btnTablas2" id="btnConsultarNacionalidad" name="btnConsultarNacionalidad" value="<?php printValueXML('formTablas','btnConsultar') ?>" onclick="opcionBox = 'conNacionalidadesIni';" />&nbsp;&nbsp;&nbsp;										
			<?php include "library/botonesTablas2.php"; ?>							
		</table>	
		
		</td>	
		</tr>		
		</table>					
	</td>
	
	<td width="20%">&nbsp;
		
	</td>
	</tr>
	</table>
	</form>
</div>

<div id='tablaVuelos' style='display:none; background:#fff;'>
	<form name="formTablaVuelos" id="formTablaVuelos">
	<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
	<tr>
	<td width="20%">&nbsp;
		
	</td>
	
	<td width="60%">
		<table border="1" width="100%" height="100%" cellpadding="0" cellspacing="0">
		<tr>
		<td>
		
		<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
			<tr bgcolor="#1373A6">
				<td align="center">
				<p class="textoTituloTablas"> 
					<?php printValueXML('formTablaVuelos','etiqVuelos'); ?>
				</p>
				</td>	
			</tr>
					
			<tr>
				<td>
				<p class="textoFormTablas"> 			
					<?php printValueXML('formTablaVuelos','selTipoVlo'); ?>
					<select name="selTipoVlo" id="selTipoVlo" class="selSelTipoVlo">
						<option value='IN' selected='selected'>IN</option>
						<option value='OUT'>OUT</option>
					</select>&nbsp;&nbsp;&nbsp;&nbsp;					
					<?php printValueXML('formTablaVuelos','nroVlo'); ?> <input type="text" id="nroVlo" name="nroVlo" placeholder="6 char" maxlength="6" class="cajaNroVlo" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaVuelos.nroVlo.id)" />&nbsp;&nbsp;&nbsp;&nbsp;
					<a id='labelHoraVlo' name='labelHoraVlo'><?php printValueXML('formTablaTransfer','horaVlo'); ?> </a>
					<input type="text" id="horaVlo" name="horaVlo" class="cajaHoraVlo" onKeyUp="mascaraHora(this);" />
				</p>
				</td>	
			</tr>
			<?php include "library/botonesTablas1.php"; ?>								
					<input type="button" class="boxConsultarVuelo boton btnTablas2" id="btnConsultarVuelo" name="btnConsultarVuelo" value="<?php printValueXML('formTablas','btnConsultar') ?>" onclick="opcionBox = 'conVuelosIni';" />&nbsp;&nbsp;&nbsp;										
			<?php include "library/botonesTablas2.php"; ?>							
		</table>	
		
		</td>	
		</tr>		
		</table>					
	</td>
	
	<td width="20%">&nbsp;
		
	</td>
	</tr>
	</table>
	</form>
</div>

<div id='tablaConsecutivos' style='display:none; background:#fff;'>
	<form name="formTablaConsecutivos" id="formTablaConsecutivos">
	<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
	<tr>
	<td width="20%">&nbsp;
		
	</td>
	
	<td width="60%">
		<table border="1" width="100%" height="100%" cellpadding="0" cellspacing="0">
		<tr>
		<td>
		
		<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
			<tr bgcolor="#1373A6">
				<td align="center">
				<p class="textoTituloTablas"> 
					<?php printValueXML('formTablaConsecutivos','etiqConsecutivos'); ?>
				</p>
				</td>	
			</tr>
					
			<tr>
				<td>
				<p class="textoFormTablas">

					<a id='labelSelTipoConsec' name='labelSelTipoConsec'><?php printValueXML('formTablaConsecutivos','selTipoConsec'); ?> </a>
					<select name="selTipoConsec" id="selTipoConsec" class="selSelTipoConsec" onChange="">
						<option value='<NULL>' selected='selected'>- Seleccione -</option>
						<option value='IN NAC'>Transfer-IN NAC</option>
						<option value='IN INT'>Transfer-IN INT</option>
						<option value='OUT AQU'>Transfer-OUT AQU</option>
						<option value='OUT MAR'>Transfer-OUT MAR</option>
						<option value='OUT MRL'>Transfer-OUT MRL</option>
						<option value='OUT DEL'>Transfer-OUT DEL</option>
						<option value='OUT DEC'>Transfer-OUT DEC</option>
						<option value='OTR'>Otro</option>
					</select>&nbsp;&nbsp;&nbsp;&nbsp;
					
					<?php printValueXML('formTablaConsecutivos','desde'); ?> <input type="text" id="desde" name="desde" class="cajaDesde" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaConsecutivos.hasta.id)" />&nbsp;&nbsp;&nbsp;&nbsp;
					
					<?php printValueXML('formTablaConsecutivos','hasta'); ?> <input type="text" id="hasta" name="hasta" class="cajaHasta" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaConsecutivos.hasta.id)" />
				</p>
				</td>	
			</tr>
			<?php include "library/botonesTablas1.php"; ?>								
					<input type="button" class="boxConsultarConsecutivo boton btnTablas2" id="btnConsultarConsecutivo" name="btnConsultarConsecutivo" value="<?php printValueXML('formTablas','btnConsultar') ?>" onclick="opcionBox = 'conConsecutivosIni';" />&nbsp;&nbsp;&nbsp;										
			<?php include "library/botonesTablas2.php"; ?>							
		</table>	
		
		</td>	
		</tr>		
		</table>					
	</td>
	
	<td width="20%">&nbsp;
		
	</td>
	</tr>
	</table>
	</form>
</div>

<!-- --------------------------------------------------------------------------------------------------- -->
<div style='display:none'>		
	<div id='consultaAgencia' style='padding:10px; background:#fff;'>
		<form name="formConsultaAgencia" id="formConsultaAgencia">
			<a id='labelConsultaAgencia' name='labelConsultaAgencia' class='textoConsulta'><?php printValueXML('formConsultaAgencia','labelConsultaAgencia'); ?></a>
			<br><br>
			<!--<input type="text" id="conAgencia" name="conAgencia" class="cajaConsultaAgencia" />-->
			<select name="conAgencia" id="conAgencia" class="selServicio">
				<option value=''>----</option>
				<?php printOpcionesCodAge(); ?>
			</select>&nbsp;&nbsp;
			<input type="text" id="conHiddenAgencia" name="conHiddenAgencia" class="cajaConsultaReservaHidden" />	
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" id="btnConAgencia" name="btnConAgencia" value="<?php printValueXML('formTablas','btnConsultar') ?>" class="closebuttonAgencia" />
			<br>
		</form>	
	</div>		
</div>

<div style='display:none'>		
	<div id='consultaServicio' style='padding:10px; background:#fff;'>
		<form name="formConsultaServicio" id="formConsultaServicio">
			<a id='labelConsultaServicio' name='labelConsultaServicio' class='textoConsulta'><?php printValueXML('formConsultaServicio','labelConsultaServicio'); ?></a>
			<br><br>
			<!--<input type="text" id="conServicio" name="conServicio" class="cajaConsultaServicio" />-->
			<select name="conServicio" id="conServicio" class="selServicio">
				<option value=''>----</option>
				<?php printOpcionesCodSer(); ?>
			</select>&nbsp;&nbsp;
			<input type="text" id="conHiddenServicio" name="conHiddenServicio" class="cajaConsultaReservaHidden" />	
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" id="btnConServicio" name="btnConServicio" value="<?php printValueXML('formTablas','btnConsultar') ?>" class="closebuttonServicio" />
			<br>
		</form>	
	</div>		
</div>	

<div style='display:none'>		
	<div id='consultaHotel' style='padding:10px; background:#fff;'>
		<form name="formConsultaHotel" id="formConsultaHotel">
			<a id='labelConsultaHotel' name='labelConsultaHotel' class='textoConsulta'><?php printValueXML('formConsultaHotel','labelConsultaHotel'); ?></a>
			<br><br>
			<!--<input type="text" id="conHotel" name="conHotel" class="cajaConsultaHotel" />-->
			<select name="conHotel" id="conHotel" class="selServicio">
				<option value=''>----</option>
				<?php printOpcionesCodHotAll(); ?>
			</select>&nbsp;&nbsp;
			<input type="text" id="conHiddenHotel" name="conHiddenHotel" class="cajaConsultaReservaHidden" />	
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" id="btnConHotel" name="btnConHotel" value="<?php printValueXML('formTablas','btnConsultar') ?>" class="closebuttonHotel" />
			<br>
		</form>	
	</div>		
</div>

<div style='display:none'>		
	<div id='consultaUsuario' style='padding:10px; background:#fff;'>
		<form name="formConsultaUsuario" id="formConsultaUsuario">
			<a id='labelConsultaUsuario' name='labelConsultaUsuario' class='textoConsulta'><?php printValueXML('formConsultaUsuario','labelConsultaUsuario'); ?></a>
			<br><br>
			<!--<input type="text" id="conUsuario" name="conUsuario" class="cajaConsultaUsuario" />-->
			<select name="conUsuario" id="conUsuario" class="selSelUsu">
				<?php printOpcionesUsuarios(); ?>
			</select>
			<input type="text" id="conHiddenUsuario" name="conHiddenUsuario" class="cajaConsultaReservaHidden" />	
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" id="btnConUsuario" name="btnConUsuario" value="<?php printValueXML('formTablas','btnConsultar') ?>" class="closebuttonUsuario" />
			<br>
		</form>	
	</div>		
</div>

<div style='display:none'>		
	<div id='consultaNacionalidad' style='padding:10px; background:#fff;'>
		<form name="formConsultaNacionalidad" id="formConsultaNacionalidad">
			<a id='labelConsultaNacionalidad' name='labelConsultaNacionalidad' class='textoConsulta'><?php printValueXML('formConsultaNacionalidad','labelConsultaNacionalidad'); ?></a>
			<br><br>
			<!--<input type="text" id="conNacionalidad" name="conNacionalidad" class="cajaConsultaNacionalidad" />-->
			<select name="conNacionalidad" id="conNacionalidad" class="selServicio">
				<option value=''>----</option>
				<?php printOpcionesCodNac(); ?>
			</select>&nbsp;&nbsp;
			<input type="text" id="conHiddenNacionalidad" name="conHiddenNacionalidad" class="cajaConsultaReservaHidden" />	
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" id="btnConNacionalidad" name="btnConNacionalidad" value="<?php printValueXML('formTablas','btnConsultar') ?>" class="closebuttonNacionalidad" />
			<br>
		</form>	
	</div>		
</div>

<div style='display:none'>		
	<div id='consultaProveedor' style='padding:10px; background:#fff;'>
		<form name="formConsultaProveedor" id="formConsultaProveedor">
			<a id='labelConsultaProveedor' name='labelConsultaProveedor' class='textoConsulta'><?php printValueXML('formConsultaProveedor','labelConsultaProveedor'); ?></a>
			<br><br>
			<select name="conProveedor" id="conProveedor" class="selServicio">
				<option value=''>----</option>
				<?php printOpcionesCodPro(); ?>
			</select>&nbsp;&nbsp;
			<input type="text" id="conHiddenProveedor" name="conHiddenProveedor" class="cajaConsultaReservaHidden" />	
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" id="btnConProveedor" name="btnConProveedor" value="<?php printValueXML('formTablas','btnConsultar') ?>" class="closebuttonProveedor" />
			<br>
		</form>	
	</div>		
</div>

<div style='display:none'>		
	<div id='consultaPaquete' style='padding:10px; background:#fff;'>
		<form name="formConsultaPaquete" id="formConsultaPaquete">
			<a id='labelConsultaPaquete' name='labelConsultaPaquete' class='textoConsulta'><?php printValueXML('formConsultaPaquete','labelConsultaPaquete'); ?></a>
			<br><br>
			<select name="conPaquete" id="conPaquete" class="selServicio">
				<option value=''>----</option>
				<?php printOpcionesCodPaq(); ?>
			</select>&nbsp;&nbsp;
			<input type="text" id="conHiddenPaquete" name="conHiddenPaquete" class="cajaConsultaReservaHidden" />	
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" id="btnConPaquete" name="btnConPaquete" value="<?php printValueXML('formTablas','btnConsultar') ?>" class="closebuttonPaquete" />
			<br>
		</form>	
	</div>		
</div>

<div style='display:none'>		
	<div id='consultaVuelo' style='padding:10px; background:#fff;'>
		<form name="formConsultaVuelo" id="formConsultaVuelo">
			<a id='labelConsultaVuelo' name='labelConsultaVuelo' class='textoConsulta'><?php printValueXML('formConsultaVuelo','labelConsultaVuelo'); ?></a>
			<br><br>
			
			<a class='textoConsulta'><?php printValueXML('formTablaVuelos','selTipoVlo'); ?></a>
			<select name="conSelTipoVlo" id="conSelTipoVlo" class="selConSelTipoVlo">
				<option value='IN' selected='selected'>IN</option>
				<option value='OUT'>OUT</option>
			</select>&nbsp;&nbsp;			
			
			<a class='textoConsulta'><?php printValueXML('formTablaVuelos','nroVlo'); ?></a> <input type="text" id="conNroVlo" name="conNroVlo" class="cajaConNroVlo"/>&nbsp;&nbsp;
			
			<input type="button" id="btnConVuelo" name="btnConVuelo" value="<?php printValueXML('formTablas','btnConsultar') ?>" onclick="llenarTablaVuelosSearch(document.formConsultaVuelo.conSelTipoVlo.value, document.formConsultaVuelo.conNroVlo.value);"/>
			
			<input type="text" id="selTipoVloHidden" name="selTipoVloHidden" class="cajaConsultaReservaHidden" value=""/>
			<input type="text" id="nroVloHidden" name="nroVloHidden" class="cajaConsultaReservaHidden" value=""/>
			<input type="text" id="horaVloHidden" name="horaVloHidden" class="cajaConsultaReservaHidden" value=""/>
			
			<br><br>
			<a id='labelResulConsultaVuelo' name='labelResulConsultaVuelo' class='textoConsulta'></a>
			<br>
			<div id="tabvuelo" >
				<table border="0">
					<tr id='resVlo0' runat='server' style='display:none;' bgcolor="#1373A6"> 		
						<td width='40px' align='center'>
							<p class='textoCabeceraTablaVuelos'><?php printValueXML('formConsultaVuelo','etiqTipoVlo'); ?></p>
						</td>
						<td width='80px' align='center'>
							<p class='textoCabeceraTablaVuelos'><?php printValueXML('formConsultaVuelo','etiqNroVlo'); ?></p>
						</td>
						<td width='60px' align='center'>
							<p class='textoCabeceraTablaVuelos'><?php printValueXML('formConsultaVuelo','etiqHoraVlo'); ?></p>
						</td>
						<td width='15px'>
							<p class='textoCabeceraTablaVuelos'><?php printValueXML('formConsultaVuelo','etiqEli'); ?></p>
						</td>
					</tr>
				<?php
				for($i=1;$i<=20;$i=$i+1){
						if ($i % 2){
							$color = '#CBEEF5';
							$colorId = '1';
						}else{
							$color = '#FFFFFF';
							$colorId = '2';
						}
						echo"<tr id='resVlo$i' runat='server' style='display:none;' bgcolor='$color'> 
								<td>
									<input type='text' id='selTipoVlo$i' name='selTipoVlo$i' class='cajaSelTipoVlo$colorId' /> 
								</td>
								<td>
									<input type='text' id='nroVlo$i' name='nroVlo$i' class='cajaNroVlo$colorId' /> 
								</td>
								<td>
									<input type='text' id='horaVlo$i' name='horaVlo$i' class='cajaHoraVlo$colorId' /> 
								</td>
								<td align='center'>
									<img src='images/ver.png' class='closebuttonVuelo' style='cursor:pointer;' id='imgVer$i' name='imgVer$i' onClick=\" opcionBox ='conVuelo'; document.formConsultaVuelo.selTipoVloHidden.value = document.formConsultaVuelo.selTipoVlo$i.value; document.formConsultaVuelo.nroVloHidden.value = document.formConsultaVuelo.nroVlo$i.value; document.formConsultaVuelo.horaVloHidden.value = document.formConsultaVuelo.horaVlo$i.value; \" >
								</td>
							 </tr>	
							";
				}			
				?>
				</table>
			</div>
		</form>	
	</div>		
</div>

<div style='display:none'>		
	<div id='selectProveedores' style='padding:10px; background:#fff;'>	
		<form name="formProveedores" id="formProveedores">	
		<a id='textoNomProveedores' name='textoNomProveedores' class='textoNomProveedores'></a>
		<br><br>
		<table border='0' width='400px'>	
			<?php
				
				echo"<tr>"; 			
				foreach ($proveedoresBase as &$pro){	
					echo"<tr style='height:22px;'>
						 <td id='cell".$pro['cod']."' valign='center' align='left'>
							<input type='checkbox' class='chkServicio' id='option".$pro['cod']."' name='option".$pro['cod']."' value='".$pro['cod']."' onClick=\"seleccionarProveedorSer(".$pro['it'].", this.checked, 'cell".$pro['cod']."');\"><a class='textoNomProveedores' onCLick = \"seleccionarProveedorSerCheck(".$pro['it'].", document.formProveedores.option".$pro['cod'].".id, 'cell".$pro['cod']."');\"> ".$pro['desc']."</a>							
						 </td>
						 <td id='cell".$pro['cod']."CosSer' valign='center' align='right' style='display:none;'>
							<a class='textoNomProveedores'>".getValueXML('formProveedores','textoCosSer')." </a><input type='text' id='cosSer".$pro['cod']."' name='cosSer".$pro['cod']."' class='cajaCosSer' onKeyUp=\"seleccionarProveedorCosSer(".$pro['it'].", this.value);\" />
						 </td>
						 </tr>";	 					
				}
				 		
			?>	
				<td valign='top' align='center'>&nbsp;
					
				</td>
				<td valign='top' align='center'>&nbsp;
					
				</td>
				
			</tr>
		</table>		
		</form>		
	</div>		
</div>

<div style='display:none'>		
	<div id='consultaConsecutivo' style='padding:10px; background:#fff;'>
		<form name="formConsultaConsecutivo" id="formConsultaConsecutivo">
			<a id='labelConsultaVuelo' name='labelConsultaVuelo' class='textoConsulta'><?php printValueXML('formConsultaConsecutivo','labelConsultaConsecutivo'); ?></a>
			<br><br>
			<p class="textoConsulta">
				<?php printValueXML('formTablaConsecutivos','selTipoConsec'); ?>
				<select name="selTipoConsec" id="selTipoConsec" class="selSelTipoConsec" onChange="">
						<option value='IN'>Transfer-IN</option>
						<option value='OUT'>Transfer-OUT</option>
					<option value='OTR'>Otro</option>
				</select>&nbsp;&nbsp;
				
				<?php printValueXML('formTablaConsecutivos','desde'); ?>
				<input type="text" id="desde" name="desde" class="cajaDesde" />&nbsp;&nbsp;
				
				<a class='textoConsulta'><?php printValueXML('formTablaConsecutivos','hasta'); ?></a> 
				<input type="text" id="hasta" name="hasta" class="cajaDesde" />
			</p>			
			
			<p class="textoConsulta">
				<?php printValueXML('formTablaConsecutivos','selEstadoConsec'); ?>
				<select name="selEstadoConsec" id="selEstadoConsec" class="selSelTipoConsec" onChange="">
					<option value='<NULL>' selected='selected'>Todos</option>
					<option value='USA'>Usado</option>
					<option value='DIS'>Disponible</option>
					<option value='ANU'>Anulado</option>
				</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						
				<input type="button" id="btnConConsecutivo" name="btnConConsecutivo" value="<?php printValueXML('formTablas','btnConsultar') ?>" onclick="xajax_llenarTablaConsecutivosSearch(document.formConsultaConsecutivo.selTipoConsec.value, document.formConsultaConsecutivo.desde.value, document.formConsultaConsecutivo.hasta.value, document.formConsultaConsecutivo.selEstadoConsec.value);"/>
			</p>
			
			<br>
			<a id='labelResulConsultaConsecutivo' name='labelResulConsultaConsecutivo' class='textoConsulta'></a>
			<br>
			<div id="tabconsecutivo" >
				<table border="0">
					<tr id='resConsecutivo0' runat='server' style='display:none;' bgcolor="#1373A6"> 		
						<td width='100px' align='center'>
							<p class='textoCabeceraTablaConsecutivos'><?php printValueXML('formConsultaConsecutivo','etiqTipoConsec'); ?></p>
						</td>
						<td width='100px' align='center'>
							<p class='textoCabeceraTablaConsecutivos'><?php printValueXML('formConsultaConsecutivo','etiqNumConsec'); ?></p>
						</td>
						<td width='60px' align='center'>
							<p class='textoCabeceraTablaConsecutivos'><?php printValueXML('formConsultaConsecutivo','etiqEstado'); ?></p>
						</td>
						<td width='15px'>
							<p class='textoCabeceraTablaConsecutivos'><?php printValueXML('formConsultaConsecutivo','etiqEli'); ?></p>
						</td>
						<td width='15px'>
							<p class='textoCabeceraTablaConsecutivos'><input type="checkbox" id="miCheckAll" name="miCheckAll" onClick="checkAllConsecutivos();"> </p>
						</td>
					</tr>
				<?php
				for($i=1;$i<=50;$i=$i+1){
						if ($i % 2){
							$color = '#CBEEF5';
							$colorId = '1';
						}else{
							$color = '#FFFFFF';
							$colorId = '2';
						}
						echo"<tr id='resConsecutivo$i' runat='server' style='display:none;' bgcolor='$color'> 
								<td>
									<input type='text' id='tipoConsec$i' name='tipoConsec$i' class='cajaTipoConsec$colorId' /> 
								</td>
								<td>
									<input type='text' id='numConsec$i' name='numConsec$i' class='cajaNumConsec$colorId' /> 
								</td>
								<td>
									<input type='text' id='estadoConsec$i' name='estadoConsec$i' class='cajaEstadoConsec$colorId' /> 
								</td>
								<td align='center'>
									<img src='images/delete.gif' style='cursor:pointer;' id='imgVer$i' name='imgVer$i' onClick=\"xajax_borrarConsecutivoUnit(document.formConsultaConsecutivo.tipoConsec$i.value, '$i', document.formConsultaConsecutivo.numConsec$i.value);\" >
								</td>
								<td align='center'>
									<input type='checkbox' id='miCheck$i' name='miCheck$i' > 
								</td>
							 </tr>	
							";
				}			
				?>
				</table>
				<p class="textoConsulta">
					<input type="button" id="btnBorrarConsecutivos" style="width:180px;" name="btnBorrarConsecutivos" value="<?php printValueXML('formConsultaConsecutivo','btnBorrarConsecutivos'); ?>" style="display:none" onclick="borrarConsecutivosSelec(document.formConsultaConsecutivo.tipoConsec1.value);"/>
				</p>				
			</div>
		</form>	
	</div>		
</div>


<?php
	if($page == '51')
		echo"<script>tabla = 'agencias'; desactivarTablaAgencias(); mostrarTablas('tablaAgencias');</script>";
	if($page == '52')
		echo"<script>tabla = 'servicios'; desactivarTablaServicios(); mostrarTablas('tablaServicios');</script>";
	if($page == '53')
		echo"<script>tabla = 'vuelos'; desactivarTablaVuelos(); mostrarTablas('tablaVuelos');</script>";
	if($page == '54')
		echo"<script>tabla = 'hoteles'; desactivarTablaHoteles(); mostrarTablas('tablaHoteles');</script>";
	if($page == '55')
		echo"<script>tabla = 'proveedores'; desactivarTablaProveedores(); mostrarTablas('tablaProveedores');</script>";
	if($page == '56'){
		$verifPermiso = false;
		$verifPermiso = verificarPermiso($_SESSION["user"], 'USU');
		if ($verifPermiso == false){
		  echo"<script>mostrarMsg('errorPaginaNoPermitida');</script>";
		  echo"<script>tabla = 'usuarios'; desactivarTablaUsuarios(); mostrarTablas('tablaXXX');</script>";
		}else{
		  echo"<script>tabla = 'usuarios'; desactivarTablaUsuarios(); mostrarTablas('tablaUsuarios');</script>";
		}
		echo"<script>tabla = 'usuarios'; desactivarTablaUsuarios(); mostrarTablas('tablaUsuarios');</script>";
	}
  if($page == '57')
		echo"<script>tabla = 'nacionalidades'; desactivarTablaNacionalidades(); mostrarTablas('tablaNacionalidades');</script>";
	if($page == '58')
		echo"<script>tabla = 'consecutivos'; desactivarTablaConsecutivos(); mostrarTablas('tablaConsecutivos');</script>";
  if($page == '59')
		echo"<script>tabla = 'paquetes'; desactivarTablaPaquetes(); mostrarTablas('tablaPaquetes');</script>";
?>

	<?php
		$verifPermiso = false;
		$verifPermiso = verificarPermiso($_SESSION["user"], 'RES');
		if ($verifPermiso == false){
			echo"<script>mostrarMsg('errorPaginaNoPermitida');</script>";
			echo"<a class='textoNoPermisos'>".getValueXML('mensajes', 'errorPaginaNoPermitida')."</a>";
			return;
		}
		$clienteUsu = getUsuarioRolCliente($_SESSION["user"]);
	?>
	<?php
		inicializarServiciosReservas();
		//$serviciosBase = array();
		$serviciosBase = getArrayServicios();	
		$reserva = true;	
		printVarJSfromDB('VAR_JS_RESERVAS');
	?>	
	<script>
	
		function setServicioCodRes(itres,codSer,dato)
		{
			<?php
			$serviciosBase = getArrayServicios();
			foreach ($serviciosBase as &$serv){
				echo"if(codSer == '".$serv['cod']."'){\n
					setServicioRes(itres,".$serv['it'].",dato);\n
				}\n";
			}
			?>
		}

		function actualizarArrayReserva(){
			<?php
			for($j=1;$j<=50;$j++){
			echo"
				setDocuPaxRes($j,document.formReservas.docuPax$j.value.toUpperCase());\n
				setNomPaxRes($j,document.formReservas.nomPax$j.value.toUpperCase());\n
				setTelPaxRes($j,document.formReservas.telPax$j.value.toUpperCase());\n
				setNacRes($j,document.formReservas.nac$j.value.toUpperCase()+'|'+document.formReservas.asesorAge$j.value.toUpperCase());\n
				setNumPaxRes($j,document.formReservas.numPax$j.value);\n
				setVoucher($j,document.formReservas.codPaq$j.value.toUpperCase()+'|'+document.formReservas.voucher$j.value.toUpperCase());\n
				var llega = document.formReservas.fecLlega$j.value;\n
				var sale = document.formReservas.fecSale$j.value;\n
				llega = getFechaInterfazToYYYY_MM_DD(llega);\n 
				sale = getFechaInterfazToYYYY_MM_DD(sale);\n 
				setFecLlegaRes($j,llega);\n
				setFecSaleRes($j,sale);\n				
				setHotelRes($j,document.formReservas.codHot$j.value.toUpperCase());\n
				setVloLlegaRes($j,document.formReservas.vloLlega$j.value.toUpperCase()+'|'+document.formReservas.horaLlega$j.value.toUpperCase());\n
				setVloSaleRes($j,document.formReservas.vloSale$j.value.toUpperCase()+'|'+document.formReservas.horaSale$j.value.toUpperCase());\n
			";
			}
			?>			
		}
		
    function buscarReserva(e) {
      if (((document.all)?e.keyCode:e.which)=="13"){
        document.getElementById("btnConReserva").click();
      }
    }
    
		function registrarReserva(arrReserva,codAge,cantRes){
			actualizarArrayReserva();
			var datosReservas = '';
			for(i=1;i<=cantRes;i++){
				datosReservas = datosReservas + getNomPaxRes(i) + '/,/' + getNacRes(i) + '/,/' + getNumPaxRes(i) + '/,/' + getFecLlegaRes(i) + '/,/' + getFecSaleRes(i) + '/,/' + getHotelRes(i) + '/,/' + getVloLlegaRes(i) + '/,/' + getVloSaleRes(i) + '/,/' + getObservacionRes(i) + '/,/' + getBorradaRes(i)  + '/,/' + getVoucher(i) + '/,/' + getTelPaxRes(i) + '/,/' + getDocuPaxRes(i) + '/,//;/';
			}
			
			var datosServReserva = '';
			for(i=1;i<=cantRes;i++){
				<?php	
					$i = 1;
					echo"datosServReserva = datosServReserva ";
					foreach ($serviciosBase as &$serv){
						if($i < 2){
							echo"+ '".$serv['cod']."' + ':' + getServicioRes(i,".$serv['it'].") + ':' ";
						}else{
							echo"+ '/,/' + '".$serv['cod']."' + ':' + getServicioRes(i,".$serv['it'].") + ':' ";
						}
						$i++;
					}	
					echo" + '/,//;/';\n";
				?>
				
			}
			
			
			res_datosReservas = datosReservas;
			res_datosServReserva = datosServReserva;
			res_codAge = codAge;
			res_cantRes = cantRes;
			
			//alert(datosReservas);
      xajax_verificarReservasExistentes(datosReservas,datosServReserva,codAge.toUpperCase(),cantRes);
			
			//xajax_registrarReserva(datosReservas,datosServReserva,codAge.toUpperCase(),cantRes);	
		}
		
		function getObsArrRes(arrayRes)
		{
			var obs = arrayRes.split('/,/');	
			return obs[8];
		}
		
		function getArrResSinObs(arrayRes)
		{
			var obs = getObsArrRes(arrayRes);
			var val = arrayRes.replace('/,/'+obs+'/,/' , '/,/');
			return val;
		}
		
		function actualizarReserva(nroResActualizar,codAge,cantRes){
			
			actualizarArrayReserva();
			var datosReservas = '';
			for(i=1;i<=cantRes;i++){
				datosReservas = datosReservas + getNomPaxRes(i) + '/,/' + getNacRes(i) + '/,/' + getNumPaxRes(i) + '/,/' + getFecLlegaRes(i) + '/,/' + getFecSaleRes(i) + '/,/' + getHotelRes(i) + '/,/' + getVloLlegaRes(i) + '/,/' + getVloSaleRes(i) + '/,/' + getObservacionRes(i) + '/,/' + getBorradaRes(i) + '/,/' + getVoucher(i) + '/,/' + getTelPaxRes(i) + '/,/' + getDocuPaxRes(i) + '/,//;/';
			}
			
			var datosServReserva = '';
			for(i=1;i<=cantRes;i++){
				<?php	
					$i = 1;
					echo"datosServReserva = datosServReserva ";
					foreach ($serviciosBase as &$serv){
						if($i < 2){
							echo"+ '".$serv['cod']."' + ':' + getServicioRes(i,".$serv['it'].") + ':' ";
						}else{
							echo"+ '/,/' + '".$serv['cod']."' + ':' + getServicioRes(i,".$serv['it'].") + ':' ";
						}
						$i++;
					}	
					echo" + '/,//;/';\n";
				?>
				
			}
			
			
			if(jsObsActualizar == true){
				var stop = false;
				var stopTemp = false;
				var valRes = '';
				var valResIni = '';
				var obsRes = '';
				var obsResIni = '';	
				var itRes = '';	
				var itResIni = '';
				var longi = 0;				
				
				if((datosReservas != datosReservasInicial)||(datosServReserva != datosServReservaInicial)){
					itRes = datosReservas.split('/;/');	
					itResIni = datosReservasInicial.split('/;/');
					
					itServRes = datosServReserva.split('/;/');	
					itServResIni = datosServReservaInicial.split('/;/');
					
					longi = itRes.length;
					if(itResIni.length < longi)
						longi = itResIni.length;
						
					for(i=0;i<longi;i++){
						stopTemp = false;
						obsRes = getObsArrRes(itRes[i]);
						obsResIni = getObsArrRes(itResIni[i]);
						valRes = getArrResSinObs(itRes[i]);
						valResIni = getArrResSinObs(itResIni[i]);					
						if(valRes != valResIni){
							//alert('HAY CAMBIOS EN RESERVA '+(i+1));
							if(obsRes == obsResIni){
								mostrarMsg('errorObsObligatoria1', (i+1), 'errorObsObligatoria2');
								stop = true;
								stopTemp = true;
							}
						}
						if(stopTemp == false){
							if(itServRes[i] != itServResIni[i]){
								//alert('HAY CAMBIOS EN LOS SERVICIOS DE LA RESERVA '+(i+1));
								if(obsRes == obsResIni){
									mostrarMsg('errorObsObligatoria1', (i+1), 'errorObsObligatoria2');
									stop = true;
								}
							}
						}
					}					
				}
				
				if(stop == true){
					mostrarMsg('errorReservaNoActualizada');
					return;
				}							
			}
			
			//alert(datosServReserva);
			xajax_registrarReserva(datosReservas,datosServReserva,codAge.toUpperCase(),cantRes,nroResActualizar);	
		}
		
		function actualizarDatosServReservaInicial(cantRes){
			datosServReservaInicial = '';
			for(i=1;i<=cantRes;i++){
				<?php	
					$i = 1;
					echo"datosServReservaInicial = datosServReservaInicial ";
					foreach ($serviciosBase as &$serv){
						if($i < 2){
							echo"+ '".$serv['cod']."' + ':' + getServicioRes(i,".$serv['it'].") + ':' ";
						}else{
							echo"+ '/,/' + '".$serv['cod']."' + ':' + getServicioRes(i,".$serv['it'].") + ':' ";
						}
						$i++;
					}	
					echo" + '/,//;/';\n";
				?>
				
			}		
		}
		
		function eliminarReserva(nroRes){			
			//xajax_eliminarReserva(nroRes);
			actualizarArrayReserva();
			var datosReservas = '';
			var cantRes = document.formReservas.cantRes.value;
			var codAge = document.formReservas.codAge.value;
			for(i=1;i<=cantRes;i++){
				datosReservas = datosReservas + getNomPaxRes(i) + '/,/' + getNacRes(i) + '/,/' + getNumPaxRes(i) + '/,/' + getFecLlegaRes(i) + '/,/' + getFecSaleRes(i) + '/,/' + getHotelRes(i) + '/,/' + getVloLlegaRes(i) + '/,/' + getVloSaleRes(i) + '/,/' + getObservacionRes(i) + '/,/' + getBorradaRes(i) + '/,/' + getVoucher(i) + '/,/' + getTelPaxRes(i) + '/,/' + getDocuPaxRes(i) + '/,//;/';
			}
			/***********/
			if(jsObsAnular == true){
				var stop = false;
				var stopTemp = false;
				var obsRes = '';
				var obsResIni = '';	
				var itRes = '';	
				var itResIni = '';
				var longi = 0;				
				
				if(datosReservas != datosReservasInicial){
					itRes = datosReservas.split('/;/');	
					itResIni = datosReservasInicial.split('/;/');
					
					longi = itRes.length;
					if(itResIni.length < longi)
						longi = itResIni.length;
						
					for(i=0;i<longi;i++){
						obsRes = getObsArrRes(itRes[i]);
						obsResIni = getObsArrRes(itResIni[i]);				
						if(obsRes != obsResIni){
							stop = true;
						}
					}					
				}
				
				if(stop == false){
					mostrarMsg('errorObsObligatoriaAnu');
					mostrarMsg('errorReservaNoEliminado');
					return;
				}else{
					xajax_registrarReserva(datosReservas,datosServReservaInicial,codAge.toUpperCase(),cantRes,reservaModificar,nroRes);	
				}							
			}
			/***********/
			
			//xajax_desactivarRes(nroRes);	
		}
		
		function desactivarResRes(numRes, resRes){
			actualizarArrayReserva();
			var datosReservas = '';
			var cantRes = document.formReservas.cantRes.value;
			var codAge = document.formReservas.codAge.value;
			for(i=1;i<=cantRes;i++){
				datosReservas = datosReservas + getNomPaxRes(i) + '/,/' + getNacRes(i) + '/,/' + getNumPaxRes(i) + '/,/' + getFecLlegaRes(i) + '/,/' + getFecSaleRes(i) + '/,/' + getHotelRes(i) + '/,/' + getVloLlegaRes(i) + '/,/' + getVloSaleRes(i) + '/,/' + getObservacionRes(i) + '/,/' + getBorradaRes(i) + '/,/' + getVoucher(i) + '/,/' + getTelPaxRes(i) + '/,/' + getDocuPaxRes(i) + '/,//;/';
			}
			/***********/
			if(jsObsAnular == true){
				var stop = false;
				var stopTemp = false;
				var obsRes = '';
				var obsResIni = '';	
				var itRes = '';	
				var itResIni = '';
				var longi = 0;				
				
				if(datosReservas != datosReservasInicial){
					itRes = datosReservas.split('/;/');	
					itResIni = datosReservasInicial.split('/;/');
					
					longi = itRes.length;
					if(itResIni.length < longi)
						longi = itResIni.length;

					obsRes = getObsArrRes(itRes[(resRes-1)]);
					obsResIni = getObsArrRes(itResIni[(resRes-1)]);	

					if(obsRes != obsResIni){
						stop = true;
					}
				}
				
				if(stop == false){
					mostrarMsg('errorObsObligatoriaAnu');
					mostrarMsg('errorReservaNoEliminado');
					return;
				}else{
					resResAnular = resRes;
					xajax_registrarReserva(datosReservas,datosServReservaInicial,codAge.toUpperCase(),cantRes,numRes,'0',resResAnular);	
				}							
			}else{
				xajax_desactivarResRes(numRes, resRes);
			}
			/***********/
		}
		
		function seleccionarServicio(itres,itser,dato,celda)
		{
			if (dato == true){
				setServicioRes(itres,itser,'true');
				document.getElementById(celda).style.backgroundColor='#CBEEF5';
			}
			else{ 
				setServicioRes(itres,itser,'false');
				document.getElementById(celda).style.backgroundColor='#FFFFFF';
			}	
		}

		function seleccionarServicioCheck(itres,itser,idCheck,celda)
		{
			if (document.getElementById(idCheck).checked == true){
				document.getElementById(idCheck).checked = false;
				setServicioRes(itres,itser,'false');
				document.getElementById(celda).style.backgroundColor='#FFFFFF';
			}		
			else{				
				document.getElementById(idCheck).checked = true;
				setServicioRes(itres,itser,'true');
				document.getElementById(celda).style.backgroundColor='#CBEEF5';
			}
		}
		
		function setCajaAnterior(idCaja, idCajaAnt){
			document.getElementById(idCaja).value = document.getElementById(idCajaAnt).value;
		}
	
		function setValorRes(r,campo){
			res = r;
			if (campo == 'servicios'){
			<?php				
				foreach ($serviciosBase as &$serv){
					echo"if (getServicioRes(res,".$serv['it'].")=='true'){\n
							document.formServicios.option".$serv['cod'].".checked = true;\n
							document.getElementById('cell".$serv['cod']."').style.backgroundColor='#CBEEF5';\n
						 }else{\n
							document.formServicios.option".$serv['cod'].".checked = false;\n
							document.getElementById('cell".$serv['cod']."').style.backgroundColor='#FFFFFF';\n
						 }\n						
						";
				}								
			?>
				document.getElementById('textoNomServicios').innerHTML=getValueXML('formServicios','textoSelectServicios')+' ('+res+')';	
			}else if(campo == 'obs'){
				//document.formObservaciones.obs.value = reservas[res][2];
				document.formObservaciones.obs.value = getObservacionRes(res);
				document.getElementById('labelObs').innerHTML=getValueXML('formObservaciones','textoObservaciones')+' ('+res+')';
			}
			//pasarFoco('codAge');			
		}
		
		<?php limpiarServiciosReservas(); ?>
		
		function prueba(){
			<?php
				for($i=0;$i<=3;$i++){				
					foreach ($serviciosBase as &$serv){
						echo"alert(getServicioRes($i,".$serv['it']."));";
					}
				}	
			?>	
		}
		
		/*
		function cargarSelVloLlega(pFecha, it){	
			pFecha = getFechaInterfazToYYYY_MM_DD(pFecha); 		
			if(pFecha != fechaVloLlega[it]){
				xajax_cargarSelVloLlega(pFecha, it);
				fechaVloLlega[it] = pFecha;
			}	
		}

		function cargarSelVloSale(pFecha, it){	
			pFecha = getFechaInterfazToYYYY_MM_DD(pFecha, it); 		
			if(pFecha != fechaVloSale[it]){
				xajax_cargarSelVloSale(pFecha, it);
				fechaVloSale[it] = pFecha;
			}	
		}
		*/
		
		$(document).ready(function(){
			//Examples of how to assign the ColorBox event to elements
			$(".boxServicios").colorbox({width:"500px", width:"500px", inline:true, href:"#selectServicios"});			
			$(".boxObservaciones").colorbox({width:"400px", width:"500px", inline:true, href:"#editObs"});	
			$(".boxConsultarRes").colorbox({height:"700px", width:"630px", inline:true, href:"#consultaReserva"});
			$(".boxVlo").colorbox({width:"400px", width:"350px", inline:true, href:"#selecVlo"});
			
			$(".closebutton").live('click', function(){
				resultadoBox = '0'; xajax_llenarTablaReservas(document.formConsultaReserva.conReserva.value); 
			});
			/*
			$(".closebuttonNom").live('click', function(){
				resultadoBox = '0'; xajax_llenarTablaReservas(document.formConsultaReserva.conReserva.value); 
			});
			*/
			$(document).bind('cbox_closed', function() {
				if(opcionBox == 'conReserva'){
					if(resultadoBox == '0'){
						alert('Reserva no encontrada.');
					}else{
						desactivarObj('btnIngresarReserva');
						desactivarObj('btnGuardarReserva');
						activarObj('btnConsultarReserva');
						activarObj('btnActualizarReserva');
						activarObj('btnEliminarReserva');
						activarObj('btnCancelarReserva');
						//mostrarObj('filaGeneral');
					}	
				}
				if(opcionBox == 'selecVlo'){
					i = document.formSelecVlo.resVloHidden.value;
					tipo = document.formSelecVlo.tipoVloHidden.value;
					
					if(tipo == 'IN'){
						document.getElementById('vloLlega'+i).value = document.formSelecVlo.nroVloHidden.value;
            if(document.getElementById('horaLlega'+i).value == ''){
              document.getElementById('horaLlega'+i).value = document.formSelecVlo.horaVloHidden.value;
            }
						
					}
					
					if(tipo == 'OUT'){
						document.getElementById('vloSale'+i).value = document.formSelecVlo.nroVloHidden.value;
						if(document.getElementById('horaSale'+i).value == ''){
              document.getElementById('horaSale'+i).value = document.formSelecVlo.horaVloHidden.value;
            }
					}
					
				}
				
			});
			
			$(document).bind('cbox_complete', function(){
				if(opcionBox == 'conReservaIni'){
					document.formConsultaReserva.conReserva.value = '';
					pasarFoco('conReserva');
				}        		
			});
			
		});			
	</script>


<form name="formReservas" id="formReservas">
<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
    <tr id='filaGeneral' runat='server' style='display:none;'>
        <td width="80%" height="80%" valign="top">
				<p> 
					<a id="labelNumRes" name="labelNumRes" class="labelNumRes">&nbsp;&nbsp;Reserva No. __&nbsp;</a>
				</p> 
				<p class="textoFormReservas"> 
					<?php printValueXML('formReservas','codAge'); ?> <input type="text" id="codAge" name="codAge" class="cajaCodAge" onKeyUp="cargarDatoEnSelec(event,this.id, document.formReservas.nomAge.id, document.formReservas.cantRes.id, 'errorAgenciaNoexiste')" value="<?php printVar($clienteUsu); ?>"/>
					<select name="nomAge" id="nomAge" class="selNomAge" onChange="cargarSeleccionEnCaja(this.id, document.formReservas.codAge.id, document.formReservas.cantRes.id);">
												
						<?php 
							if($clienteUsu == ''){
								echo "<option value='<NULL>'>";
								printValueXML('formReservas','codAgeOption');
								echo "</option>";
								printOpcionesCodAge(); 
							}else{
								echo "<option value='$clienteUsu'>".getNomCliente($clienteUsu)."</option>";
							}												
						?>						
					</select>&nbsp;&nbsp;&nbsp;&nbsp;
					<?php printValueXML('formReservas','cantRes'); ?> <input type="text" id="cantRes" name="cantRes" class="cajaCantRes" onKeyUp="cargarTablaReservas(event); activarObj('btnGuardarReserva'); desactivarObj('btnIngresarReserva');" />
				</p> 
        </td>
	</tr>
</table>

<table border="0">
	<tr id='res0' runat='server' style='display:none;' bgcolor="#1373A6"> 		
		<td width='7px'>
			<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqRes'); ?></p>
		</td>		
		<td width='80px'>
			<p class='textoCabeceraTablaReservas'>Documento</p>
		</td>
		<td width='200px'>
			<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqNom'); ?></p>
		</td>
		<td width='90px'>
			<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqTelPax'); ?></p>
		</td>
		<td width='20px'>
			<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqNumpax'); ?></p>
		</td>
    <td width='100px'>
			<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqPaq'); ?></p>
		</td>	
    <td width='100px'> <!-- 100px -->
			<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqAsesorAge'); ?></p>
		</td>
		<td width='80px'>
			<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqVoucher'); ?></p>
		</td>
		<td width='100px'>
			<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqFecLlega'); ?></p>
		</td>
		<td width='80px'>
			<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqVloLlega'); ?></p>
		</td>
    <td width='50px'>
			<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqHoraLlega'); ?></p>
		</td>
		<td width='100px'>
			<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqFecSale'); ?></p>
		</td>
		<td width='80px'>
			<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqVloSale'); ?></p>
		</td>
    <td width='50px'>
			<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqHoraSale'); ?></p>
		</td>
		<td width='80px'>
			<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqHot'); ?></p>
		</td>		
		<td width='10px'>
			<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqServ'); ?></p>
		</td>		
		<td width='6px'>
			<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqObs'); ?></p>
		</td>
		<?php
		$verifPermiso = false;
		$verifPermiso = verificarPermiso($_SESSION["user"], 'eliRes');
		if ($verifPermiso == true){
			echo"
			<td width='15px'>\n
				<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqEli'); ?></p>\n
			</td>\n";
		}
		?>
		</p>						
	</tr>

	<?php
	
	$arrayHoteles = array();
	$arrayHoteles = getOpcionesCodHot();
  
	$arrayPaquetes = array();
	$arrayPaquetes = getOpcionesCodPaq();
	
	for($i=1;$i<=50;$i=$i+1){
		$h = $i-1;
		if ($i % 2){
			$color = '#CBEEF5';
			$colorId = '1';
		}else{
			$color = '#FFFFFF';
			$colorId = '2';
		}
    $fechasDeshabilitadas = getFechasDeshabilitadas(1);
    
		echo"<tr id='res$i' runat='server' style='display:none;' bgcolor='$color'> 
				<td align='center'>
					<a id='idRes$i' class='textoIdRes'>$i</a> 
				</td>		
				<td>
					<input type='text' id='docuPax$i' name='docuPax$i' placeholder='opcional' class='cajaNomPax$colorId' onKeyUp='pasarFocoOnEnter(event,this.id, document.formReservas.nomPax$i.id)' /> 
				</td>
				<td>
					<input type='text' id='nomPax$i' name='nomPax$i' class='cajaNomPax$colorId' onKeyUp='pasarFocoOnEnter(event,this.id, document.formReservas.telPax$i.id)' /> 
				</td>
				<td>
					<input type='text' id='telPax$i' name='telPax$i' placeholder='opcional' class='cajaTelPax$colorId' onKeyUp='pasarFocoOnEnter(event,this.id, document.formReservas.numPax$i.id)' /> 
				</td>
				<td>
					<input type='text' id='numPax$i' name='numPax$i' class='cajaNumPax$colorId' onKeyUp='pasarFocoOnEnter(event,this.id, document.formReservas.codPaq$i.id)' /> 
				</td>
				
        <td>
					<table border='0'>
						<tr runat='server' bgcolor='$color'>
							<td width='70%'>
								<input type='text' id='codPaq$i' name='codPaq$i' class='cajaCodPaq$colorId' onKeyUp=\"cargarDatoEnSelec(event, this.id, document.formReservas.nomPaq$i.id, document.formReservas.codPaq$i.id, 'errorPaqueteNoexiste');\" /> 			
							</td>
							<td width='30%'>
								<select name='nomPaq$i' id='nomPaq$i' class='selNomHot$colorId' onChange=\"cargarSeleccionEnCaja(this.id, document.formReservas.codPaq$i.id, document.formReservas.codPaq$i.id);\">
									<option value='<NULL>'>Paquete...</option>";
									foreach ($arrayPaquetes as &$fila) {
										echo "<option value='$fila[0]'>$fila[1]</option>";
									}									
						   echo"</select>								 										
							</td>
						</tr>
					</table>	
				</td>
        
        <td>
					<input type='text' id='asesorAge$i' name='asesorAge$i' placeholder='opcional' class='cajaAsesorAge$colorId' onKeyUp='pasarFocoOnEnter(event,this.id, document.formReservas.voucher$i.id)' /> 
          <input type='hidden' id='nac$i' name='nac$i' value='COL'/> 
				</td>
        
        <td>
					<input type='text' id='voucher$i' name='voucher$i' placeholder='opcional' class='cajaVoucher$colorId' onKeyUp='pasarFocoOnEnter(event,this.id, document.formReservas.fecLlega$i.id)' /> 
				</td>
				<td>
					<table border='0'>
						<tr runat='server' bgcolor='$color'>
							<td width='90%'>
								<input type='text' id='fecLlega$i' value='' name='fecLlega$i' class='cajaFecLlega$colorId' onkeyup=\"mascaraFecha(this,'/'); pasarFocoOnEnter(event,this.id, document.formReservas.vloLlega$i.id);\" maxlength=\"10\" />	
							</td>
							<td width='10%'>
								<img src='images/calendar.gif' class='imgCalendario' id='imgFecLlega$i' name='imgFecLlega$i' title='Click Here' alt='Click Here' onclick=\"if(document.formReservas.fecLlega$i.value == ''){ document.formReservas.fecLlega$i.value = '".getFechaddmmyyyy()."'; } {$fechasDeshabilitadas} scwShow(scwID('fecLlega$i'),event,'".$_SESSION['language']."');\"> 
							</td>
						</tr>
					</table>					
				</td>
				<td>
					<input type='text' id='vloLlega$i' name='vloLlega$i' class='cajaVloLlega$colorId' onKeyUp='pasarFocoOnEnter(event,this.id, document.formReservas.horaLlega$i.id)' />
					<img src='images/browser.png' class='boxVlo' style='cursor:pointer;' id='imgVloLlega$i' name='imgVloLlega$i' onClick=\"document.formSelecVlo.nroVloHidden.value = ''; document.formSelecVlo.horaVloHidden.value = ''; document.formSelecVlo.tipoVloHidden.value = 'IN'; document.formSelecVlo.resVloHidden.value = '$i'; xajax_llenarTablaVuelosSearch('IN', '');\" >
				</td>
        <td>
          <input type='text' id='horaLlega$i' name='horaLlega$i' class='cajaHoraLlega$colorId' onKeyUp='mascaraHora(this); pasarFocoOnEnter(event,this.id, document.formReservas.fecSale$i.id)' />
				</td>
				<td>
					<table border='0'>
						<tr runat='server' bgcolor='$color'>
							<td width='90%'>
								<input type='text' id='fecSale$i' value='' name='fecSale$i' class='cajaFecSale$colorId' onkeyup=\"mascaraFecha(this,'/'); pasarFocoOnEnter(event,this.id, document.formReservas.vloSale$i.id);\" maxlength=\"10\" /> 	
							</td>
							<td width='10%'>
								<img src='images/calendar.gif' class='imgCalendario' id='imgFecSale$i' name='imgFecSale$i' title='Click Here' alt='Click Here' onclick=\"if(document.formReservas.fecSale$i.value == ''){ document.formReservas.fecSale$i.value = '".getFechaddmmyyyy()."'; } {$fechasDeshabilitadas} scwShow(scwID('fecSale$i'),event,'".$_SESSION['language']."');\" > 
							</td>
						</tr>
					</table>	
				</td>
				<td>
					<input type='text' id='vloSale$i' name='vloSale$i' class='cajaVloSale$colorId' onKeyUp='pasarFocoOnEnter(event,this.id, document.formReservas.horaSale$i.id)' />
					<img src='images/browser.png' class='boxVlo' style='cursor:pointer;' id='imgVloSale$i' name='imgVloSale$i' onClick=\"document.formSelecVlo.nroVloHidden.value = ''; document.formSelecVlo.horaVloHidden.value = ''; document.formSelecVlo.tipoVloHidden.value = 'OUT'; document.formSelecVlo.resVloHidden.value = '$i'; xajax_llenarTablaVuelosSearch('OUT', '');\" >
				</td>		
        <td>
          <input type='text' id='horaSale$i' name='horaSale$i' class='cajaHoraSale$colorId' onKeyUp='mascaraHora(this); pasarFocoOnEnter(event,this.id, document.formReservas.codHot$i.id)' />
				</td>	
				<td>
					<table border='0'>
						<tr runat='server' bgcolor='$color'>
							<td width='70%'>
								<input type='text' id='codHot$i' name='codHot$i' class='cajaCodHot$colorId' onKeyUp=\"cargarDatoEnSelec(event,this.id, document.formReservas.nomHot$i.id, document.formReservas.codHot$i.id, 'errorHotelNoexiste');\" /> 			
							</td>
							<td width='30%'>
								<select name='nomHot$i' id='nomHot$i' class='selNomHot$colorId' onChange=\"cargarSeleccionEnCaja(this.id, document.formReservas.codHot$i.id, document.formReservas.codHot$i.id);\">
									<option value='<NULL>'>".getValueXML('formReservas','codHotOption')."</option>";
									foreach ($arrayHoteles as &$fila) {
										echo "<option value='{$fila[0]}'>{$fila[1]}</option>";
									}									
						   echo"</select>								 										
							</td>
						</tr>
					</table>	
				</td>
				<td id='listaserv$i' align='center'>
					<img src='images/edit.png' class='boxServicios' style='cursor:pointer;' id='imgServ$i' name='imgServ$i' title='".getValueXML('formReservas','txtImgServ')."' alt='".getValueXML('formReservas','txtImgServ')."' onClick=\"setValorRes($i,'servicios');\" > 
				</td>				
				<td align='center'>
					<img src='images/edit.png' class='boxObservaciones' style='cursor:pointer;' id='imgObs$i' name='imgObs$i' title='".getValueXML('formReservas','txtImgObs')."' alt='".getValueXML('formReservas','txtImgObs')."'  onClick=\"setValorRes($i,'obs');\" >
				</td>";
				
				if ($verifPermiso == true){
					echo"
					<td align='center'>
						<img src='images/delete.gif' style='cursor:pointer;' id='imgEli$i' name='imgEli$i' title='".getValueXML('formReservas','txtImgEli')."' alt='".getValueXML('formReservas','txtImgEli')."'  onClick=\" desactivarResRes(reservaModificar, '$i'); \" >
						<img src='images/checked.gif' style='cursor:pointer;' id='imgAct$i' name='imgAct$i' title='".getValueXML('formReservas','txtImgAct')."' alt='".getValueXML('formReservas','txtImgAct')."' style='display:none;'  onClick=\" xajax_activarResRes(reservaModificar, '$i'); \" >
					</td>";
				}
				
				echo"
			</tr>";
	}	
	?>
</table>
</form>

<?php 

	
?>
<div style='display:none'>		
	<div id='selectServicios' style='padding:10px; background:#fff;'>	
		<form name="formServicios" id="formServicios">	
		<a id='textoNomServicios' name='textoNomServicios' class='textoNomServicios'></a>
		<br><br>
		<table border='0' width='400px'>	
			<?php
				
				$i = 1;
				echo"<tr>"; 			
				foreach ($serviciosBase as &$serv){	
					echo"<td id='cell".$serv['cod']."' valign='top' align='left'>
							<input type='checkbox' class='chkServicio' id='option".$serv['cod']."' name='option".$serv['cod']."' value='".$serv['cod']."' onClick=\"seleccionarServicio(res,".$serv['it'].", this.checked, 'cell".$serv['cod']."');\"><a class='textoNomServicios' onCLick = \"seleccionarServicioCheck(res,".$serv['it'].", document.formServicios.option".$serv['cod'].".id, 'cell".$serv['cod']."');\"> ".$serv['desc']."</a>
							
						 </td>";	 
							
					if ($i % 2){						
					}else{
						echo"</tr>";
						echo"<tr>";
					}
					$i++;					
				}
				
			if ($i % 2){		
			}else{
				echo"</tr> <tr>";
			}
				 		
			?>	
				<td valign='top' align='center'>&nbsp;
					
				</td>
				<td valign='top' align='center'>&nbsp;
					
				</td>
				
			</tr>
		</table>
		<?php printTouresPaquetes(); ?>
		<a id='textoPaqServicios' name='textoPaqServicios' class='textoPaqServicios'>.</a>
		</form>		
	</div>		
</div>

<div style='display:none'>		
	<div id='editObs' style='padding:10px; background:#fff;'>
		<form name="formObservaciones" id="formObservaciones">
			<a id='labelObs' name='labelObs' class='textoObs'></a>
			<br><br>
			<textarea id="obs" name="obs" rows="8" cols="47" onblur="setObservacionRes(res,this.value);"></textarea>	
			<br>
			<br>
		</form>	
	</div>		
</div>

<div style='display:none'>		
	<div id='selecVlo' style='padding:10px; background:#fff;'>
		<form name="formSelecVlo" id="formSelecVlo">
			<a id='labelSelecVlo' name='labelSelecVlo' class='textoConsultaReserva'>Seleccione el vuelo de la lista.</a>
			<br>

			<br>
			<input type="text" id="nroVloHidden" name="nroVloHidden" class="cajaConsultaReservaHidden" />
			<input type="text" id="horaVloHidden" name="horaVloHidden" class="cajaConsultaReservaHidden" />
			<input type="text" id="tipoVloHidden" name="tipoVloHidden" class="cajaConsultaReservaHidden" />
			<input type="text" id="resVloHidden" name="resVloHidden" class="cajaConsultaReservaHidden" />
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
				for($i=1;$i<=50;$i=$i+1){
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
									<input type='text' id='horaVlo$i' name='horaVlo$i' class='cajaNroVlo$colorId' /> 
								</td>
								<td align='center'>
									<img src='images/checked.gif' style='cursor:pointer;' id='imgVer$i' name='imgVer$i' onClick=\" opcionBox ='selecVlo'; document.formSelecVlo.nroVloHidden.value = document.formSelecVlo.nroVlo$i.value; document.formSelecVlo.horaVloHidden.value = document.formSelecVlo.horaVlo$i.value; document.formSelecVlo.tipoVloHidden.value = document.formSelecVlo.selTipoVlo$i.value; $.fn.colorbox.close();\" >
								</td>
							 </tr>	
							";
				}			
				?>
				</table>
			</div>
			<br>
		</form>	
	</div>		
</div>

<div style='display:none'>		
	<div id='consultaReserva' style='padding:10px; background:#fff;'>
		<form name="formConsultaReserva" id="formConsultaReserva">
			<a id='labelConsultaReserva' name='labelConsultaReserva' class='textoConsultaReserva'><?php printValueXML('formConsultaReserva','labelConsultaReserva'); ?></a>
			<br><br>
			<input type="text" id="conReserva" name="conReserva" class="cajaConsultaReserva" onkeyup="buscarReserva(event);" autocomplete="off"/>	
			<input type="text" id="conHiddenReserva" name="conHiddenReserva" class="cajaConsultaReservaHidden" autocomplete="off"/>	
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" id="btnConReserva" name="btnConReserva" value="Consultar" class="closebutton" onclick="opcionBox ='conReserva';" />
			
			<br><br><br>
			
			<a id='labelConsultaReservaNom' name='labelConsultaReservaNom' class='textoConsultaReservaNom'><?php printValueXML('formConsultaReserva','labelConsultaReservaNom'); ?></a>
			<br><br>
			<input type="text" id="conReservaNom" name="conReservaNom" class="cajaConsultaReservaNom" />
			<input type="text" id="conHiddenReservaNom" name="conHiddenReservaNom" class="cajaConsultaReservaHidden" />	
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" id="btnConReservaNom" name="btnConReservaNom" value="Consultar" onclick="xajax_llenarTablaReservasNom(document.formConsultaReserva.conReservaNom.value);" />
			<br><br>
			<a id='labelResulConsultaReservaNom' name='labelResulConsultaReservaNom' class='textoConsultaReserva'></a>
			<br>
			<div id="tabreserva" >
				<table border="0">
					<tr id='resNom0' runat='server' style='display:none;' bgcolor="#1373A6"> 		
						<td width='60px'>
							<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqReserva'); ?></p>
						</td>		
						<td width='20px'>
							<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqRes'); ?></p>
						</td>
						<td width='100px'>
							<p class='textoCabeceraTablaReservas'>Documento</p>
						</td>
						<td width='200px'>
							<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqNom'); ?></p>
						</td>
						<td width='20px'>
							<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqNac'); ?></p>
						</td>
						<td width='100px'>
							<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqFecLlega'); ?></p>
						</td>					
						<td width='100px'>
							<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqCliente'); ?></p>
						</td>					
						<td width='15px'>
							<p class='textoCabeceraTablaReservas'><?php printValueXML('formReservas','etiqEli'); ?></p>
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
						echo"<tr id='resNom$i' runat='server' style='display:none;' bgcolor='$color'> 
								<td>
									<input type='text' id='numResNom$i' name='numResNom$i' class='cajaNac$colorId' /> 
								</td>
								<td>
									<input type='text' id='resResNom$i' name='resResNom$i' class='cajaNac$colorId' /> 
								</td>
								<td>
									<input type='text' id='docuPaxNom$i' name='docuPaxNom$i' class='cajaNomPax$colorId' /> 
								</td>
								<td>
									<input type='text' id='nomPaxNom$i' name='nomPaxNom$i' class='cajaNomPax$colorId' /> 
								</td>
								<td>
									<input type='text' id='nacNom$i' name='nacNom$i' class='cajaNac$colorId' /> 
								</td>
								<td>
									<input type='text' id='fecLlegaNom$i' name='fecLlegaNom$i' class='cajaFecLlega$colorId' /> 
								</td>
								<td>
									<input type='text' id='clienteNom$i' name='clienteNom$i' class='cajaCliente$colorId' /> 
								</td>
								<td align='center'>
									<img src='images/ver.png' class='closebutton' style='cursor:pointer;' id='imgVer$i' name='imgVer$i' onClick=\" opcionBox ='conReserva'; document.formConsultaReserva.conReserva.value = document.formConsultaReserva.numResNom$i.value; \" >
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

<?php 
	if($clienteUsu == ''){
		echo"<script>activarObj('codAge');</script>";
	}else{
		echo"<script>desactivarObj('codAge');</script>";
	}												
?>

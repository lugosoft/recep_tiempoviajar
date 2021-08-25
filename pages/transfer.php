<?php
	inicializarOriDesTransfer();
	inicializarVueloTransfer();
?>
<script>
	function agregarFilaTransferNom(colorId, color, i, tipoTransNom, numTransNom, fechaTransNom, vloTransNom, nomPaxTransNom, conducTransNom){				
		var objTr = document.createElement("tr");  //se crea una fila
		objTr.setAttribute("bgcolor",color);
		objTr.id = "rowDetalle_" + i;   //para manipularlo despues.
		
		//esto hay que hacerlo para cada campo.
		
		var strHtml1 = '<input type="text" id="tipoTransNom' + i + '" name="tipoTransNom' + i + '" class="cajaCampoTrans' + colorId + '" value="' + tipoTransNom + '" />';
		var strHtml2 = '<input type="text" id="numTransNom' + i + '" name="numTransNom' + i + '" class="cajaCampoTransIzq' + colorId + '" value="' + numTransNom + '" />';
		var strHtml3 = '<input type="text" id="fechaTransNom' + i + '" name="fechaTransNom' + i + '" class="cajaCampoTrans' + colorId + '" value="' + fechaTransNom + '" />';
		var strHtml4 = '<input type="text" id="vloTransNom' + i + '" name="vloTransNom' + i + '" class="cajaCampoTrans' + colorId + '" value="' + vloTransNom + '" />';
		var strHtml5 = '<input type="text" id="nomPaxTransNom' + i + '" name="nomPaxTransNom' + i + '" class="cajaCampoTransIzq' + colorId + '" value="' + nomPaxTransNom + '" />';
		var strHtml6 = '<input type="text" id="conducTransNom' + i + '" name="conducTransNom' + i + '" class="cajaCampoTransIzq' + colorId + '" value="' + conducTransNom + '" />';
		var strHtml7 = '<img src="images/ver.png" class="closebuttonTransfer" style="cursor:pointer;" id="imgVer' + i + '" name="imgVer' + i + '" onClick=\' opcionBox ="conTransfer"; document.formConsultaTransfer.conTransfer.value = "' + numTransNom + '"; document.formConsultaTransfer.selTipoConTransfer.value = "' + tipoTransNom + '"; \' >';

		var objTd1 = document.createElement("td");  
		objTd1.id = "tdDetalle_1_" + i;  
		objTd1.innerHTML = strHtml1;  				
		objTr.appendChild(objTd1); 
		
		var objTd2 = document.createElement("td");  
		objTd2.id = "tdDetalle_2_" + i;  
		objTd2.innerHTML = strHtml2;  				
		objTr.appendChild(objTd2); 
		
		var objTd3 = document.createElement("td");  
		objTd3.id = "tdDetalle_3_" + i;  
		objTd3.innerHTML = strHtml3;  				
		objTr.appendChild(objTd3); 
		
		var objTd4 = document.createElement("td");  
		objTd4.id = "tdDetalle_4_" + i;  
		objTd4.innerHTML = strHtml4;  				
		objTr.appendChild(objTd4); 
		
		var objTd5 = document.createElement("td");  
		objTd5.id = "tdDetalle_5_" + i;  
		objTd5.innerHTML = strHtml5;  				
		objTr.appendChild(objTd5); 
		
		var objTd6 = document.createElement("td");  
		objTd6.id = "tdDetalle_6_" + i;  
		objTd6.innerHTML = strHtml6;  				
		objTr.appendChild(objTd6); 
		
		var objTd7 = document.createElement("td");
		objTd7.id = "tdDetalle_7_" + i;  
		objTd7.innerHTML = strHtml7;  				
		objTr.appendChild(objTd7); 
		
		var objTbody = document.getElementById("tbDetalle");
		objTbody.appendChild(objTr);
	}
	
	function limpiarTransferNom(){
		var obj = document.getElementById('tbDetalle');
		var objPadre = obj.parentNode;
		objPadre.removeChild(obj);
		obj = document.createElement("tbody");
		obj.id = 'tbDetalle';
		objPadre.appendChild(obj);
	}
			
	function registrarTransfer(){
		//cargarSelHoraVlo(document.formTablaTransfer.fecSerTrans.value);
		var selTipoTrans = document.formTablaTransfer.selTipoTrans.value;
		var selCateTrans = document.formTablaTransfer.selCateTrans.value;
		var fecSer = document.formTablaTransfer.fecSerTrans.value;
		var valTrans = document.formTablaTransfer.valTrans.value;
		var cantPax = document.formTablaTransfer.cantPax.value;
		var nomPax = document.formTablaTransfer.nomPax.value.toUpperCase();
		var selNroVlo = document.formTablaTransfer.selNroVlo.value;
		var horaVlo = document.formTablaTransfer.horaVlo.value;
		var selOrigenTrans = document.formTablaTransfer.selOrigenTrans.value;
		var selDestinoTrans1 = document.formTablaTransfer.selDestinoTrans1.value;
		var selDestinoTrans2 = document.formTablaTransfer.selDestinoTrans2.value;
		var placaTax = document.formTablaTransfer.placaTax.value.toUpperCase();
		var conducTax = document.formTablaTransfer.conducTax.value.toUpperCase();
		var docuTax = document.formTablaTransfer.docuTax.value;
		var obsTrans = document.formTablaTransfer.obsTrans.value;
		var cantVou = document.formTablaTransfer.cantVou.value;
		
		
		if(selTipoTrans == '<NULL>'){
			mostrarMsg('errorSelTipoTrans');
			return;
		}
		
		var r = '';
		
		if(getTipoGral(selTipoTrans) == 'IN')
			r = verificarCamposObligatorios(new Array(selCateTrans,getValueXML('formTablaTransfer','selCateTrans')),
											new Array(fecSer,getValueXML('formTablaTransfer','fecSerTrans')), 
											new Array(valTrans,getValueXML('formTablaTransfer','valTrans')),
											new Array(nomPax,getValueXML('formTablaTransfer','nomPax')),
											new Array(cantPax,getValueXML('formTablaTransfer','cantPax')),
											new Array(selOrigenTrans,getValueXML('formTablaTransfer','selOrigenTrans')),
											new Array(selDestinoTrans1,getValueXML('formTablaTransfer','selDestinoTrans1')),
											new Array(selNroVlo,getValueXML('formTablaTransfer','selNroVlo')),
											new Array(horaVlo,getValueXML('formTablaTransfer','horaVlo')),
											new Array(docuTax,getValueXML('formTablaTransfer','docuTax')),
											new Array(conducTax,getValueXML('formTablaTransfer','conducTax')),
											new Array(placaTax,getValueXML('formTablaTransfer','placaTax')),
											new Array(cantVou,getValueXML('formTablaTransfer','cantVou'))
											);
											
		if(getTipoGral(selTipoTrans) == 'OUT')	
			r = verificarCamposObligatorios(new Array(selCateTrans,getValueXML('formTablaTransfer','selCateTrans')),
											new Array(fecSer,getValueXML('formTablaTransfer','fecSerTrans')), 
											new Array(valTrans,getValueXML('formTablaTransfer','valTrans')),
											new Array(nomPax,getValueXML('formTablaTransfer','nomPax')),
											new Array(cantPax,getValueXML('formTablaTransfer','cantPax')),
											new Array(selOrigenTrans,getValueXML('formTablaTransfer','selOrigenTrans')),
											new Array(selDestinoTrans1,getValueXML('formTablaTransfer','selDestinoTrans1')),
											new Array(selNroVlo,getValueXML('formTablaTransfer','selNroVlo')),
											new Array(horaVlo,getValueXML('formTablaTransfer','horaVlo')),
											new Array(placaTax,getValueXML('formTablaTransfer','placaTax')),
											new Array(docuTax,getValueXML('formTablaTransfer','docuTax')),
											new Array(conducTax,getValueXML('formTablaTransfer','conducTax'))
											);
											
		if(selTipoTrans == 'OTR')	
			r = verificarCamposObligatorios(new Array(selCateTrans,getValueXML('formTablaTransfer','selCateTrans')),
											new Array(fecSer,getValueXML('formTablaTransfer','fecSerTrans')), 
											new Array(valTrans,getValueXML('formTablaTransfer','valTrans')),
											new Array(nomPax,getValueXML('formTablaTransfer','nomPax')),
											new Array(cantPax,getValueXML('formTablaTransfer','cantPax')),
											new Array(selOrigenTrans,getValueXML('formTablaTransfer','selOrigenTrans')),
											new Array(selDestinoTrans1,getValueXML('formTablaTransfer','selDestinoTrans1')),
											new Array(placaTax,getValueXML('formTablaTransfer','placaTax')),
											new Array(docuTax,getValueXML('formTablaTransfer','docuTax')),
											new Array(conducTax,getValueXML('formTablaTransfer','conducTax'))
											);											
											
		if(r!=''){
			mostrarMsg('errorCamposObligatorios','\n'+r);
			return;
		}	
		
		fecSer = getFechaInterfazToYYYY_MM_DD(fecSer);
		
		xajax_registrarTransfer(selTipoTrans, selCateTrans, fecSer,
								valTrans, nomPax, cantPax,
								selNroVlo, horaVlo,
								selOrigenTrans, selDestinoTrans1, selDestinoTrans2,
								placaTax, conducTax,
								docuTax, obsTrans,
								cantVou);					
		
	}
	
	function actualizarTransfer(){
		//cargarSelHoraVlo(document.formTablaTransfer.fecSerTrans.value);
		var selTipoTrans = document.formTablaTransfer.selTipoTrans.value;
		var selCateTrans = document.formTablaTransfer.selCateTrans.value;
		var fecSer = document.formTablaTransfer.fecSerTrans.value;
		var valTrans = document.formTablaTransfer.valTrans.value;
		var cantPax = document.formTablaTransfer.cantPax.value;
		var nomPax = document.formTablaTransfer.nomPax.value.toUpperCase();
		var selNroVlo = document.formTablaTransfer.selNroVlo.value;
		var horaVlo = document.formTablaTransfer.horaVlo.value;
		var selOrigenTrans = document.formTablaTransfer.selOrigenTrans.value;
		var selDestinoTrans1 = document.formTablaTransfer.selDestinoTrans1.value;
		var selDestinoTrans2 = document.formTablaTransfer.selDestinoTrans2.value;
		var placaTax = document.formTablaTransfer.placaTax.value.toUpperCase();
		var conducTax = document.formTablaTransfer.conducTax.value.toUpperCase();
		var docuTax = document.formTablaTransfer.docuTax.value;
		var obsTrans = document.formTablaTransfer.obsTrans.value;
		var cantVou = document.formTablaTransfer.cantVou.value;
		
		if(selTipoTrans == '<NULL>'){
			mostrarMsg('errorSelTipoTrans');
			return;
		}
		
		var r = '';
		
		if(getTipoGral(selTipoTrans) == 'IN')
			r = verificarCamposObligatorios(new Array(selCateTrans,getValueXML('formTablaTransfer','selCateTrans')),
											new Array(fecSer,getValueXML('formTablaTransfer','fecSerTrans')), 
											new Array(valTrans,getValueXML('formTablaTransfer','valTrans')),
											new Array(nomPax,getValueXML('formTablaTransfer','nomPax')),
											new Array(cantPax,getValueXML('formTablaTransfer','cantPax')),
											new Array(selOrigenTrans,getValueXML('formTablaTransfer','selOrigenTrans')),
											new Array(selDestinoTrans1,getValueXML('formTablaTransfer','selDestinoTrans1')),
											new Array(selNroVlo,getValueXML('formTablaTransfer','selNroVlo')),
											new Array(horaVlo,getValueXML('formTablaTransfer','horaVlo')),
											new Array(placaTax,getValueXML('formTablaTransfer','placaTax')),
											new Array(docuTax,getValueXML('formTablaTransfer','docuTax')),
											new Array(conducTax,getValueXML('formTablaTransfer','conducTax')),
											new Array(cantVou,getValueXML('formTablaTransfer','cantVou'))
											);
											
		if(getTipoGral(selTipoTrans) == 'OUT')	
			r = verificarCamposObligatorios(new Array(selCateTrans,getValueXML('formTablaTransfer','selCateTrans')),
											new Array(fecSer,getValueXML('formTablaTransfer','fecSerTrans')), 
											new Array(valTrans,getValueXML('formTablaTransfer','valTrans')),
											new Array(nomPax,getValueXML('formTablaTransfer','nomPax')),
											new Array(cantPax,getValueXML('formTablaTransfer','cantPax')),
											new Array(selOrigenTrans,getValueXML('formTablaTransfer','selOrigenTrans')),
											new Array(selDestinoTrans1,getValueXML('formTablaTransfer','selDestinoTrans1')),
											new Array(selNroVlo,getValueXML('formTablaTransfer','selNroVlo')),
											new Array(horaVlo,getValueXML('formTablaTransfer','horaVlo')),
											new Array(placaTax,getValueXML('formTablaTransfer','placaTax')),
											new Array(docuTax,getValueXML('formTablaTransfer','docuTax')),
											new Array(conducTax,getValueXML('formTablaTransfer','conducTax'))
											);
											
		if(selTipoTrans == 'OTR')	
			r = verificarCamposObligatorios(new Array(selCateTrans,getValueXML('formTablaTransfer','selCateTrans')),
											new Array(fecSer,getValueXML('formTablaTransfer','fecSerTrans')), 
											new Array(valTrans,getValueXML('formTablaTransfer','valTrans')),
											new Array(nomPax,getValueXML('formTablaTransfer','nomPax')),
											new Array(cantPax,getValueXML('formTablaTransfer','cantPax')),
											new Array(selOrigenTrans,getValueXML('formTablaTransfer','selOrigenTrans')),
											new Array(selDestinoTrans1,getValueXML('formTablaTransfer','selDestinoTrans1')),
											new Array(placaTax,getValueXML('formTablaTransfer','placaTax')),
											new Array(docuTax,getValueXML('formTablaTransfer','docuTax')),
											new Array(conducTax,getValueXML('formTablaTransfer','conducTax'))
											);											
											
		if(r!=''){
			mostrarMsg('errorCamposObligatorios','\n'+r);
			return;
		}	
		
		fecSer = getFechaInterfazToYYYY_MM_DD(fecSer); 
												
		xajax_actualizarTransfer(selTipoTrans, selCateTrans, fecSer,
								valTrans, nomPax, cantPax,
								selNroVlo, horaVlo,
								selOrigenTrans, selDestinoTrans1, selDestinoTrans2,
								placaTax, conducTax,
								docuTax, obsTrans,
								cantVou,transferModificar);	
								
	}
	
	function retirarTransfer(){
		var selTipoTrans = document.formTablaTransfer.selTipoTrans.value;
		//xajax_retirarTransfer(selTipoTrans, transferModificar);
		xajax_desactivarTransfer(selTipoTrans, transferModificar);
	}
	
	function ingresarTransfer(){
		limpiarTablaTransfer();
		ocultarTablaTransfer();
		mostrarObj('selTipoTrans');
		activarObj('selTipoTrans');
		document.getElementById('labelSelTipoTrans').innerHTML=getValueXML('formTablaTransfer','selTipoTrans')+' ';
		document.formTablaTransfer.selTipoTrans.value = '<NULL>';
		
		document.getElementById('labelOrdenTrans').innerHTML=' ';
		document.getElementById('ordenTrans').innerHTML='';
		
		desactivarObj('btnIngresarTransfer');
		activarObj('btnGuardarTransfer');
		desactivarObj('btnConsultarTransfer');
		desactivarObj('btnActualizarTransfer');
		desactivarObj('btnRetirarTransfer');
		activarObj('btnCancelarTransfer');
		
		document.formTablaTransfer.selNroVlo.length = 1; 
		document.formTablaTransfer.selNroVlo.options[0] = new Option('----','<NULL>');
	}
	
	function cancelarTransfer(){
		limpiarTablaTransfer();
		ocultarTablaTransfer();
		ocultarObj('selTipoTrans');
		document.getElementById('labelSelTipoTrans').innerHTML='';
		document.formTablaTransfer.selTipoTrans.value = '<NULL>';
		
		fechaVlo = '';
		
		document.getElementById('labelOrdenTrans').innerHTML=' ';
		document.getElementById('ordenTrans').innerHTML='';
		
		activarObj('btnIngresarTransfer');
		desactivarObj('btnGuardarTransfer');
		activarObj('btnConsultarTransfer');
		desactivarObj('btnActualizarTransfer');
		desactivarObj('btnRetirarTransfer');
		activarObj('btnCancelarTransfer');
		
		xajax_liberarNroTransferX('IN');
		xajax_liberarNroTransferX('OUT');
		xajax_liberarNroTransferX('OTR');
	}
	
	/*
	function cargarSelHoraVlo(pFecha){	
		pFecha = getFechaInterfazToYYYY_MM_DD(pFecha); 		
		if(pFecha != fechaVlo){
			xajax_cargarSelHoraVlo(pFecha, document.formTablaTransfer.selTipoTrans.value);
			fechaVlo = pFecha;
			document.formTablaTransfer.selNroVlo.length = 1; 
			document.formTablaTransfer.selNroVlo.options[0] = new Option('----','<NULL>');
		}	
	}
	*/
	
	$(document).ready(function(){
		$(".boxConsultarTransfer").colorbox({width:"750px", inline:true, href:"#consultaTransfer"});
		
		$(".closebuttonTransfer").live('click', function(){
			opcionBox = 'conTransfer'; 
			resultadoBox = '0';
			xajax_llenarTablaTransfer(document.formConsultaTransfer.selTipoConTransfer.value, document.formConsultaTransfer.conTransfer.value); 
		});
		
		$(document).bind('cbox_closed', function() {
			if(opcionBox == 'conTransfer'){
				if(resultadoBox == '0'){
					alert('Transfer no encontrado.');
					document.formTablaTransfer.btnActualizarTransfer.disabled='disabled';
					document.formTablaTransfer.btnRetirarTransfer.disabled='disabled';
				}
				else{										
					document.formTablaTransfer.btnIngresarTransfer.disabled='';
					document.formTablaTransfer.btnGuardarTransfer.disabled='disabled';
					document.formTablaTransfer.btnConsultarTransfer.disabled='';
					document.formTablaTransfer.btnActualizarTransfer.disabled='';
					document.formTablaTransfer.btnRetirarTransfer.disabled='';
					document.formTablaTransfer.btnCancelarTransfer.disabled='';
				}				
			}
		
		});
		
		$(document).bind('cbox_complete', function(){
			if(opcionBox == 'conTransferIni'){
				document.formConsultaTransfer.selTipoConTransfer.value = '<NULL>';
				document.formConsultaTransfer.conTransfer.value = '';
				pasarFoco('selTipoConTransfer');
			}
		});
	
	});
	
</script>
<br>
<div id='tablaTransfer' style='background:#fff;'>	
	<form name="formTablaTransfer" id="formTablaTransfer">
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
					<?php printValueXML('formTablaTransfer','etiqTrans'); ?>	
				</p>
				</td>	
			</tr>
			
			<tr>
				<td align="right">
				<p >
					<a id='labelOrdenTrans' name='labelOrdenTrans' class='textoFormTablas'>&nbsp;</a>
					<a id='ordenTrans' name='ordenTrans' class='textoOrdenTrans'></a>
				</P>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas">
					<a id='labelSelTipoTrans' name='labelSelTipoTrans'><?php printValueXML('formTablaTransfer','selTipoTrans'); ?> </a>
					<select name="selTipoTrans" id="selTipoTrans" class="selSelTipoTrans" onChange="cargarCamposTransfer(this.id, document.formTablaTransfer.fecSerTrans.id, true);">
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
					
					<a id='labelSelCateTrans' name='labelSelCateTrans'><?php printValueXML('formTablaTransfer','selCateTrans'); ?> </a>
					<select name="selCateTrans" id="selCateTrans" class="selSelCateTrans">
						<option value='<NULL>' selected='selected'>- Seleccione -</option>
						<option value='REG'>Regular</option>
						<option value='PRV'>Privado</option>
						<option value='VTA'>Venta</option>
						<option value='INT'>Interno</option>
					</select>&nbsp;&nbsp;&nbsp;&nbsp;
					
					<a id='labelFecSerTrans' name='labelFecSerTrans'><?php printValueXML('formTablaTransfer','fecSerTrans'); ?> </a>
					<input type="text" id="fecSerTrans" name="fecSerTrans" value="<?php echo(getFechaddmmyyyy());?>" class="cajaFecSerTrans" onkeyup="mascaraFecha(this,'/');" maxlength="10" />
					<img src='images/calendar.gif' class='imgCalendario' id='imgFecSer' name='imgFecSerTrans' title='Seleccione fecha' alt='Seleccione fecha' style='cursor:pointer;display:none;' onclick="scwShow(scwID('fecSerTrans'),event,'es');">&nbsp;&nbsp;&nbsp;&nbsp;
					
				</p>
				</td>	
			</tr>

			<tr>
				<td>
				<p class="textoFormTablas">
					<a id='labelHoraVlo' name='labelHoraVlo'><?php printValueXML('formTablaTransfer','horaVlo'); ?> </a>
					<input type="text" id="horaVlo" name="horaVlo" class="cajaHoraVlo" onKeyUp="mascaraHora(this); pasarFocoOnEnter(event,this.id, document.formTablaTransfer.selNroVlo.id)" />&nbsp;&nbsp;&nbsp;&nbsp;	
					
					<a id='labelNroVlo' name='labelNroVlo'><?php printValueXML('formTablaTransfer','selNroVlo'); ?> </a>
					<!-- <input type="text" id="nroVlo" name="nroVlo" class="cajaNroVlo" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaTransfer.cantVou.id)" />-->
					<select name="selNroVlo" id="selNroVlo" class="selSelNroVlo">
						<option value='<NULL>' selected='selected'>----</option>
					</select>&nbsp;&nbsp;&nbsp;
					
					<a id='labelCantVou' name='labelCantVou'><?php printValueXML('formTablaTransfer','cantVou'); ?> </a>
					<input type="text" id="cantVou" name="cantVou" class="cajaCantVou" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaTransfer.nomPax.id)" />
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas">
					<a id='labelNomPax' name='labelNomPax'><?php printValueXML('formTablaTransfer','nomPax'); ?> </a>
					<input type="text" id="nomPax" name="nomPax" class="cajaNomPax" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaTransfer.cantPax.id)" />&nbsp;&nbsp;&nbsp;&nbsp;					
					<a id='labelCantPax' name='labelCantPax'><?php printValueXML('formTablaTransfer','cantPax'); ?> </a>
					<input type="text" id="cantPax" name="cantPax" class="cajaCantPax" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaTransfer.fecSerTrans.id)" />&nbsp;&nbsp;&nbsp;&nbsp;					
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas">
					<a id='labelSelOrigenTrans' name='labelSelOrigenTrans'><?php printValueXML('formTablaTransfer','selOrigenTrans'); ?> </a>
					<select name="selOrigenTrans" id="selOrigenTrans" class="selSelOrigenTrans">
						<option value='<NULL>' selected='selected'>- Seleccione -</option>
					</select>&nbsp;&nbsp;&nbsp;&nbsp;
				</p>
				</td>	
			</tr>

			<tr>
				<td>
				<p class="textoFormTablas">
					<a id='labelSelDestinoTrans1' name='labelSelDestinoTrans1'><?php printValueXML('formTablaTransfer','selDestinoTrans1'); ?> </a>
					<select name="selDestinoTrans1" id="selDestinoTrans1" class="selSelDestinoTrans">
						<option value='<NULL>' selected='selected'>- Seleccione -</option>
					</select>&nbsp;&nbsp;&nbsp;&nbsp;
					<a id='labelSelDestinoTrans2' name='labelSelDestinoTrans2'><?php printValueXML('formTablaTransfer','selDestinoTrans2'); ?> </a>
					<select name="selDestinoTrans2" id="selDestinoTrans2" class="selSelDestinoTrans">
						<option value='<NULL>' selected='selected'>- Seleccione -</option>
					</select>
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas">
					<a id='labelValTrans' name='labelValTrans'><?php printValueXML('formTablaTransfer','valTrans'); ?> </a>
					<input type="text" id="valTrans" name="valTrans" class="cajaValTrans" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaTransfer.conducTax.id)" />&nbsp;&nbsp;&nbsp;&nbsp;
					<a id='labelConducTax' name='labelConducTax'><?php printValueXML('formTablaTransfer','conducTax'); ?> </a>
					<input type="text" id="conducTax" name="conducTax" class="cajaConducTax" onKeyUp="cargarDocuTax(event,this.id);" />
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas">
					<a id='labelDocuTax' name='labelDocuTax'><?php printValueXML('formTablaTransfer','docuTax'); ?> </a>
					<input type="text" id="docuTax" name="docuTax" class="cajaDocuTax" onKeyUp="cargarNomTax(event,this.id);" />
					&nbsp;&nbsp;&nbsp;&nbsp;
					<a id='labelPlacaTax' name='labelPlacaTax'><?php printValueXML('formTablaTransfer','placaTax'); ?> </a>
					<input type="text" id="placaTax" name="placaTax" class="cajaPlacaTax" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaTransfer.obsTrans.id)" />					
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas">
					<a id='labelObsTrans' name='labelObsTrans'><?php printValueXML('formTablaTransfer','obsTrans'); ?> </a>
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas">
					<textarea id="obsTrans" name="obsTrans" rows="4" cols="47" ></textarea>
				</p>
				</td>	
			</tr>
			<?php include "library/botonesTransfer.php"; ?>	
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
<script>
	cancelarTransfer();
</script>
<!-- --------------------------------------------------------------------------------------------------- -->
<div style='display:none'>		
	<div id='consultaTransfer' style='padding:10px; background:#fff;'>
		<form name="formConsultaTransfer" id="formConsultaTransfer">
			<a id='labelConsultaTransfer' name='labelConsultaTransfer' class='textoConsulta'><?php printValueXML('formConsultaTransfer','labelConsultaTransfer'); ?></a>
			<br><br>
			<select name="selTipoConTransfer" id="selTipoConTransfer" class="selSelTipoConTrans">
				<option value='<NULL>' selected='selected'>- Seleccione -</option>
				<option value='IN'>Transfer-IN</option>
				<option value='OUT'>Transfer-OUT</option>
				<option value='OTR'>Otro</option>
			</select>&nbsp;&nbsp;
			<input type="text" id="conTransfer" name="conTransfer" class="cajaConsultaTransfer" />	
			<input type="text" id="conHiddenTransfer" name="conHiddenTransfer" class="cajaConsultaReservaHidden" />	
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" id="btnConTransfer" name="btnConTransfer" value="<?php printValueXML('formTablaTransfer','btnConsultarTransfer') ?>" class="closebuttonTransfer" />
			
			<br><br><br>
			
			<a id='labelConsultaTransferNom' name='labelConsultaTransferNom' class='textoConsultaTransferNom'><?php printValueXML('formConsultaTransfer','labelConsultaTransferNom'); ?></a>
			<br><br>
			<input type="text" id="conTransferNom" name="conTransferNom" class="cajaConsultaTransferNom" />
			<input type="text" id="conHiddenTransferNom" name="conHiddenTransferNom" class="cajaConsultaReservaHidden" />	
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" id="btnConTransferNom" name="btnConTransferNom" value="Consultar" onclick="xajax_llenarTablaTransferNom(document.formConsultaTransfer.conTransferNom.value);" />
			<br><br>
			<a id='labelResulConsultaTransferNom' name='labelResulConsultaTransferNom' class='textoConsulta'></a>
			<br>
			
			<div id="tabtransfer" >
				<table id="tblDetalle" border="0">
					<thead>
						<tr id='resNom0' runat='server' style='display:none;' bgcolor="#1373A6"> 		
							<td width='50px'>
								<p class='textoCabeceraTablaTransfer'><?php printValueXML('formTablaTransfer','etiqTipoTrans'); ?></p>
							</td>
							<td width='70px'>
								<p class='textoCabeceraTablaTransfer'><?php printValueXML('formTablaTransfer','etiqNumTrans'); ?></p>
							</td>
							<td width='100px'>
								<p class='textoCabeceraTablaTransfer'><?php printValueXML('formTablaTransfer','etiqFechaTrans'); ?></p>
							</td>
							<td width='80px'>
								<p class='textoCabeceraTablaTransfer'><?php printValueXML('formTablaTransfer','etiqVuelo'); ?></p>
							</td>
							<td width='250px'>
								<p class='textoCabeceraTablaTransfer'><?php printValueXML('formTablaTransfer','etiqNomPax'); ?></p>
							</td>
							<td width='200px'>
								<p class='textoCabeceraTablaTransfer'><?php printValueXML('formTablaTransfer','etiqConduc'); ?></p>
							</td>										
							<td width='15px'>
								<p class='textoCabeceraTablaTransfer'><?php printValueXML('formTablaTransfer','etiqEli'); ?></p>
							</td>					
						</tr>
					</thead>
					<tbody id="tbDetalle">
					</tbody>
				</table>
			</div>
			
		</form>	
	</div>		
</div>

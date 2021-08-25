<?php
	$verifPermiso = false;
	$verifPermiso = verificarPermiso($_SESSION["user"], 'REPOR');
	if ($verifPermiso == false){
		echo"<script>mostrarMsg('errorPaginaNoPermitida');</script>";
		echo"<a class='textoNoPermisos'>".getValueXML('mensajes', 'errorPaginaNoPermitida')."</a>";
		return;
	}
?>
<script>
	function reporteIN(){
		var r = '';
		var numres = document.formTablaDatosReporte.numres.value;
		var resres = document.formTablaDatosReporte.resres.value;
		var selServicio = document.formTablaDatosReporte.selServicio.value;
		
		r = verificarCamposObligatorios(new Array(numres,getValueXML('formTablaDatosReporte','numres')));
			
		if(r!=''){
			mostrarMsg('errorCamposObligatorios','\n'+r);
			return;
		}
		
		if(selServicio=='<NULL>')
			selServicio = '%';
			
		if(resres=='')
			resres = '%';
			
		xajax_sacarReporteX('queryReporteVentaTourXRes',numres,resres,selServicio);
	};
	
	function getDatosReporte(){
		var texto = '';
		texto = 'Reserva: ' + document.formTablaDatosReporte.numres.value;
		var item;
		if (document.formTablaDatosReporte.resres.value == '')
			item = 'Todos';
		else
			item = document.formTablaDatosReporte.resres.value;
			
		texto = texto + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Item: ' + item;
		return texto;
	};
	
	function imprimirTarjeta(){
		var nroFilas = filasReporte;
		
    var ventimp = window.open("https://tourstiempodeviajar.lugo.host", "_blank");	                
                          
		var numVou = '';
		var numRes = '';
		var fechaVenta = '';
		var tour = '';
		var fechaTour = '';
		var hora = '';
		var lugar = '';
		var hotel = '';

		var selNombPax = '';
		var numPax = '';
		var numPax2 = '';
		var guia = '';
		var telAsesor = '';
    
		var agencia = '';
		var asesor = '';
		var obsPax = '';
		var oficina = '';
		var vOfi;
		var txt = "";
    
		for(i=1;i<=nroFilas;i++){
			
			numVou = document.getElementById('val_'+i+'_1').innerHTML;
			numRes = document.getElementById('val_'+i+'_2').innerHTML;
			selNombPax = document.getElementById('val_'+i+'_4').innerHTML;
      
      tour = document.getElementById('val_'+i+'_6').innerHTML;
			fechaTour = document.getElementById('val_'+i+'_7').innerHTML;
			hora = document.getElementById('val_'+i+'_8').innerHTML;
			hotel = document.getElementById('val_'+i+'_9').innerHTML;
			
      
			numPax = document.getElementById('val_'+i+'_12').innerHTML;
			numPax2 = document.getElementById('val_'+i+'_13').innerHTML;

			lugar = document.getElementById('val_'+i+'_14').innerHTML;
			guia = document.getElementById('val_'+i+'_15').innerHTML;
      agencia = document.getElementById('val_'+i+'_16').innerHTML;
      
      asesor = document.getElementById('val_'+i+'_18').innerHTML;
      telAsesor = document.getElementById('val_'+i+'_19').innerHTML;
      fechaVenta = document.getElementById('val_'+i+'_20').innerHTML;
			obsPax = document.getElementById('val_'+i+'_21').innerHTML;
			
      vOfi = numVou.split('-');
      oficina = vOfi[0];
      
      var addSpace = false;
      if(isMultiple(i, 3)){
        addSpace = true;
      }
      // Se obtiene html del voucher
      txt = getTextVoucher(addSpace, numVou, tour, fechaVenta, fechaTour, hora, lugar, hotel, agencia, 
                           selNombPax, numPax, numPax2, guia, telAsesor, asesor, obsPax, oficina, numRes);
      // Se agrega el voucher
      ventimp.document.write(txt);  
		}

    ventimp.document.close();
    sleepPrint(1000).then(() => {
        ventimp.print( );
        ventimp.close();
    });
		
	};
</script>
<div id="tablaDatosReporte" >
	<form name="formTablaDatosReporte" id="formTablaDatosReporte">
	<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
	<tr>	
	<td width="65%">
		<table border="1" width="100%" height="100%" cellpadding="0" cellspacing="0">
		<tr>
		<td>
		
		<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">					
			<tr>
				<td>
				<p class="textoFormReporte"> 
					<?php printValueXML('formTablaDatosReporte','numres'); ?> 
					<input type="text" id="numres" name="numres" value="" class="cajaNumres" onClick=""/>
					&nbsp;&nbsp;&nbsp;&nbsp;
					Item: <input type="text" id="resres" name="resres" value="" class="cajaNumres" onClick=""/>
					<br>
					<?php printValueXML('formTablaDatosReporte','selServicio'); ?>
					<select name="selServicio" id="selServicio" class="selSelServicio">
						<option value='<NULL>' selected='selected'>----</option>
						<?php printOpcionesCodSer(); ?>
					</select>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="button" onClick="reporteIN();" id="btnConReporte" name="btnConReporte" value="<?php printValueXML('formTablaDatosReporte','btnConReporte'); ?>" class="boton btnConReporte" onmouseover="className='botonHover btnConReporte'" onmouseout="className='boton btnConReporte'" />
				</p>
				</td>	
			</tr>							
		</table>	
		
		</td>	
		</tr>		
		</table>					
	</td>
	<td width="10%" align="left">
		&nbsp;&nbsp;<img src='images/xls.png' id='imgXLS' name='imgXLS' style='cursor:pointer;' onclick="xajax_getExcel(titulosReporte);">
		&nbsp;&nbsp;<img src='images/print.png' id='imgPrint' name='imgPrint' style='cursor:pointer;' onclick="imprimirReporte('reporte', getDatosReporte());">
		&nbsp;&nbsp;
		<?php
			$verifPermiso = false;
			$verifPermiso = verificarPermiso($_SESSION["user"], 'IMPVOUTOUR');
			if ($verifPermiso == true){
				echo"<img src='images/tarjeta.gif' id='imgPrintTarjeta' name='imgPrintTarjeta' style='cursor:pointer;' onclick='imprimirTarjeta();'>";
			}
		?>
	</td>
	<td width="25%" align="right">
		<p id="textoRep" class="textoFormReporte2">Tours Confirmados X Reserva&nbsp;&nbsp;&nbsp;</p>
	</td>
	</tr>
	</table>
	</form>
</div>
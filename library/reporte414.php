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
	function reportePasXRes(){
		var r = '';
		var numres = document.formTablaDatosReporte.numres.value;
		
		r = verificarCamposObligatorios(new Array(numres,getValueXML('formTablaDatosReporte','numres')));
			
		if(r!=''){
			mostrarMsg('errorCamposObligatorios','\n'+r);
			return;
		}
		
		xajax_sacarReporteX('queryReportePasXRes',numres);
		
	};

	function getDatosReporte(){
		var texto = '';
		texto = 'Reserva No: ' + document.formTablaDatosReporte.numres.value;
		
		return texto;
	}
</script>
<div id="tablaDatosReporte" >
	<form name="formTablaDatosReporte" id="formTablaDatosReporte">
	<input type="hidden" id="txt" name="txt" style="display:none:"/>
	<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
	<tr>	
	<td width="60%">
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
					<input type="button" onClick="reportePasXRes();" id="btnConReporte" name="btnConReporte" value="<?php printValueXML('formTablaDatosReporte','btnConReporte'); ?>" class="boton btnConReporte" onmouseover="className='botonHover btnConReporte'" onmouseout="className='boton btnConReporte'" />
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
	</td>
	<td width="30%" align="right">
		<p id="textoRep" class="textoFormReporte2">Pasajeros X Reserva&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
	</td>
	</tr>
	</table>
	</form>
</div>
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
	function reporteOUTMes(){
		var r = '';
		var selAno = document.formTablaDatosReporte.selAno.value;
		var selMes = document.formTablaDatosReporte.selMes.value;
		
		r = verificarCamposObligatorios(new Array(selAno,getValueXML('formTablaDatosReporte','ano')), 
											new Array(selMes,getValueXML('formTablaDatosReporte','mes')));
			
		if(r!=''){
			mostrarMsg('errorCamposObligatorios','\n'+r);
			return;
		}
			
		xajax_sacarReporteX('queryReporteOUTMes',selAno+selMes);
	};
	
	function getDatosReporte(){
		var texto = '';
		texto = 'A&ntilde;o: ' + document.formTablaDatosReporte.selAno.value + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mes: ' + document.formTablaDatosReporte.selMes.value;
		
		return texto;
	}
</script>
<div id="tablaDatosReporte" >
	<form name="formTablaDatosReporte" id="formTablaDatosReporte">
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
					<?php printValueXML('formTablaDatosReporte','ano'); ?> 
					<select name="selAno" id="selAno" class="selSelAno">
						<?php
							$fec = getFechaAno();
							for($i=$fec-10;$i<=$fec;$i=$i+1){
								if($i == $fec)
									echo "<option value='$i' selected='selected'>$i</option>\n";
								else
									echo "<option value='$i'>$i</option>\n";
							}
						?>
					</select>&nbsp;&nbsp;
					
					<?php printValueXML('formTablaDatosReporte','mes'); ?> 
					<select name="selMes" id="selMes" class="selSelMes">
						<?php
							printOpcionesMes($_SESSION["language"]);
						?>						
					</select>
					<?php echo"<script> document.formTablaDatosReporte.selMes.value ='".getFechaMes()."'; </script>";?>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="button" onClick="reporteOUTMes();" id="btnConReporte" name="btnConReporte" value="<?php printValueXML('formTablaDatosReporte','btnConReporte'); ?>" class="boton btnConReporte" onmouseover="className='botonHover btnConReporte'" onmouseout="className='boton btnConReporte'" />
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
		<p id="textoRep" class="textoFormReporte2">Reporte Transfer-OUT Mensual&nbsp;&nbsp;&nbsp;</p>
	</td>
	</tr>
	</table>
	</form>
</div>
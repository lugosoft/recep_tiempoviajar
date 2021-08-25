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
		var nomUbi = document.formTablaDatosReporte.nomUbi.value;
		var selOficina = document.formTablaDatosReporte.selOficina.value;
    
    if(nomUbi==''){
			nomUbi = '%';
		}else{
      nomUbi = '%'+nomUbi+'%';
    }
    
    if(selOficina=='<NULL>')
			selOficina = '%';
    
		xajax_sacarReporteX('queryReporteHoteles',nomUbi, selOficina);
	};
	
	function getDatosReporte(){
		var texto = '';
		
		return texto;
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
          <?php printValueXML('formTablaDatosReporte','selOficina'); ?>
					<select name="selOficina" id="selOficina" class="selSelOficina">
						<option value='<NULL>' selected>----</option>
						<?php printOpcionesCodOfi(); ?>
					</select>
					          
          <br>
          
					<?php printValueXML('formTablaDatosReporte','nomUbi'); ?> 
					<input type="text" id="nomUbi" name="nomUbi" value="" class="cajaNomUbi" onClick=""/>
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
	</td>
	<td width="25%" align="right">
		<p id="textoRep" class="textoFormReporte2">Lista de Hoteles&nbsp;&nbsp;&nbsp;</p>
	</td>
	</tr>
	</table>
	</form>
</div>
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
		var nitCli = document.formTablaDatosReporte.nitCli.value;
		var nomCli = document.formTablaDatosReporte.nomCli.value;
		
		
		if(nitCli==''){
			nitCli = '%';
    }else{
      nitCli = '%'+nitCli+'%';
    }
		
    if(nomCli==''){
			nomCli = '%';
		}else{
      nomCli = '%'+nomCli+'%';
    }
    
		xajax_sacarReporteX('queryReporteAgencias',nitCli, nomCli);
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
					<?php printValueXML('formTablaDatosReporte','nitCli'); ?> 
					<input type="text" id="nitCli" name="nitCli" value="" class="cajaNitCli" onClick=""/>
          <br>
					<?php printValueXML('formTablaDatosReporte','nomCli'); ?> 
					<input type="text" id="nomCli" name="nomCli" value="" class="cajaNomCli" onClick=""/>
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
		<p id="textoRep" class="textoFormReporte2">Lista de Agencias&nbsp;&nbsp;&nbsp;</p>
	</td>
	</tr>
	</table>
	</form>
</div>
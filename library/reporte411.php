<?php
	$verifPermiso = false;
	$verifPermiso = verificarPermiso($_SESSION["user"], 'REPCONSEC');
	if ($verifPermiso == false){
		echo"<script>mostrarMsg('errorPaginaNoPermitida');</script>";
		echo"<a class='textoNoPermisos'>".getValueXML('mensajes', 'errorPaginaNoPermitida')."</a>";
		return;
	}
	
	$clienteUsu = getUsuarioRolCliente($_SESSION["user"]);
	if($clienteUsu == ''){
		echo"<script>var repClienteUsu = 'queryReporteConsecReserva'; var clienteUsu = '$clienteUsu';</script>";
	}
	else{
		echo"<script>var repClienteUsu = 'queryReporteConsecReservaCli'; var clienteUsu = '$clienteUsu';</script>";
	}
		
?>
<script>
	function reporteConsecReserva(){
		var r = '';
		var fecini = document.formTablaDatosReporte.fechaIni.value;
		var fecfin = document.formTablaDatosReporte.fechaFin.value;
		var selOficina = document.formTablaDatosReporte.selOficina.value;
    var selCliente = document.formTablaDatosReporte.selCliente.value;
    
		r = verificarCamposObligatorios(new Array(fecini,getValueXML('formTablaDatosReporte','fechaIni')), 
											new Array(fecfin,getValueXML('formTablaDatosReporte','fechaFin')));
			
		if(r!=''){
			mostrarMsg('errorCamposObligatorios','\n'+r);
			return;
		}
    
    if(selOficina=='<NULL>')
			selOficina = '%';
		
    if(selCliente=='<NULL>')
			selCliente = '%';
    
		fecini = getFechaInterfazToYYYY_MM_DD(fecini); 
		fecfin = getFechaInterfazToYYYY_MM_DD(fecfin); 
		fecini = replaceAll(fecini,'-','');
		fecfin = replaceAll(fecfin,'-','');
    
		xajax_sacarReporteX(repClienteUsu, fecini,fecfin, clienteUsu, selOficina, selCliente);
	};

	function getDatosReporte(){
		var texto = '';
		texto = 'Registrados Desde: ' + document.formTablaDatosReporte.fechaIni.value + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasta: ' + document.formTablaDatosReporte.fechaFin.value;
		
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
					<?php printValueXML('formTablaDatosReporte','fechaRegIni'); ?> 
					<input type="text" id="fechaIni" name="fechaIni" value="<?php printVar(getFechaddmmyyyy());?>" class="cajaFechaIni" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaDatosReporte.fechaFin.id)" />
					<img src='images/calendar.gif' class='imgCalendario' id='imgFecIni' name='imgFecIni' style='cursor:pointer;' onclick="scwShow(scwID('fechaIni'),event,'es');">
					&nbsp;&nbsp;&nbsp;&nbsp;
					<?php printValueXML('formTablaDatosReporte','fechaFin'); ?> 
					<input type="text" id="fechaFin" name="fechaFin" value="<?php printVar(getFechaddmmyyyy());?>" class="cajaFechaFin" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaDatosReporte.fechaFin.id)" />
					<img src='images/calendar.gif' class='imgCalendario' id='imgFecFin' name='imgFecFin' style='cursor:pointer;' onclick="scwShow(scwID('fechaFin'),event,'es');">
					&nbsp;&nbsp;&nbsp;&nbsp;
          
          <?php printValueXML('formTablaDatosReporte','selOficina'); ?>
					<select name="selOficina" id="selOficina" class="selSelOficina">
						<option value='<NULL>'>----</option>
						<?php printOpcionesCodOfi($_SESSION["oficina"]); ?>
					</select>
					          
          <br>
					
					<?php printValueXML('formTablaDatosReporte','selCliente'); ?>
					<select name="selCliente" id="selCliente" class="selNomAge">
						<option value='<NULL>' selected='selected'>----</option>
						<?php printOpcionesCodAge(); ?>
					</select>
          &nbsp;&nbsp;&nbsp;&nbsp;
          
					<input type="button" onClick="reporteConsecReserva();" id="btnConReporte" name="btnConReporte" value="<?php printValueXML('formTablaDatosReporte','btnConReporte'); ?>" class="boton btnConReporte" onmouseover="className='botonHover btnConReporte'" onmouseout="className='boton btnConReporte'" />
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
		<p id="textoRep" class="textoFormReporte2">Consecutivos de Reservas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
	</td>
	</tr>
	</table>
	</form>
</div>
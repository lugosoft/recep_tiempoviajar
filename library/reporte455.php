<?php
	$verifPermiso = false;
	$verifPermiso = verificarPermiso($_SESSION["user"], 'REPCONSEC');
	if ($verifPermiso == false){
		echo"<script>mostrarMsg('errorPaginaNoPermitida');</script>";
		echo"<a class='textoNoPermisos'>".getValueXML('mensajes', 'errorPaginaNoPermitida')."</a>";
		return;
	}
?>
<script>
	function reporteIN(){
		var r = '';
		var fecini = document.formTablaDatosReporte.fechaIni.value;
		var fecfin = document.formTablaDatosReporte.fechaFin.value;
		var selServicio = document.formTablaDatosReporte.selServicio.value;
		var selPro = document.formTablaDatosReporte.selPro.value;
    var selCliente = document.formTablaDatosReporte.selCliente.value;
		var horaTour = document.formTablaDatosReporte.horaTour.value;
		var selOficina = document.formTablaDatosReporte.selOficina.value;
		var selPaquete = document.formTablaDatosReporte.selPaquete.value;
		
		r = verificarCamposObligatorios(new Array(fecini,getValueXML('formTablaDatosReporte','fechaIni')), 
											new Array(fecfin,getValueXML('formTablaDatosReporte','fechaFin')));
			
		if(r!=''){
			mostrarMsg('errorCamposObligatorios','\n'+r);
			return;
		}
		
		if(selServicio=='<NULL>')
			selServicio = '%';
			
		if(selPro=='<NULL>')
			selPro = '%';

    if(selOficina=='<NULL>')
			selOficina = '%';
    
    if(selPaquete=='<NULL>')
			selPaquete = '%';
    
    var reporteName = "";
		if(selCliente=='<NULL>'){
			selCliente = '%';
      reporteName = "queryConsecutivoVentaTour"
    }else{
      reporteName = "queryConsecutivoVentaTourAge"
    }
    
		if(horaTour=='')
			horaTour = '%';
			
		fecini = getFechaInterfazToYYYY_MM_DD(fecini); 
		fecfin = getFechaInterfazToYYYY_MM_DD(fecfin); 
		fecini = replaceAll(fecini,'-','');
		fecfin = replaceAll(fecfin,'-','');
		xajax_sacarReporteX(reporteName,fecini,fecfin,selServicio,selPro,horaTour,selCliente, selOficina, selPaquete);
	};
	
	function getDatosReporte(){
		var texto = '';
		texto = 'Registrados Desde: ' + document.formTablaDatosReporte.fechaIni.value + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasta: ' + document.formTablaDatosReporte.fechaFin.value;
		var serv;
		if (document.formTablaDatosReporte.selServicio.value == '<NULL>')
			serv = 'Todos';
		else
			serv = document.formTablaDatosReporte.selServicio.value;
		
		var cli;
		if (document.formTablaDatosReporte.selCliente.value == '<NULL>')
			cli = 'Todas';
		else
			cli = document.formTablaDatosReporte.selCliente.value;
			
		var hor;
		if (document.formTablaDatosReporte.horaTour.value == '')
			hor = 'Todas';
		else
			hor = document.formTablaDatosReporte.horaTour.value;
			
		texto = texto + '<br>Servicio: ' + serv + '&nbsp;&nbsp;&nbsp;Agencia: ' + cli + '&nbsp;&nbsp;&nbsp;Hora: ' + hor;
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
					Registrados <?php printValueXML('formTablaDatosReporte','fechaIni'); ?> 
					<input type="text" id="fechaIni" name="fechaIni" value="<?php printVar(getFecha01mmyyyy());?>" class="cajaFechaIni" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaDatosReporte.fechaFin.id)" />
					<img src='images/calendar.gif' class='imgCalendario' id='imgFecIni' name='imgFecIni' style='cursor:pointer;' onclick="scwShow(scwID('fechaIni'),event,'es');">
					&nbsp;&nbsp;
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
					<?php printValueXML('formTablaDatosReporte','selServicio'); ?>
					<select name="selServicio" id="selServicio" class="selSelServicio">
						<option value='<NULL>' selected='selected'>----</option>
						<?php printOpcionesCodSer(); ?>
					</select>
					&nbsp;&nbsp;
					<?php printValueXML('formTablaDatosReporte','selPro'); ?>
					<select name="selPro" id="selPro" class="selSelProv">
						<option value='<NULL>' selected='selected'>----</option>
						<?php printOpcionesCodPro(); ?>
					</select>
					<br>
          
          <?php printValueXML('formTablaDatosReporte','selCliente'); ?> 
          <select name="selCliente" id="selCliente" class="selNomAge">
						<option value='<NULL>' selected='selected'>----</option>
						<?php printOpcionesCodAge(); ?>
					</select>
					&nbsp;&nbsp;&nbsp;&nbsp;
          
					<?php printValueXML('formTablaDatosReporte','horaTour'); ?> 
					<input type="text" id="horaTour" name="horaTour" value="" class="cajaHoraTour" onKeyUp="mascaraHora(this);" />
					&nbsp;&nbsp;
          
          &nbsp;&nbsp;
          <?php printValueXML('formTablaDatosReporte','selPaquete'); ?>
					<select name="selPaquete" id="selPaquete" class="selSelOficina">
						<option value='<NULL>'>----</option>
						<?php printOpcionesAllCodPaq(); ?>
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
	</td>
	<td width="25%" align="right">
		<p id="textoRep" class="textoFormReporte2">Consecutivo de Vouchers&nbsp;&nbsp;&nbsp;</p>
	</td>
	</tr>
	</table>
	</form>
</div>
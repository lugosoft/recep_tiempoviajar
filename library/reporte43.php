<?php
	$verifPermiso = false;
	$verifPermiso = verificarPermiso($_SESSION["user"], 'LOG');
	if ($verifPermiso == false){
		echo"<script>mostrarMsg('errorPaginaNoPermitida');</script>";
		echo"<a class='textoNoPermisos'>".getValueXML('mensajes', 'errorPaginaNoPermitida')."</a>";
		return;
	}
?>
<script>
	function reporteLog(){
		var r = '';
		var fecini = document.formTablaDatosReporte.fechaIni.value;
		var fecfin = document.formTablaDatosReporte.fechaFin.value;
		var usu = document.formTablaDatosReporte.selUsu.value;
		var ope = document.formTablaDatosReporte.selOpe.value;
		var tabla = document.formTablaDatosReporte.selTabla.value;
		var num = document.formTablaDatosReporte.num.value;
    var selOficina = document.formTablaDatosReporte.selOficina.value;
		//var usu = '01';
					
		if(usu == '<NULL>')
			usu = '%';
		if(ope == '<NULL>')
			ope = '%';
    
    if(selOficina=='<NULL>')
			selOficina = '%';
    
		/*if(tabla == '<NULL>')
			tabla = '%';*/
			
		if(num == ''){
			num = '%';
		}else{
			document.formTablaDatosReporte.fechaIni.value = '';
			document.formTablaDatosReporte.fechaFin.value = '';
			fecini = '';
			fecfin = '';
		}
		
		if((fecini == '')||(fecfin == '')){		
			xajax_sacarReporteX('queryReporteLog1',usu, ope, tabla, num, selOficina);
			idReporte = '1';
			param1Reporte = usu;
			param2Reporte = ope;
			param3Reporte = tabla;
			param4Reporte = num;
			param5Reporte = '';
			param6Reporte = '';
		}else{
			fecini = getFechaInterfazToYYYY_MM_DD(fecini); 
			fecfin = getFechaInterfazToYYYY_MM_DD(fecfin); 
			fecini = replaceAll(fecini,'-','');
			fecfin = replaceAll(fecfin,'-','');
			xajax_sacarReporteX('queryReporteLog2',fecini, fecfin, usu, ope, tabla, num, selOficina);
			idReporte = '2';
			param1Reporte = fecini;
			param2Reporte = fecfin;
			param3Reporte = usu;
			param4Reporte = ope;
			param5Reporte = tabla;
			param6Reporte = num;			
		}
		
		
	};
	
	function getDatosReporte(){
		var texto = '';
		texto = 'Desde: ' + document.formTablaDatosReporte.fechaIni.value + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasta: ' + document.formTablaDatosReporte.fechaFin.value;
		
		var usu;
		if (document.formTablaDatosReporte.selUsu.value == '<NULL>')
			usu = 'Todos';
		else
			usu = document.formTablaDatosReporte.selUsu.value;
		
		var tab;
		if (document.formTablaDatosReporte.selTabla.value == '<NULL>')
			tab = 'Todas';
		else
			tab = document.formTablaDatosReporte.selTabla.value;
		
		var ope;
		if (document.formTablaDatosReporte.selOpe.value == '<NULL>')
			ope = 'Todas';
		else
			ope = document.formTablaDatosReporte.selOpe.value;
		
	
		texto = texto + '<br>Usuario: ' + usu + '&nbsp;&nbsp;&nbsp;Tabla: ' + tab + '&nbsp;&nbsp;&nbsp;Operaci&oacute;n: ' + ope;
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
					<?php printValueXML('formTablaDatosReporte','fechaIni'); ?> 
					<input type="text" id="fechaIni" name="fechaIni" value="<?php printVar(getFechaddmmyyyy());?>" class="cajaFechaIni" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaDatosReporte.fechaFin.id)" />
					<img src='images/calendar.gif' class='imgCalendario' id='imgFecIni' name='imgFecIni' style='cursor:pointer;' onclick="scwShow(scwID('fechaIni'),event,'es');">
					&nbsp;&nbsp;&nbsp;&nbsp;
					<?php printValueXML('formTablaDatosReporte','fechaFin'); ?> 
					<input type="text" id="fechaFin" name="fechaFin" value="<?php printVar(getFechaddmmyyyy());?>" class="cajaFechaFin" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaDatosReporte.fechaFin.id)" />
					<img src='images/calendar.gif' class='imgCalendario' id='imgFecFin' name='imgFecFin' style='cursor:pointer;' onclick="scwShow(scwID('fechaFin'),event,'es');">
					&nbsp;&nbsp;&nbsp;&nbsp;
					<?php printValueXML('formTablaDatosReporte','usu'); ?> 
					<select name="selUsu" id="selUsu" class="selSelUsu">
						<?php
							printOpcionesUsuarios();
						?>						
					</select>
					&nbsp;&nbsp;&nbsp;&nbsp;
          <?php printValueXML('formTablaDatosReporte','selOficina'); ?>
					<select name="selOficina" id="selOficina" class="selSelOficina">
						<option value='<NULL>'>----</option>
						<?php printOpcionesCodOfi($_SESSION["oficina"]); ?>
					</select>
          <br>
					<?php printValueXML('formTablaDatosReporte','tabla'); ?> 
					<select name="selTabla" id="selTabla" class="selSelTabla">
						<?php
							printOpcionesTablaLog();
						?>						
					</select>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<?php printValueXML('formTablaDatosReporte','ope'); ?> 
					<select name="selOpe" id="selOpe" class="selSelOpe">
						<?php
							printOpcionesOperacionLog();
						?>						
					</select>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<?php printValueXML('formTablaDatosReporte','num'); ?>
					<input type="text" id="num" name="num" class="cajaNumCLog" />
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="button" onClick="reporteLog();" id="btnConReporte" name="btnConReporte" value="<?php printValueXML('formTablaDatosReporte','btnConReporte'); ?>" class="boton btnConReporte" onmouseover="className='botonHover btnConReporte'" onmouseout="className='boton btnConReporte'" />
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
		&nbsp;&nbsp;<img src='images/delete.gif' id='imgELI' name='imgELI' style='cursor:pointer;' onclick="xajax_borrarReporte(idReporte, param1Reporte, param2Reporte, param3Reporte, param4Reporte, param5Reporte, param6Reporte);">
	</td>
	<td width="30%" align="right">
		<p id="textoRep" class="textoFormReporte2">Reporte de Log&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
	</td>
	</tr>
	</table>
	</form>
</div>
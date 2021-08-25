<?php
	$verifPermiso = false;
	$verifPermiso = verificarPermiso($_SESSION["user"], 'REPESTA');
	if ($verifPermiso == false){
		echo"<script>mostrarMsg('errorPaginaNoPermitida');</script>";
		echo"<a class='textoNoPermisos'>".getValueXML('mensajes', 'errorPaginaNoPermitida')."</a>";
		return;
	}
?>
<script>
	function estadisticaPasajerosXAge(){
		var r = '';
		var selPeriodo = document.formTablaDatosReporte.selPeriodo.value;
		var fecini = document.formTablaDatosReporte.fechaIni.value;
		var fecfin = document.formTablaDatosReporte.fechaFin.value;
		var ano = document.formTablaDatosReporte.ano.value;
	
		if(selPeriodo == 'rango'){
			r = verificarCamposObligatorios(new Array(fecini,getValueXML('formTablaDatosReporte','fechaIni')),
												new Array(fecfin,getValueXML('formTablaDatosReporte','fechaFin')));
				
			if(r!=''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}	
			
			fecini = getFechaInterfazToYYYY_MM_DD(fecini); 
			fecfin = getFechaInterfazToYYYY_MM_DD(fecfin); 
			fecini = replaceAll(fecini,'-','');
			fecfin = replaceAll(fecfin,'-','');
			xajax_sacarReporteX('queryEstadisticaPaxAgeRango',fecini,fecfin);			
		}
		
		if(selPeriodo == 'mensual'){
			r = verificarCamposObligatorios(new Array(ano,getValueXML('formTablaDatosReporte','ano')));
				
			if(r!=''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}	
			
			xajax_sacarReporteX('queryEstadisticaPaxAgeMensual',ano);			
		}
		

			
	};

	function getDatosReporte(){
		var texto = '';
		
		if(document.formTablaDatosReporte.selPeriodo.value == 'rango'){
			texto = 'Numero de Pasajeros por Agencia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Desde: ' + document.formTablaDatosReporte.fechaIni.value + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasta: ' + document.formTablaDatosReporte.fechaFin.value;
		}
		if(document.formTablaDatosReporte.selPeriodo.value == 'mensual'){
			texto = 'Numero de Pasajeros por Agencia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ano: ' + document.formTablaDatosReporte.ano.value;
		}
		
		return texto;
	};
	
	function ocultarPeriodos(){
		ocultarObj('textFechaIni');
		ocultarObj('fechaIni');
		ocultarObj('imgFecIni');
		ocultarObj('textFechaFin');
		ocultarObj('fechaFin');
		ocultarObj('imgFecFin');
		ocultarObj('textAno');
		ocultarObj('ano');
		ocultarObj('btnConReporte');
		
	}
	function setPeriodo(idPeriodo){
		var cod = document.getElementById(idPeriodo);
		ocultarPeriodos();
		if(cod.value == 'rango'){
			mostrarObj('textFechaIni');
			mostrarObj('fechaIni');
			mostrarObj('imgFecIni');
			mostrarObj('textFechaFin');
			mostrarObj('fechaFin');
			mostrarObj('imgFecFin');
			mostrarObj('btnConReporte');
		}else{
			if(cod.value == 'mensual'){
				mostrarObj('textAno');
				mostrarObj('ano');
				mostrarObj('btnConReporte');
			}
		}
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
					<?php printValueXML('formTablaDatosReporte','periodo'); ?>
					<select name="selPeriodo" id="selPeriodo" class="selSelPeriodo" onChange="setPeriodo(this.id);">
						<option value='<NULL>' selected='selected'>----</option>
						<option value='rango'>Definir rango de tiempo</option>
						<option value='mensual'>Mensual</option>
					</select>&nbsp;&nbsp;&nbsp;&nbsp;
				</p>
				<p class="textoFormReporte"> 
					<a id="textFechaIni" style="display:none;"><?php printValueXML('formTablaDatosReporte','fechaIni'); ?></a>
					<input type="text" id="fechaIni" name="fechaIni" value="<?php printVar(getFechaddmmyyyy());?>" class="cajaFechaIni" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaDatosReporte.fechaFin.id)" style="display:none;"/>
					<img src='images/calendar.gif' class='imgCalendario' id='imgFecIni' name='imgFecIni' style='cursor:pointer;display:none;' onclick="scwShow(scwID('fechaIni'),event,'es');">
					&nbsp;&nbsp;
					<a id="textFechaFin" style="display:none;"><?php printValueXML('formTablaDatosReporte','fechaFin'); ?></a>
					<input type="text" id="fechaFin" name="fechaFin" value="<?php printVar(getFechaddmmyyyy());?>" class="cajaFechaFin" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaDatosReporte.fechaFin.id)" style="display:none;"/>
					<img src='images/calendar.gif' class='imgCalendario' id='imgFecFin' name='imgFecFin' style='cursor:pointer;display:none;' onclick="scwShow(scwID('fechaFin'),event,'es');" style="display:none;">

					<a id="textAno" style="display:none;"><?php printValueXML('formTablaDatosReporte','ano'); ?></a>
					<input type="text" id="ano" name="ano" class="cajaAno" value="<?php printVar(getFechaAno());?>" style="display:none;"/>
					&nbsp;&nbsp;
					<input type="button" style="display:none;" onClick="estadisticaPasajerosXAge();" id="btnConReporte" name="btnConReporte" value="<?php printValueXML('formTablaDatosReporte','btnConReporte'); ?>" class="boton btnConReporte" onmouseover="className='botonHover btnConReporte'" onmouseout="className='boton btnConReporte'" />
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
		<p id="textoRep" class="textoFormReporte2">Estad&iacute;stica Pax por Agencia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
	</td>
	</tr>
	</table>
	</form>
</div>
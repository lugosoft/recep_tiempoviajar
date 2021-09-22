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
	function reporteLlegadas(){
		var r = '';
		var fecini = document.formTablaDatosReporte.fechaIni.value;
    var fecfin = document.formTablaDatosReporte.fechaFin.value;
		var nroVlo = document.formTablaDatosReporte.selNroVlo.value;
		var selHotel = document.formTablaDatosReporte.selHotel.value;
		var selCliente = document.formTablaDatosReporte.selCliente.value;
		var selNac = document.formTablaDatosReporte.selNac.value;
		var horaTour = document.formTablaDatosReporte.horaTour.value;
    var selPaquete = document.formTablaDatosReporte.selPaquete.value;
    
		r = verificarCamposObligatorios(new Array(fecini,getValueXML('formTablaDatosReporte','fechaIni')),
                                    new Array(fecfin,getValueXML('formTablaDatosReporte','fechaFin'))
      );
			
		if(r!=''){
			mostrarMsg('errorCamposObligatorios','\n'+r);
			return;
		}
		
		if(nroVlo=='<NULL>')
			nroVlo = '%';
		if(selHotel=='<NULL>')
			selHotel = '%';
		if(selCliente=='<NULL>')
			selCliente = '%';
		if(selNac=='<NULL>')
			selNac = '%';
		if(horaTour=='')
			horaTour = '%';
    if(selPaquete=='<NULL>')
			selPaquete = '%';
    
		fecini = getFechaInterfazToYYYY_MM_DD(fecini); 
		fecini = replaceAll(fecini,'-','');
    fecfin = getFechaInterfazToYYYY_MM_DD(fecfin); 
		fecfin = replaceAll(fecfin,'-','');
    
		xajax_sacarReporteX('queryReporteLlegadas',fecini,fecfin, nroVlo,selHotel,selCliente,selNac, ofiRep, horaTour, selPaquete);
	};
	
	function getDatosReporte(){
		var texto = '';
		texto = 'Fecha de Llegada: ' + document.formTablaDatosReporte.fechaIni.value+' - '+document.formTablaDatosReporte.fechaFin.value;
		var vlo;
		if (document.formTablaDatosReporte.selNroVlo.value == '<NULL>')
			vlo = 'Todos';
		else
			vlo = document.formTablaDatosReporte.selNroVlo.value;
		
		if (document.formTablaDatosReporte.selHotel.value == '<NULL>')
			selHotel = 'Todos';
		else
			selHotel = document.formTablaDatosReporte.selHotel.value;

		if (document.formTablaDatosReporte.selCliente.value == '<NULL>')
			selCliente = 'Todos';
		else
			selCliente = document.formTablaDatosReporte.selCliente.value;

		if (document.formTablaDatosReporte.selNac.value == '<NULL>')
			selNac = 'Todas';
		else
			selNac = document.formTablaDatosReporte.selNac.value;
			
		texto = texto + '<br>Vuelo: ' + vlo + '&nbsp;&nbsp;&nbsp;&nbsp;Hotel: ' + selHotel + '&nbsp;&nbsp;&nbsp;&nbsp;Cliente: ' + selCliente + '&nbsp;&nbsp;&nbsp;&nbsp;Nacionalidad: ' + selNac;
		return texto;
	};
	
	function imprimirTarjeta(){
		var nroFilas = filasReporte;
		//var ventimp = window.open('', 'popimpr');
		var ventimp = window.open("https://tourstiempodeviajar.lugo.host", "_blank");	
    
		var estilo = 'style=\"color:#000000;font-size:13px;\"';
		
		var numRes = '';
    var docu = '';
		var item = '';
		var vuelo = '';
		var age = '';
		var pax = '';
		var numPax = '';
		var hot = '';
		var vou = '';
		var obs = '';
		
		var encabezado = "<table border='0' width = '570px'>";
		var text = '';
		for(i=1;i<=nroFilas;i++){
			numRes = document.getElementById('val_'+i+'_1').innerHTML;
			item = document.getElementById('val_'+i+'_2').innerHTML;
			vuelo = document.getElementById('val_'+i+'_3').innerHTML;
			age = document.getElementById('val_'+i+'_4').innerHTML;
      docu = document.getElementById('val_'+i+'_5').innerHTML;
			pax = document.getElementById('val_'+i+'_6').innerHTML;
			numPax = document.getElementById('val_'+i+'_7').innerHTML;
			hot = document.getElementById('val_'+i+'_8').innerHTML;
			vou = document.getElementById('val_'+i+'_9').innerHTML;
			obs = '&nbsp;'; //document.getElementById('val_'+i+'_12').innerHTML;

			text = text +"<tr valign='center'>"+
						"<td width = '100%'>"+
							"<table border='1' width = '100%'><tr><td>"+
							"<table border='0' width = '100%'><tr><td>"+							
							"<table border='0' width = '370px'>"+								
									
									"<tr><td><table border='0' width = '100%'>"+
									"<tr valign='center'>"+
										"<td width = '100%'><img src='logoreportegestion.png' id='imcgXLS' name='imcgXLS'></td>" +
									"</tr>"+
									"</table></td></tr>"+
									
									"<tr><td><table border='0' width = '100%'>"+
									"<tr valign='center'>"+
										"<td width = '100%' align='center'><div " + estilo + "><b>TRANSFER-IN</b></div></td>" +
									"</tr>"+
									"</table></td></tr>"+
									
									"<tr><td><table border='0' width = '100%'>"+
									"<tr valign='center'>"+
										"<td width = '50%'><div " + estilo + "><b>Documento: </b>" + docu + "</div></td>" +
										"<td width = '50%'><div " + estilo + "><b>Reserva: </b>" + numRes + "-" + item + "</div></td>" +
									"</tr>"+
									"</table></td></tr>"+
									
									"<tr><td><table border='0' width = '100%'>"+
									"<tr valign='center'>"+
										"<td width = '70%'><div " + estilo + "><b>Pasajero: </b>" + pax + "</div></td>" +
										"<td width = '30%'><div " + estilo + "><b>No. Pax: </b>" + numPax + "</div></td>" +
									"</tr>"+
									"</table></td></tr>"+
									
									"<tr><td><table border='0' width = '100%'>"+
									"<tr valign='center'>"+
										"<td width = '50%'><div " + estilo + "><b>Voucher: </b>" + vou + "</div></td>" +
										"<td width = '50%'><div " + estilo + "><b>Vuelo: </b>" + vuelo + "</div></td>" +
									"</tr>"+
									"</table></td></tr>"+
									
									"<tr><td><table border='0' width = '100%'>"+
									"<tr valign='center'>"+
										"<td width = '60%'><div " + estilo + "><b>Hotel: </b>" + hot + "</div></td>" +
										"<td width = '40%'><div " + estilo + "><b>Agencia: </b>" + age + "</div></td>" +
									"</tr>"+
									"</table></td></tr>"+
									
									"<tr><td><table border='0' width = '100%'>"+
									"<tr valign='center'>"+
										"<td colspan='2' width = '100%'><div " + estilo + "><b>&nbsp;</b>" + obs + "</div></td>" +
									"</tr>"+
									"</table></td></tr>"+
									
								"</table>"+						
							"</td> <td><img src='logoreportegestiondatostrans.png' id='imgLogo' name='imgLogo'></td> </tr></table> </td> </tr></table>"+
						"</td>"+
					"</tr>"+
					"<tr valign='center'>"+
						"<td width = '100%'><br><br><br></td>"+
					"</tr>";
					
		}
		var fin = "</table>";
		
		ventimp.document.write(encabezado + text + fin);
    ventimp.document.close();
    sleepPrint(700).then(() => {
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
					<?php printValueXML('formTablaDatosReporte','fechaIni'); ?> 
					<input type="text" id="fechaIni" name="fechaIni" value="<?php printVar(getFechaddmmyyyy());?>" class="cajaFechaIni" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaDatosReporte.fechaFin.id)" />
					<img src='images/calendar.gif' class='imgCalendario' id='imgFecIni' name='imgFecIni' style='cursor:pointer;' onclick="scwShow(scwID('fechaIni'),event,'es');">
					&nbsp;&nbsp;&nbsp;&nbsp;
					<?php printValueXML('formTablaDatosReporte','fechaFin'); ?> 
					<input type="text" id="fechaFin" name="fechaFin" value="<?php printVar(getFechaddmmyyyy());?>" class="cajaFechaFin" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaDatosReporte.fechaFin.id)" />
					<img src='images/calendar.gif' class='imgCalendario' id='imgFecFin' name='imgFecFin' style='cursor:pointer;' onclick="scwShow(scwID('fechaFin'),event,'es');">
					&nbsp;&nbsp;&nbsp;&nbsp;
					
					<?php printValueXML('formTablaDatosReporte','nroVlo'); ?>
					<select name="selNroVlo" id="selNroVlo" class="selSelNroVlo">
						<option value='<NULL>' selected='selected'>----</option>
						<?php printOpcionesNroVlo('IN'); ?>
					</select>
					&nbsp;&nbsp;&nbsp;&nbsp;
					
					<?php printValueXML('formTablaDatosReporte','selHotel'); ?>
					<select name="selHotel" id="selHotel" class="selSelHotel">
						<option value='<NULL>' selected='selected'>----</option>
						<?php printOpcionesCodHot(); ?>
					</select>
					<br>
					
					<?php printValueXML('formTablaDatosReporte','selCliente'); ?>
					<select name="selCliente" id="selCliente" class="selSelCliente">
						<option value='<NULL>' selected='selected'>----</option>
						<?php printOpcionesCodAge(); ?>
					</select>
					&nbsp;&nbsp;
					
					<?php /*printValueXML('formTablaDatosReporte','selNac');*/ ?>
					<select name="selNac" id="selNac" class="selSelNac" style="display:none;">
						<option value='<NULL>' selected='selected'>----</option>
						<?php printOpcionesCodNac(); ?>
					</select>
					
          <?php printValueXML('formTablaDatosReporte','horaServicio'); ?> 
					<input type="text" id="horaTour" name="horaTour" value="" class="cajaHoraTour" onKeyUp="mascaraHora(this);" />
          
          &nbsp;&nbsp;
          <?php printValueXML('formTablaDatosReporte','selPaquete'); ?>
					<select name="selPaquete" id="selPaquete" class="selSelOficina">
						<option value='<NULL>'>----</option>
						<?php printOpcionesAllCodPaq(); ?>
					</select>
          
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="button" onClick="reporteLlegadas();" id="btnConReporte" name="btnConReporte" value="<?php printValueXML('formTablaDatosReporte','btnConReporte'); ?>" class="boton btnConReporte" onmouseover="className='botonHover btnConReporte'" onmouseout="className='boton btnConReporte'" />
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
			/*
      $verifPermiso = false;
			$verifPermiso = verificarPermiso($_SESSION["user"], 'IMPVOUTRAN');
			if ($verifPermiso == true){
				echo"<img src='images/tarjeta.gif' id='imgPrintTarjeta' name='imgPrintTarjeta' style='cursor:pointer;' onclick='imprimirTarjeta();'>";
			}
      */
		?>
	</td>
	<td width="25%" align="right">
		<p id="textoRep" class="textoFormReporte2">Llegadas en <?php echo $_SESSION["oficinaname"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
	</td>
	</tr>
	</table>
	</form>
</div>
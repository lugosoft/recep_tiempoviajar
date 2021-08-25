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
		var fecini = document.formTablaDatosReporte.fechaIni.value;
		var fecfin = document.formTablaDatosReporte.fechaFin.value;
		var selServicio = document.formTablaDatosReporte.selServicio.value;
		var selPro = document.formTablaDatosReporte.selPro.value;
		var horaTour = document.formTablaDatosReporte.horaTour.value;
		var selOficina = document.formTablaDatosReporte.selOficina.value;
		
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
			
		if(horaTour=='')
			horaTour = '%';
    
    if(selOficina=='<NULL>')
			selOficina = '%';
			
		fecini = getFechaInterfazToYYYY_MM_DD(fecini); 
		fecfin = getFechaInterfazToYYYY_MM_DD(fecfin); 
		fecini = replaceAll(fecini,'-','');
		fecfin = replaceAll(fecfin,'-','');
		xajax_sacarReporteX('queryReporteVentaDirectaTour',fecini,fecfin,selServicio,selPro,horaTour, selOficina);
	};
	
	function getDatosReporte(){
		var texto = '';
		texto = 'Fecha del Tour Desde: ' + document.formTablaDatosReporte.fechaIni.value + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasta: ' + document.formTablaDatosReporte.fechaFin.value;
		var serv;
		if (document.formTablaDatosReporte.selServicio.value == '<NULL>')
			serv = 'Todos';
		else
			serv = document.formTablaDatosReporte.selServicio.value;
		
		var pro;
		if (document.formTablaDatosReporte.selPro.value == '<NULL>')
			pro = 'Todos';
		else
			pro = document.formTablaDatosReporte.selPro.value;
			
		var hor;
		if (document.formTablaDatosReporte.horaTour.value == '')
			hor = 'Todas';
		else
			hor = document.formTablaDatosReporte.horaTour.value;
			
		texto = texto + '<br>Servicio: ' + serv + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Proveedor: ' + pro + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hora: ' + hor;
		return texto;
	};
	
	function imprimirTarjeta(){
		var nroFilas = filasReporte;
		//alert(nroFilas);
		var ventimp = window.open('', 'popimpr');
		
		var estilo = 'style=\"color:#000000;font-size:13px;\"';
		
		var porN1 = '50%';
		var porN2 = '50%';
		
		var porN3 = '70%';
		var porN4 = '30%';
		
		var numVou = '';
		var fechaVenta = '';
		var obsPax = '';
		var tour = '';
		var fechaTour = '';
		var hora = '';
		var lugar = '';
		var hotel = '';
		var cuarto = '';
		var selNombPax = '';
		var numPax = '';
		var voucher = '';
		var proveedor = '';
		var agencia = '';
		var asesor = '';
		
		var total = '';
		
		var t0 = '';
		var t1 = '';
		var t2 = '';
		
    var vOfi = '';
    var oficina = '';
		var imgHeader = '';
		var imgRight = '';
    
		var encabezado = "<table border='0' width = '690px'>";
		var text = '';
		for(i=1;i<=nroFilas;i++){
			
			numVou = 'Voucher No. '+document.getElementById('val_'+i+'_1').innerHTML;
			fechaVenta = document.getElementById('val_'+i+'_18').innerHTML;
			tour = document.getElementById('val_'+i+'_5').innerHTML;
			fechaTour = document.getElementById('val_'+i+'_6').innerHTML;
			hora = document.getElementById('val_'+i+'_7').innerHTML;
			lugar = document.getElementById('val_'+i+'_13').innerHTML;
			hotel = document.getElementById('val_'+i+'_8').innerHTML;
			cuarto = document.getElementById('val_'+i+'_9').innerHTML;
			selNombPax = document.getElementById('val_'+i+'_4').innerHTML;
			numPax = document.getElementById('val_'+i+'_11').innerHTML;
			voucher = document.getElementById('val_'+i+'_15').innerHTML;
			proveedor = document.getElementById('val_'+i+'_14').innerHTML;
			agencia = document.getElementById('val_'+i+'_16').innerHTML;
			asesor = document.getElementById('val_'+i+'_17').innerHTML;
			preciop = document.getElementById('val_'+i+'_12').innerHTML;
			total = document.getElementById('val_'+i+'_12').innerHTML;
			obsPax = document.getElementById('val_'+i+'_19').innerHTML;
			
      vOfi = numVou.split('-');
      oficina = vOfi[0];
      imgHeader = "logovouchergestion"+oficina+".png";
      imgRight = "logoreportegestiondatosotr"+oficina+".png";
      
			if(agencia == ''){	
				// Particular
				t0 = "<tr valign='center'>"+
								"<td width = '100%'>"+
									"<table border='0' width = '100%'><tr valign='center'>"+
										"<td colspan='2'><b>Nombre: </b>" + selNombPax + "</td>"+
									"</tr></table>"+
								"</td>"+
							"</tr>";
											
				t1 = "<tr valign='center'>"+
							"<td width = '100%'>"+
								"<table border='0' width = '100%'><tr valign='center'>"+
									"<td width = '"+porN1+"'><b>No. Personas: </b>" + numPax + "</td>"+
									"<td width = '"+porN2+"'><b>Proveedor: </b>" + proveedor + "</td>"+
								"</tr></table>"+
							"</td>"+
						"</tr>";
					
				t2 = "<tr valign='center'>"+
								"<td width = '100%'>"+
									"<table border='0' width = '100%'><tr valign='center'>"+
										"<td colspan='2'><b>Obs: </b>" + obsPax + "</td>"+
									"</tr></table>"+
								"</td>"+
							"</tr>";
			} else{
				// Agencia
				t0 = "<tr valign='center'>"+
							"<td width = '100%'>"+
								"<table border='0' width = '100%'><tr valign='center'>"+
									"<td width = '"+porN1+"'><b>Nombre: </b>" + selNombPax + "</td>"+
									"<td width = '"+porN2+"'><b>Agencia: </b>" + agencia + "</td>"+
								"</tr></table>"+
							"</td>"+
						"</tr>";
						
				t1 = "<tr valign='center'>"+
							"<td width = '100%'>"+
								"<table border='0' width = '100%'><tr valign='center'>"+
									"<td width = '"+porN1+"'><b>No. Personas: </b>" + numPax + "</td>"+
									"<td width = '"+porN2+"'><b>Voucher Res: </b>" + voucher + "</td>"+
								"</tr></table>"+
							"</td>"+
						"</tr>";
				t2 = "<tr valign='center'>"+
							"<td width = '100%'>"+
								"<table border='0' width = '100%'><tr valign='center'>"+
									"<td colspan='2'><b>Obs: </b>" + obsPax + "</td>"+
								"</tr></table>"+
							"</td>"+
						"</tr>";
						/*"<tr valign='center'>"+
								"<td width = '100%'>"+
									"<table border='0' width = '100%'><tr valign='center'>"+
										"<td width = '"+porN1+"'><b>Proveedor: </b>" + proveedor + "</td>"+
										"<td width = '"+porN2+"'><b>Agencia: </b>" + agencia + "</td>"+
									"</tr></table>"+
								"</td>"+
							"</tr>";*/
			}
			
			text = text +"<tr valign='center'>"+
						"<td width = '100%'>"+
							"<table border='1' width = '100%'><tr><td>"+
					
								"<table border='0' width = '100%'>"+
									"<tr valign='center'>"+
										"<td>"+	
										"<table border='0' width = '500px'>"+
											"<tr valign='center'>"+
												"<td width = '100%'>"+
													"<table border='0' width = '100%'><tr valign='center'>"+
														"<td width = '60%'><img src='"+imgHeader+"' id='imgLogo' name='imgLogo'></td>"+
														"<td width = '40%'><b>" + numVou + "</b><br>Copia</td>"+
													"</tr></table>"+
												"</td>"+
											"</tr>"+
											"<tr valign='center'>"+
												"<td width = '100%'>"+
													"<table border='0' width = '100%'><tr valign='center'>"+
														"<td width = '"+porN1+"'></td>"+
														"<td width = '"+porN2+"'><b>Fecha de Venta: </b>" + fechaVenta + "</td>"+
													"</tr></table>"+
												"</td>"+
											"</tr>"+
											"<tr valign='center'>"+
												"<td width = '100%'>"+
													"<table border='0' width = '100%'><tr valign='center'>"+
														"<td width = '"+porN1+"'><b>Tour: </b>" + tour + "</td>"+
														"<td width = '"+porN2+"'><b>Fecha de Tour: </b>" + fechaTour + "</td>"+
													"</tr></table>"+
												"</td>"+
											"</tr>"+
											"<tr valign='center'>"+
												"<td width = '100%'>"+
													"<table border='0' width = '100%'><tr valign='center'>"+
														"<td width = '"+porN1+"'><b>Hora: </b>" + hora + "</td>"+
														"<td width = '"+porN2+"'><b>Lugar: </b>" + lugar + "</td>"+
													"</tr></table>"+
												"</td>"+
											"</tr>"+
											"<tr valign='center'>"+
												"<td width = '100%'>"+
													"<table border='0' width = '100%'><tr valign='center'>"+
														"<td width = '"+porN3+"'><b>Hotel: </b>" + hotel + "</td>"+
														"<td width = '"+porN4+"'><b>Habitacion: </b>" + cuarto + "</td>"+
													"</tr></table>"+
												"</td>"+
											"</tr>"+
											t0+
											t1+
											t2+
											"<tr valign='center'>"+
												"<td width = '100%'>"+
													"<table border='0' width = '100%'><tr valign='center'>"+
														"<td width = '"+porN1+"'><b>Asesor: </b>" + asesor + "</td>"+
														"<td width = '"+porN2+"'><b>Firma: </b>___________________</td>"+
													"</tr></table>"+
												"</td>"+
											"</tr>"+
										"</table>"+
										"</td>"+					
										"<td><img src='"+imgRight+"' id='imgLogo' name='imgLogo'></td>"+					
									"</tr>"+												
								"</table>"+
							
							"</td></tr></table>"+
						"</td>"+
					"</tr>"+
					"<tr valign='center'>"+
						"<td width = '100%'><br></td>"+
					"</tr>";
		}
		var fin = "</table>";
				
		ventimp.document.write(encabezado + text + fin);
		ventimp.document.close();
		ventimp.print( );
		ventimp.close();		
		
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
					Fecha Tour <?php printValueXML('formTablaDatosReporte','fechaIni'); ?> 
					<input type="text" id="fechaIni" name="fechaIni" value="<?php printVar(getFechaddmmyyyy());?>" class="cajaFechaIni" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaDatosReporte.fechaFin.id)" />
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
					<?php printValueXML('formTablaDatosReporte','horaTour'); ?> 
					<input type="text" id="horaTour" name="horaTour" value="" class="cajaHoraTour" onKeyUp="mascaraHora(this);" />
					&nbsp;&nbsp;
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
      /*
			$verifPermiso = false;
			$verifPermiso = verificarPermiso($_SESSION["user"], 'IMPVOUTOUR');
			if ($verifPermiso == true){
				echo"<img src='images/tarjeta.gif' id='imgPrintTarjeta' name='imgPrintTarjeta' style='cursor:pointer;' onclick='imprimirTarjeta();'>";
			}
      */
		?>
	</td>
	<td width="25%" align="right">
		<p id="textoRep" class="textoFormReporte2">Tours Venta Directa&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
	</td>
	</tr>
	</table>
	</form>
</div>
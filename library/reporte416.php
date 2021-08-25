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
	function reporteSalidas(){
		var r = '';
		var numres = document.formTablaDatosReporte.numres.value;
		var resres = document.formTablaDatosReporte.resres.value;
		
		r = verificarCamposObligatorios(new Array(numres,getValueXML('formTablaDatosReporte','numres')));
			
		if(r!=''){
			mostrarMsg('errorCamposObligatorios','\n'+r);
			return;
		}
		
		if(resres=='')
			resres = '%';
			
		xajax_sacarReporteX('queryReporteSalidasXRes',numres,resres);
	};
	
	function getDatosReporte(){
		var texto = '';
		texto = 'Reserva: ' + document.formTablaDatosReporte.numres.value + '   Item: ' + document.formTablaDatosReporte.resres.value;

		return texto;
	};
	
	function imprimirTarjeta(){
		var nroFilas = filasReporte;
		//var ventimp = window.open('', 'popimpr');
		var ventimp = window.open("https://tourstiempodeviajar.lugo.host/?id=416", "_blank");	
    
		var estilo = 'style=\"color:#000000;font-size:13px;\"';
		
		var numRes = '';
		var item = '';
		var vuelo = '';
		var hora = '';
		var age = '';
		var pax = '';
		var numPax = '';
		var hot = '';
		var vou = '';
		var obs = '';
		var docuRes = '';
    
    var imgHeader = 'logoreportegestion'+ofiRep+'.png';
		
		var encabezado = "<table border='0' width = '570px'>";
		var text = '';
		for(i=1;i<=nroFilas;i++){
      fecha = document.getElementById('val_'+i+'_1').innerHTML;
      vuelo = document.getElementById('val_'+i+'_2').innerHTML;
			hora = document.getElementById('val_'+i+'_3').innerHTML;
      hot = document.getElementById('val_'+i+'_4').innerHTML;
      numRes = document.getElementById('val_'+i+'_5').innerHTML;
			item = document.getElementById('val_'+i+'_6').innerHTML;
      docuRes = document.getElementById('val_'+i+'_7').innerHTML;
			pax = document.getElementById('val_'+i+'_8').innerHTML;
      numPax = document.getElementById('val_'+i+'_9').innerHTML;
      age = document.getElementById('val_'+i+'_10').innerHTML;
            
			vou = '&nbsp;'; //document.getElementById('val_'+i+'_10').innerHTML;
			obs = '&nbsp;'; //obs = document.getElementById('val_'+i+'_14').innerHTML;


			text = text +"<tr valign='center'>"+
						"<td width = '100%'>"+
							"<table border='1' width = '100%'><tr><td>"+
							"<table border='0' width = '100%'><tr><td>"+
							"<table border='0' width = '370px'>"+
								
								"<tr><td><table border='0' width = '100%'>"+
								"<tr valign='center'>"+
									"<td width = '100%'><img src='"+imgHeader+"' id='imcgXLS' name='imcgXLS'></td>" +
								"</tr>"+
								"</table></td></tr>"+
								
								"<tr><td><table border='0' width = '100%'>"+
								"<tr valign='center'>"+
									"<td width = '100%' align='center'><div " + estilo + "><b>TRANSFER-OUT</b></div></td>" +
								"</tr>"+
								"</table></td></tr>"+
								
								"<tr><td><table border='0' width = '100%'>"+
								"<tr valign='center'>"+
									"<td width = '100%' align='left'><div " + estilo + "><b>Fecha Transfer: </b>" + fecha + "</div></td>" +
								"</tr>"+
								"</table></td></tr>"+
															
								"<tr><td><table border='0' width = '100%'>"+
								"<tr valign='center'>"+
									"<td width = '50%'><div " + estilo + "><b>Documento: </b>" + docuRes + "</div></td>" +
									"<td width = '50%'><div " + estilo + "><b>Reserva: </b>" + numRes + "&nbsp;&nbsp;&nbsp;<b>Item: </b>" + item + "</div></td>" +
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
									"<td width = '60%'><div " + estilo + "><b>Vuelo: </b>" + vuelo + "</div></td>" +
									"<td width = '40%'><div " + estilo + "><b>Hora: </b>" + hora + "</div></td>" +
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
						"<td width = '100%'><br><br></td>"+
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
					<?php printValueXML('formTablaDatosReporte','numres'); ?> 
					<input type="text" id="numres" name="numres" value="" class="cajaNumres" onClick=""/>
					&nbsp;&nbsp;&nbsp;&nbsp;
					Item: <input type="text" id="resres" name="resres" value="" class="cajaNumres" onClick=""/>
					
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="button" onClick="reporteSalidas();" id="btnConReporte" name="btnConReporte" value="<?php printValueXML('formTablaDatosReporte','btnConReporte'); ?>" class="boton btnConReporte" onmouseover="className='botonHover btnConReporte'" onmouseout="className='boton btnConReporte'" />
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
			$verifPermiso = false;
			$verifPermiso = verificarPermiso($_SESSION["user"], 'IMPVOUTRAN');
			if ($verifPermiso == true){
				echo"<img src='images/tarjeta.gif' id='imgPrintTarjeta' name='imgPrintTarjeta' style='cursor:pointer;' onclick='imprimirTarjeta();'>";
			}
		?>
	</td>
	<td width="25%" align="right">
		<p id="textoRep" class="textoFormReporte2">Reporte de Salidas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
	</td>
	</tr>
	</table>
	</form>
</div>
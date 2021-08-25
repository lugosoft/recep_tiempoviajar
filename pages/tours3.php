	<?php
		$verifPermiso = false;
		$verifPermiso = verificarPermiso($_SESSION["user"], 'TOU3');
		if ($verifPermiso == false){
			echo"<script>mostrarMsg('errorPaginaNoPermitida');</script>";
			echo"<a class='textoNoPermisos'>".getValueXML('mensajes', 'errorPaginaNoPermitida')."</a>";
			return;
		}
		
	?>	
	<?php /*obtenerNroVoucher();*/ ?>
	<script>
		//xajax_obtenerNroVoucherX();
		
		function cargarSelNombPax(e, idSelec) {
			if (((document.all)?e.keyCode:e.which)=="13"){
				var cod = document.getElementById(idSelec);
				xajax_cargarSelNombPax(cod.value);
			}else{
				var optPax=new Array(new Option('','<NULL>'));
				mis_options=eval('optPax');
				document.formRegistrarVentaTour.selNombPax.length = 1;
				document.formRegistrarVentaTour.selNombPax.options[0] = mis_options[0];
			}
      document.formRegistrarVentaTour.docu.value = '';
      limpiarSelect("selTour");
      limpiarSelect("selFechaTour");
		}
    
    function cargarSelNombPaxXDoc(e, idSelec) {
			if (((document.all)?e.keyCode:e.which)=="13"){
				var cod = document.getElementById(idSelec);
				xajax_cargarSelNombPaxXDoc(cod.value);
			}else{
				var optPax=new Array(new Option('','<NULL>'));
				mis_options=eval('optPax');
				document.formRegistrarVentaTour.selNombPax.length = 1;
				document.formRegistrarVentaTour.selNombPax.options[0] = mis_options[0];
			}
      document.formRegistrarVentaTour.numRes.value = '';
      limpiarSelect("selTour");
      limpiarSelect("selFechaTour");
		}
		
		function cargarCampoFechaTour(idSelec){
			var cod = document.getElementById(idSelec);
      var myArr = document.formRegistrarVentaTour.selNombPax.value.split("-");
      var nroRes = myArr[0];
      var resRes = myArr[1];

      xajax_cargarSelFechaTour(nroRes, resRes, cod.value);
		}
		
		function cargarCampoTour(idSelec){
			var cod = document.getElementById(idSelec);
			var myArr = cod.value.split("-");
      var nroRes = myArr[0];
      var resRes = myArr[1];
            
			xajax_cargarSelTour(nroRes, resRes);
      limpiarSelect("selFechaTour");
      
		}
		
		function cargarLugarTour(idSelec){
			var cod = document.getElementById(idSelec);
			document.getElementById('labelCupos').innerHTML = '';
			document.formRegistrarVentaTour.lugar.value = '';
			xajax_cargarLugarTour(cod.value);
		}

		function totalizar1_2(){
			var total1 = (document.getElementById('labelTotal').innerHTML).replaceAll('.','');
			var total2 = (document.getElementById('labelTotal2').innerHTML).replaceAll('.','');
			if(total1 == '')
				total1 = 0;
			if(total2 == '')
				total2 = 0;

			var total = parseInt(total1) + parseInt(total2);
			document.getElementById('labelTotalTotal').innerHTML = getValorConPuntos(total);
		}

		function calcularTotal_1(e, idCaja) {
			if (((document.all)?e.keyCode:e.which)=="13"){
				document.getElementById('labelTotal').innerHTML = '';
				var numPax = document.getElementById(idCaja).value;	
				var precXPax = document.formRegistrarVentaTour.precXPax.value;
				var total = '';				
				if((numPax != '') && (precXPax != '')){
					total = numPax*precXPax;
				}
				//document.formRegistrarVentaTour.total.value = total;
				document.getElementById('labelTotal').innerHTML = getValorConPuntos(total);
				totalizar1_2();
			}
		}

		function calcularTotal_12(e, idCaja) {
			if (((document.all)?e.keyCode:e.which)=="13"){
				document.getElementById('labelTotal2').innerHTML = '';
				var numPax2 = document.getElementById(idCaja).value;	
				var precXPax2 = document.formRegistrarVentaTour.precXPax2.value;
				var total = '';				
				if((numPax2 != '') && (precXPax2 != '')){
					total = numPax2*precXPax2;
				}
				//document.formRegistrarVentaTour.total.value = total;
				document.getElementById('labelTotal2').innerHTML = getValorConPuntos(total);
				totalizar1_2();
			}
		}
		
		function calcularTotal_2(e, idCaja) {
			if (((document.all)?e.keyCode:e.which)=="13"){
				document.getElementById('labelTotal').innerHTML = '';
				var precXPax = document.getElementById(idCaja).value;								
				var numPax = document.formRegistrarVentaTour.numPax.value;
				var total = '';						
				if((numPax != '') && (precXPax != '')){
					total = numPax*precXPax;
				}
				document.getElementById('labelTotal').innerHTML = getValorConPuntos(total);
				totalizar1_2();
			}
		}

		function calcularTotal_22(e, idCaja) {
			if (((document.all)?e.keyCode:e.which)=="13"){
				document.getElementById('labelTotal2').innerHTML = '';
				var precXPax2 = document.getElementById(idCaja).value;								
				var numPax2 = document.formRegistrarVentaTour.numPax2.value;
				var total = '';						
				if((numPax2 != '') && (precXPax2 != '')){
					total = numPax2*precXPax2;
				}
				document.getElementById('labelTotal2').innerHTML = getValorConPuntos(total);
				totalizar1_2();
			}
		}
    
		function limpiarTablaVentaTour(){
			     
      activarTablaRegistrarVenta();
			document.formRegistrarVentaTour.selHotelPax.value = '<NULL>';
			document.formRegistrarVentaTour.selNacPax.value = '<NULL>';
      
      limpiarSelect("selTour");
      limpiarSelect("selFechaTour");
      
			document.formRegistrarVentaTour.numRes.value = '';
			document.formRegistrarVentaTour.docu.value = '';
      
      limpiarSelect("selNombPax");
      
			document.formRegistrarVentaTour.cuarto.value = '';
			document.formRegistrarVentaTour.obsPax.value = '';
			document.formRegistrarVentaTour.numPax.value = '';
			document.formRegistrarVentaTour.precXPax.value = '';
			document.formRegistrarVentaTour.lugar.value = '';

			document.formRegistrarVentaTour.numPax2.value = '';
			document.formRegistrarVentaTour.precXPax2.value = '';
			document.formRegistrarVentaTour.celularPax.value = '';
			document.formRegistrarVentaTour.emailPax.value = '';
			document.formRegistrarVentaTour.docuPax.value = '';

			document.getElementById('labelTotal').innerHTML = '';
			document.getElementById('labelTotal2').innerHTML = '';
			document.getElementById('labelTotalTotal').innerHTML = '';

			//xajax_obtenerNroVoucherX();
			document.getElementById('labelNumVou').innerHTML = 'Voucher No. <?php echo $_SESSION["oficina"]."-"; ?>__';
			document.getElementById('labelCupos').innerHTML = '';
		}
		
		function ingresarOtroTour(){
			activarTablaRegistrarVenta();
			//document.formRegistrarVentaTour.selHotelPax.value = '<NULL>';
			//document.formRegistrarVentaTour.selNacPax.value = '<NULL>';
			
			cargarCampoTour('selNombPax');
			document.formRegistrarVentaTour.selTour.value = '<NULL>';
			document.formRegistrarVentaTour.selFechaTour.value = '<NULL>';
			
			//document.formRegistrarVentaTour.numRes.value = '';
			//document.formRegistrarVentaTour.selNombPax.value = '<NULL>';
			
			//document.formRegistrarVentaTour.cuarto.value = '';
			//document.formRegistrarVentaTour.obsPax.value = '';
			//document.formRegistrarVentaTour.numPax.value = '';
			//document.formRegistrarVentaTour.lugar.value = '';

			//xajax_obtenerNroVoucherX();
			document.getElementById('labelNumVou').innerHTML = 'Voucher No. <?php echo $_SESSION["oficina"]."-"; ?>__';
			document.getElementById('labelCupos').innerHTML = '';
		}
		
		function cancelarVentaTour(){
			limpiarTablaVentaTour();
		}
		
		function confirmarReservaTour(){
			/*
      var numRes = document.formRegistrarVentaTour.numRes.value;
			var selNombPax = document.formRegistrarVentaTour.selNombPax.value;
			*/
      var myArr = document.formRegistrarVentaTour.selNombPax.value.split("-");
      var numRes = myArr[0];
      var selNombPax = myArr[1];
      
      
      var selHotelPax = document.formRegistrarVentaTour.selHotelPax.value;
			var cuarto = document.formRegistrarVentaTour.cuarto.value;
			var selNacPax = document.formRegistrarVentaTour.selNacPax.value;
	
			var selTour = document.formRegistrarVentaTour.selTour.value;
			var selFechaTour = document.formRegistrarVentaTour.selFechaTour.value;			
			var obsPax = document.formRegistrarVentaTour.obsPax.value;
			var docuPax = document.formRegistrarVentaTour.docuPax.value;
			var numPax1 = document.formRegistrarVentaTour.numPax.value;
			var precXPax1 = document.formRegistrarVentaTour.precXPax.value;
			
			var numPax2 = document.formRegistrarVentaTour.numPax2.value;
			var precXPax2 = document.formRegistrarVentaTour.precXPax2.value;

			var celularPax = document.formRegistrarVentaTour.celularPax.value;
			var emailPax = document.formRegistrarVentaTour.emailPax.value;
			
			if(numPax1=='')
				numPax1 = 0;
			if(precXPax1=='')
				precXPax1 = 0;
			if(numPax2=='')
				numPax2 = 0;
			if(precXPax2=='')
				precXPax2 = 0;

			var total1 = (parseInt(numPax1)*parseInt(precXPax1));
			var total2 = (parseInt(numPax2)*parseInt(precXPax2));

			var total = total1 + total2;

			var numPaxTot = parseInt(numPax1) + parseInt(numPax2);

			document.getElementById('labelTotal').innerHTML = getValorConPuntos(total1);
			document.getElementById('labelTotal2').innerHTML = getValorConPuntos(total2);
			document.getElementById('labelTotalTotal').innerHTML = getValorConPuntos(total);

			var r = '';
			
			r = verificarCamposObligatorios(new Array(numRes,getValueXML('formRegistrarVentaTour','cajaNumResP')),
											new Array(selNombPax,getValueXML('formRegistrarVentaTour','selNombPax')),
											new Array(selHotelPax,getValueXML('formRegistrarVentaTour','selHotelPax')),
											new Array(selNacPax,getValueXML('formRegistrarVentaTour','selNacPax')),
											new Array(selTour,getValueXML('formRegistrarVentaTour','selTour')),
											new Array(selFechaTour,getValueXML('formRegistrarVentaTour','fechaTour'))
											);	
			
			if(r != ''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
      
			r = verificarLongitudCampos(new Array(obsPax,getValueXML('formRegistrarVentaTour','obsPax'),50) );
			
			if(r!=''){
				alert('Error\n'+r);
				return;
			}

			// Verificar cantidad de pasajeros
			if((numPaxTot==0)){
				alert('Error\n'+'Debe suministrar el numero de pasajeros.');
				return;
			}
      
			var pos = 0;			
			pos = document.formRegistrarVentaTour.selNombPax.selectedIndex;
			var nomPax = document.formRegistrarVentaTour.selNombPax.options[pos].text;
			var numResTot = numRes + '-' + selNombPax;
			
			
			xajax_confirmarReservaTour(numResTot, docuPax, nomPax, selHotelPax, cuarto,
									selNacPax, selTour, selFechaTour, obsPax,
									numPaxTot, numRes, selNombPax,
									precXPax1, total,
									numPax1, numPax2, precXPax2, celularPax, emailPax);											
		}
    
		function imprimirVentaTour(){
			var datosIni = 'datos';
				
			var pos = 0;
			pos = document.formRegistrarVentaTour.selFechaTour.selectedIndex;		

			var selFechaTour = document.formRegistrarVentaTour.selFechaTour.options[pos].text;				
			var val = selFechaTour.split(' ');
			
			var asesor = document.getElementById('labelUserName').innerHTML;
			var vAse = asesor.split(' - ');
      
			var fechaVenta = document.formRegistrarVentaTour.fechaDigita.value; 
			var numVou = document.formRegistrarVentaTour.nroVou.value; //document.getElementById('labelNumVou').innerHTML;;
			pos = document.formRegistrarVentaTour.selTour.selectedIndex;	
			var tour = document.formRegistrarVentaTour.selTour.options[pos].text;
			var fechaTour = val[0];
			var hora = val[1];
			var lugar = document.formRegistrarVentaTour.lugar.value;
			pos = document.formRegistrarVentaTour.selHotelPax.selectedIndex;
			var hotel = document.formRegistrarVentaTour.selHotelPax.options[pos].text;
			
			pos = document.formRegistrarVentaTour.selNombPax.selectedIndex;
			var selNombPax = document.formRegistrarVentaTour.selNombPax.options[pos].text;
      
		  var numRes = document.formRegistrarVentaTour.selNombPax.value;
			var numPax = document.formRegistrarVentaTour.numPax.value;
			var numPax2 = document.formRegistrarVentaTour.numPax2.value;
			var guia = document.formRegistrarVentaTour.proveedor.value;
      var telAsesor = document.getElementById('telUserName').value;
      
			if(numPax=='')
				numPax = 0;

			if(numPax2=='')
				numPax2 = 0;

			var agencia = document.formRegistrarVentaTour.codCli.value;
			var obsPax = document.formRegistrarVentaTour.obsPax.value;
			asesor = vAse[1];
			
      var vOfi = numVou.split('-');
      var oficina = vOfi[0];
      
      printVoucherTour(false, numVou, tour, fechaVenta, fechaTour, hora, lugar, hotel, agencia, 
                       selNombPax, numPax, numPax2, guia, telAsesor, asesor, obsPax, oficina, numRes);
                          
		}
		
		function desactivarTablaRegistrarVenta(){
			activarObj('btnImprimir');
			desactivarObj('btnGuardar');
			desactivarObj('selFechaTour');
			desactivarObj('selTour');
			desactivarObj('numRes');
			desactivarObj('docu');
			desactivarObj('selNombPax');
			desactivarObj('numPax');
			desactivarObj('cuarto');
			desactivarObj('selNacPax');
			desactivarObj('selHotelPax');
			desactivarObj('obsPax');

			desactivarObj('numPax2');
			desactivarObj('precXPax');
			desactivarObj('precXPax2');
			desactivarObj('celularPax');
			desactivarObj('emailPax');
		}
		
		function activarTablaRegistrarVenta(){
			desactivarObj('btnImprimir');
			activarObj('btnGuardar');
			activarObj('selFechaTour');
			activarObj('selTour');
			activarObj('numRes');
			activarObj('docu');
			activarObj('selNombPax');
			activarObj('numPax');
			activarObj('cuarto');
			activarObj('selNacPax');
			activarObj('selHotelPax');
			activarObj('obsPax');

			activarObj('numPax2');
			activarObj('precXPax');
			activarObj('precXPax2');
			activarObj('celularPax');
			activarObj('emailPax');
		}		
	</script>
	<br>
	<form name="formRegistrarVentaTour" id="formRegistrarVentaTour">
	<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
	<tr>
	<td width="10%">&nbsp;
		
	</td>
	
	<td width="80%">
		<table border="1" width="100%" height="100%" cellpadding="0" cellspacing="0">
		<tr>
		<td>		
		<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
			<tr bgcolor="#1373A6">
				<td align="center">
				<p class="textoTituloTablas"> 
					<?php printValueXML('formRegistrarVentaTour','etiqConfTour'); echo " en ".$_SESSION["oficinaname"]; ?>	
				</p>
				</td>	
			</tr>
					
			<tr>
				<td>
					<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
						<tr>
						
							<td width="50%">
								<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">											
									<tr>
										<td>
										<p class="textoFormTablas">
											<a id="labelNumVou" name="labelNumVou">Voucher No. <?php echo $_SESSION["oficina"]."-"."__"; ?></a>
                      <input type="hidden" id="nroVou" name="nroVou" value="">
										</p>
										</td>	
									</tr>
									
									<tr>
										<td>
										<p class="textoFormTablas"> 
											Buscar por <?php printValueXML('formRegistrarVentaTour','numRes'); ?>
											<input type="text" id="numRes" name="numRes" class="cajaNumResP" onKeyUp="cargarSelNombPax(event, this.id);"/>
                      &nbsp;&nbsp;&nbsp;&nbsp;&oacute;&nbsp;&nbsp;&nbsp;&nbsp;
                      <?php printValueXML('formRegistrarVentaTour','docu'); ?>
											<input type="text" id="docu" name="docu" class="cajaDocuP" onKeyUp="cargarSelNombPaxXDoc(event, this.id);"/>
										</p>
										</td>	
									</tr>
									
									<tr>
										<td>
										<p class="textoFormTablas"> 
											<?php printValueXML('formRegistrarVentaTour','selNombPax'); ?>
											<select name="selNombPax" id="selNombPax" class="selSelNombPax" onChange="cargarCampoTour(this.id);">
												<option value='<NULL>' selected='selected'></option>
											</select>&nbsp;&nbsp;
										</p>
										</td>	
									</tr>

									<tr>
										<td>
										<p class="textoFormTablas"> 
										Doc: <input type="text" id="docuPax" name="docuPax" class="cajaCelularPax"  placeholder="opcional" readonly/>&nbsp;&nbsp;Celular: <input type="text" id="celularPax" name="celularPax" class="cajaCelularPax" placeholder="opcional"/>
										</p>
										</td>	
									</tr>

									<tr>
										<td>
										<p class="textoFormTablas"> 
											Email: <input type="text" id="emailPax" name="emailPax" class="cajaEmailPax" placeholder="opcional"/>
										</p>
										</td>	
									</tr>
									
									<tr>
										<td>
										<p class="textoFormTablas">
											<?php printValueXML('formRegistrarVentaTour','selHotelPax'); ?>
											<select name="selHotelPax" id="selHotelPax" class="selSelHotelPax">
												<option value='<NULL>' selected='selected'>- Seleccione -</option>
												<?php printOpcionesCodHot(); ?>
											</select>&nbsp;&nbsp;
											<?php printValueXML('formRegistrarVentaTour','cuarto'); ?> <input type="text" id="cuarto" name="cuarto" class="cajaCuarto" placeholder="opcional"/>
										</p>
										</td>	
									</tr>
									
									<tr>
										<td>
										<p class="textoFormTablas"> 
											<?php printValueXML('formRegistrarVentaTour','selNacPax'); ?>
											<select name="selNacPax" id="selNacPax" class="selSelNacPax">
												<option value='<NULL>' selected='selected'>- Seleccione -</option>
												<?php printOpcionesCodNac(); ?>
											</select>
										</p>
										</td>	
									</tr>
								
								</table>								
							</td>
							
							<td width="50%">
								<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">											
									<tr>
										<td>
										<p class="textoFormTablas">
											<?php printValueXML('formRegistrarVentaTour','selTour'); ?>
											<select name="selTour" id="selTour" class="selSelTour" onChange="cargarCampoFechaTour(this.id);">
												<option value='<NULL>' selected='selected'></option>
											</select>					
										</p>
										</td>	
									</tr>
									
									<tr>
										<td>
										<p class="textoFormTablas">
											<?php printValueXML('formRegistrarVentaTour','fechaTour'); ?> </a>
											<select name="selFechaTour" id="selFechaTour" class="selSelFechaTour" onChange="cargarLugarTour(this.id);">
												<option value='<NULL>' selected='selected'></option>
											</select>
										</p>
										</td>	
									</tr>
									
									<tr>
										<td>
										<p class="textoFormTablas"> 
											<?php printValueXML('formRegistrarTour','cuposDisp'); ?> <a id="labelCupos" name="labelCupos"></a>
										</p>
										</td>	
									</tr>
									
									<tr>
										<td>
										<p class="textoFormTablas"> 
											<?php printValueXML('formRegistrarVentaTour','lugar'); ?> <input type="text" id="lugar" name="lugar" class="cajaLugar" disabled="disabled"/>
										</p>
										</td>	
									</tr>			
													
								</table>							
							</td>
							
						</tr>
					</table>
				</td>	
			</tr>



			<tr>
				<td>
				<p class="textoFormTablas">					
					<?php printValueXML('formRegistrarVentaTour','numPax'); ?> 
					<input type="text" id="numPax" name="numPax" class="cajaNumPaxSmall" onKeyUp="pasarFocoOnEnter(event,this.id, document.formRegistrarVentaTour.precXPax.id); calcularTotal_1(event, this.id);" />&nbsp;&nbsp;
					
					<?php /*printValueXML('formRegistrarVentaTour','precXPax');*/ ?>
					<input type="hidden" id="precXPax" name="precXPax" class="cajaPrecXPaxSmall" onKeyUp="calcularTotal_2(event, this.id);"/>&nbsp;&nbsp;	

					<?php /*printValueXML('formRegistrarVentaTour','tot');*/ ?> 
					<a id="labelTotal" name="labelTotal" style="visibility: hidden;"></a>
				</p>
				</td>	
			</tr>
			<tr>
				<td>
				<p class="textoFormTablas">					
					<?php printValueXML('formRegistrarVentaTour','numPax2'); ?> 
					<input type="text" id="numPax2" name="numPax2" class="cajaNumPaxSmall" onKeyUp="pasarFocoOnEnter(event,this.id, document.formRegistrarVentaTour.precXPax2.id); calcularTotal_12(event, this.id);" />&nbsp;&nbsp;

					<?php /*printValueXML('formRegistrarVentaTour','precXPax2');*/ ?>
					<input type="hidden" id="precXPax2" name="precXPax2" class="cajaPrecXPaxSmall" onKeyUp="calcularTotal_22(event, this.id);"/>&nbsp;&nbsp;		

					<?php /*printValueXML('formRegistrarVentaTour','tot');*/ ?> 
					<a id="labelTotal2" name="labelTotal2" style="visibility: hidden;"></a>
				</p>
				</td>	
			</tr>	
			<tr>
				<td>
				<p class="textoFormTablas">					
					<?php /*printValueXML('formRegistrarVentaTour','totalTotal');*/ ?> 
					<a id="labelTotalTotal" name="labelTotalTotal" style="visibility: hidden;"></a>	
				</p>
				</td>	
			</tr>

			
			<tr>
				<td>
				<center>
				<p class="textoFormTablas">					
					<?php printValueXML('formRegistrarVentaTour','obsPax'); ?> <input type="text" id="obsPax" name="obsPax" class="cajaObsPax" placeholder="opcional"/>&nbsp;&nbsp;&nbsp		
				</p>
				</center>
				</td>	
			</tr>
			
			<tr>
				<td>
					<input type="hidden" id="proveedor" name="proveedor"/>
					<input type="hidden" id="fechaDigita" name="fechaDigita"/>
					<input type="hidden" id="codCli" name="codCli"/>
					<input type="hidden" id="voucher" name="voucher"/>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas">
					<center>										
					<input type="button" id="btnGuardar" name="btnGuardar" value="<?php printValueXML('formRegistrarVentaTour','btnGuardar') ?>" onclick="confirmarReservaTour();" class="boton btnTablas2" onmouseover="className='botonHover btnTablas2'" onmouseout="className='boton btnTablas2'" />
					&nbsp;&nbsp;&nbsp;
					<input type="button" id="btnImprimir" name="btnImprimir" value="<?php printValueXML('formRegistrarVentaTour','btnImprimir') ?>" onclick="imprimirVentaTour();" class="boton btnTablas2" onmouseover="className='botonHover btnTablas2'" onmouseout="className='boton btnTablas2'" disabled="disabled"/>
					&nbsp;&nbsp;&nbsp;
					<input type="button" id="ingresarOtro" name="ingresarOtro" value="Ingresar otro Tour" onclick="ingresarOtroTour();" class="boton btnTablas4" onmouseover="className='botonHover btnTablas4'" onmouseout="className='boton btnTablas4'"/>
					&nbsp;&nbsp;&nbsp;
					<input type="button" id="btnLimpiar" name="btnLimpiar" value="<?php printValueXML('formRegistrarVentaTour','btnLimpiar') ?>" onclick="limpiarTablaVentaTour();" class="boton btnTablas3" onmouseover="className='botonHover btnTablas3'" onmouseout="className='boton btnTablas3'"/>
					</center>
				</p>
				</td>	
			</tr>
		</table>			
		</td>	
		</tr>		
		</table>					
	</td>
	
	<td width="10%">&nbsp;
		
	</td>
	</tr>
	</table>
	</form>	
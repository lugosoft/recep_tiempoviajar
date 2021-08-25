	<?php
		$verifPermiso = false;
		$verifPermiso = verificarPermiso($_SESSION["user"], 'TOU2');
		if ($verifPermiso == false){
			echo"<script>mostrarMsg('errorPaginaNoPermitida');</script>";
			echo"<a class='textoNoPermisos'>".getValueXML('mensajes', 'errorPaginaNoPermitida')."</a>";
			return;
		}
		
	?>	
	<?php /*obtenerNroVoucher();*/ ?>
	<script>
		//xajax_obtenerNroVoucherX();
		
		function cargarCampoFechaTour(idSelec){
			var cod = document.getElementById(idSelec);
			xajax_cargarSelFechaTour3(cod.value);
		}
		
		function cargarLugarTour(idSelec){
			var cod = document.getElementById(idSelec);
			document.getElementById('labelCupos').innerHTML = '';
			document.formRegistrarVentaTour.lugar.value = '';
			xajax_cargarLugarTour(cod.value);
		}
		
		function cargarInfoContacto(e, idCaja) {
			if (((document.all)?e.keyCode:e.which)=="13"){
				var docu = document.getElementById(idCaja).value;	
				xajax_cargarInfoContacto(docu);
			}
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
			document.formRegistrarVentaTour.selTour.value = '<NULL>';
			document.formRegistrarVentaTour.selFechaTour.value = '<NULL>';
			
			document.formRegistrarVentaTour.docuPax.value = '';
			document.formRegistrarVentaTour.nomPax.value = '';
			document.formRegistrarVentaTour.cuarto.value = '';
			document.formRegistrarVentaTour.obsPax.value = '';
			document.formRegistrarVentaTour.numPax.value = '';
			document.formRegistrarVentaTour.precXPax.value = '';
			document.formRegistrarVentaTour.lugar.value = '';

			document.formRegistrarVentaTour.numPax2.value = '';
			document.formRegistrarVentaTour.precXPax2.value = '';
			document.formRegistrarVentaTour.celularPax.value = '';
			document.formRegistrarVentaTour.emailPax.value = '';


			document.getElementById('labelTotal').innerHTML = '';
			document.getElementById('labelTotal2').innerHTML = '';
			document.getElementById('labelTotalTotal').innerHTML = '';
			//xajax_obtenerNroVoucherX();
			document.getElementById('labelNumVou').innerHTML = 'Voucher No. <?php echo $_SESSION["oficina"]."-"; ?>__';
			document.getElementById('labelCupos').innerHTML = '';
		}
		
		function cancelarVentaTour(){
			limpiarTablaVentaTour();
		}
		
		function registrarVentaTour(){
			var docuPax = document.formRegistrarVentaTour.docuPax.value;
			var nomPax = document.formRegistrarVentaTour.nomPax.value.toUpperCase();
			var selHotelPax = document.formRegistrarVentaTour.selHotelPax.value;
			var cuarto = document.formRegistrarVentaTour.cuarto.value;
			var selNacPax = document.formRegistrarVentaTour.selNacPax.value;
	
			var selTour = document.formRegistrarVentaTour.selTour.value;
			var selFechaTour = document.formRegistrarVentaTour.selFechaTour.value;			
			var obsPax = document.formRegistrarVentaTour.obsPax.value;
			
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
			
			r = verificarCamposObligatorios(new Array(docuPax,getValueXML('formRegistrarVentaTour','docuPax')),
											new Array(nomPax,getValueXML('formRegistrarVentaTour','nomPax')),
											new Array(selHotelPax,getValueXML('formRegistrarVentaTour','selHotelPax')),
											new Array(selNacPax,getValueXML('formRegistrarVentaTour','selNacPax')),
											new Array(selTour,getValueXML('formRegistrarVentaTour','selTour')),
											new Array(selFechaTour,getValueXML('formRegistrarVentaTour','fechaTour'))
											);	
			
			if(r != ''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
			
			r = verificarLongitudCampos(new Array(docuPax,getValueXML('formRegistrarVentaTour','docuPax'),20),
										new Array(nomPax,getValueXML('formRegistrarVentaTour','nomPax'),50),
										new Array(cuarto,getValueXML('formRegistrarVentaTour','cuarto'),20),
										new Array(obsPax,getValueXML('formRegistrarVentaTour','obsPax'),50)
										);
			
			if(r!=''){
				alert('Error\n'+r);
				return;
			}

			// Verificar cantidad de pasajeros
			if((numPaxTot==0)){
				alert('Error\n'+'Debe suministrar el numero de pasajeros.');
				return;
			}

			xajax_registrarVentaTour(docuPax, nomPax, selHotelPax, cuarto,
									selNacPax, selTour, selFechaTour, obsPax,
									numPaxTot, precXPax1, total,
									numPax1, numPax2, precXPax2, celularPax, emailPax);										
		}

		function imprimirVentaTour(){
			var datosIni = 'datos';
			//var ventimp = window.open(' ', 'popimpr');		
			//var ventimp = window.open("https://tourstiempodeviajar.lugo.host/?id=32", "_blank");	
      
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
			var cuarto = document.formRegistrarVentaTour.cuarto.value;
			var nomPax = document.formRegistrarVentaTour.nomPax.value.toUpperCase();
			var tele = document.formRegistrarVentaTour.celularPax.value;
			var numPax = document.formRegistrarVentaTour.numPax.value;
			var precioPP = document.formRegistrarVentaTour.precXPax.value;
			
			var numPax2 = document.formRegistrarVentaTour.numPax2.value;
      var guia = document.formRegistrarVentaTour.proveedor.value;
      var telAsesor = document.getElementById('telUserName').value;
      
			if(numPax=='')
				numPax = 0;

			if(numPax2=='')
				numPax2 = 0;

			var obsPax = document.formRegistrarVentaTour.obsPax.value; 
			
			asesor = vAse[1];	

      var vOfi = numVou.split('-');
      var oficina = vOfi[0];
			
			printVoucherTour(false, numVou, tour, fechaVenta, fechaTour, hora, lugar, hotel, 'N/A', 
                       nomPax, numPax, numPax2, guia, telAsesor, asesor, obsPax, oficina, '');

		}
		
		function desactivarTablaRegistrarVenta(){
			activarObj('btnImprimir');
			desactivarObj('btnGuardar');
			desactivarObj('selFechaTour');
			desactivarObj('selTour');
			desactivarObj('docuPax');
			desactivarObj('nomPax');
			desactivarObj('numPax');
			desactivarObj('precXPax');
			desactivarObj('cuarto');
			desactivarObj('selNacPax');
			desactivarObj('selHotelPax');
			desactivarObj('obsPax');
			desactivarObj('numPax2');
			desactivarObj('precXPax2');
			desactivarObj('celularPax');
			desactivarObj('emailPax');
		}
		
		function activarTablaRegistrarVenta(){
			desactivarObj('btnImprimir');
			activarObj('btnGuardar');
			activarObj('selFechaTour');
			activarObj('selTour');
			activarObj('docuPax');
			activarObj('nomPax');
			activarObj('numPax');
			activarObj('precXPax');
			activarObj('cuarto');
			activarObj('selNacPax');
			activarObj('selHotelPax');
			activarObj('obsPax');
			activarObj('numPax2');
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
					<?php printValueXML('formRegistrarVentaTour','etiqRegTour'); echo " en ".$_SESSION["oficinaname"]; ?>	
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
											<?php printValueXML('formRegistrarVentaTour','docuPax'); ?> <input type="text" id="docuPax" name="docuPax" class="cajaDocuPax" onKeyUp="cargarInfoContacto(event, this.id);" />
										</p>
										</td>	
									</tr>
									
									<tr>
										<td>
										<p class="textoFormTablas"> 
											<?php printValueXML('formRegistrarVentaTour','nomPax'); ?> <input type="text" id="nomPax" name="nomPax" class="cajaNombPax"/>
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
												<option value='<NULL>' selected='selected'>- Seleccione -</option>
												<?php printOpcionesCodSer(); ?>
											</select>					
										</p>
										</td>	
									</tr>
									
									<tr>
										<td>
										<p class="textoFormTablas">
											<?php printValueXML('formRegistrarVentaTour','fechaTour'); ?> </a>
											<select name="selFechaTour" id="selFechaTour" class="selSelFechaTour" onChange="cargarLugarTour(this.id);">
												<option value='<NULL>' selected='selected'>- Seleccione -</option>
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
				<left>
				<p class="textoFormTablas">					
					Celular: <input type="text" id="celularPax" name="celularPax" class="cajaCelularPax" placeholder="opcional"/>&nbsp;&nbsp;&nbsp;
					Email: <input type="text" id="emailPax" name="emailPax" class="cajaEmailPax" placeholder="opcional"/>
				</p>
				</left>
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
				<center>
				<p class="textoFormTablas">	
					
					<?php printValueXML('formRegistrarVentaTour','numPax'); ?>
					<input type="text" id="numPax" name="numPax" class="cajaNumPax" onKeyUp="pasarFocoOnEnter(event,this.id, document.formRegistrarVentaTour.precXPax.id); calcularTotal_1(event, this.id);"/>&nbsp;&nbsp;&nbsp;
					
					<?php printValueXML('formRegistrarVentaTour','precXPax'); ?>
					<input type="text" id="precXPax" name="precXPax" class="cajaPrecXPax" onKeyUp="calcularTotal_2(event, this.id);"/>&nbsp;&nbsp;&nbsp;
					
					<?php printValueXML('formRegistrarVentaTour','total'); ?> 
					<a id="labelTotal" name="labelTotal"></a>				
				</p>
				</center>
				</td>	
			</tr>
			
			<tr>
				<td>
				<center>
				<p class="textoFormTablas">					
					<?php printValueXML('formRegistrarVentaTour','numPax2'); ?> 
					<input type="text" id="numPax2" name="numPax2" class="cajaNumPax" onKeyUp="pasarFocoOnEnter(event,this.id, document.formRegistrarVentaTour.precXPax2.id); calcularTotal_12(event, this.id);"/>&nbsp;&nbsp;&nbsp;
					
					<?php printValueXML('formRegistrarVentaTour','precXPax2'); ?> 
					<input type="text" id="precXPax2" name="precXPax2" class="cajaPrecXPax" onKeyUp="calcularTotal_22(event, this.id);"/>&nbsp;&nbsp;&nbsp;
					
					<?php printValueXML('formRegistrarVentaTour','total2'); ?> 
					<a id="labelTotal2" name="labelTotal2"></a>				
				</p>
				</center>
				</td>	
			</tr>

			<tr>
				<td>
				<center>
				<p class="textoFormTablas">					
					<?php printValueXML('formRegistrarVentaTour','totalTotal'); ?> 
					<a id="labelTotalTotal" name="labelTotalTotal"></a>				
				</p>
				</center>
				</td>	
			</tr>

			<tr>
				<td>
					<input type="hidden" id="proveedor" name="proveedor"/>
					<input type="hidden" id="fechaDigita" name="fechaDigita"/>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas">
					<center>										
					<input type="button" id="btnGuardar" name="btnGuardar" value="<?php printValueXML('formRegistrarVentaTour','btnGuardar') ?>" onclick="registrarVentaTour();" class="boton btnTablas2" onmouseover="className='botonHover btnTablas2'" onmouseout="className='boton btnTablas2'" />
					&nbsp;&nbsp;&nbsp;
					<input type="button" id="btnImprimir" name="btnImprimir" value="<?php printValueXML('formRegistrarVentaTour','btnImprimir') ?>" onclick="imprimirVentaTour();" class="boton btnTablas2" onmouseover="className='botonHover btnTablas2'" onmouseout="className='boton btnTablas2'" disabled="disabled"/>
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
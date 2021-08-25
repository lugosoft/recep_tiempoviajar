	<?php
		$verifPermiso = false;
		$verifPermiso = verificarPermiso($_SESSION["user"], 'TOU1');
		if ($verifPermiso == false){
			echo"<script>mostrarMsg('errorPaginaNoPermitida');</script>";
			echo"<a class='textoNoPermisos'>".getValueXML('mensajes', 'errorPaginaNoPermitida')."</a>";
			return;
		}
		
	?>	
	<script>
		function cargarCampoProveedor(idSelec){
			var cod = document.getElementById(idSelec);
			xajax_cargarSelProveedor(cod.value);
		}
		
		function cargarCampoCupos(idSelec){
			var cod = document.getElementById(idSelec);
			desactivarObj('cupos');
			xajax_cargarCampoCupos(cod.value);
		}
		
		function registrarTour(){
			var selTour = document.formRegistrarTour.selTour.value;
			var fechaTourIni = document.formRegistrarTour.fechaTourIni.value;
      var fechaTourFin = document.formRegistrarTour.fechaTourFin.value;
			var horaTour = document.formRegistrarTour.horaTour.value;
			var lugar = document.formRegistrarTour.lugar.value;
			var selProv = document.formRegistrarTour.selProv.value;
			var cupos = document.formRegistrarTour.cupos.value;
			var selOficina = document.formRegistrarTour.selOficina.value;
      
			var r = '';
			
			r = verificarCamposObligatorios(new Array(selTour,getValueXML('formRegistrarTour','selTour')),
											new Array(fechaTourIni,getValueXML('formRegistrarTour','fechaTourIni')), 
											new Array(fechaTourFin,getValueXML('formRegistrarTour','fechaTourFin')), 
											new Array(horaTour,getValueXML('formRegistrarTour','horaTour')),
											new Array(lugar,getValueXML('formRegistrarTour','lugar')),
											new Array(selProv,getValueXML('formRegistrarTour','selProv')),
											new Array(cupos,getValueXML('formRegistrarTour','cupos'))
											);	
			
			if(r != ''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
			
			r = verificarLongitudCampos(new Array(fechaTourIni,getValueXML('formRegistrarTour','fechaTourIni'),10), 
                                  new Array(horaTour,getValueXML('formRegistrarTour','horaTour'),5),
                                  new Array(lugar,getValueXML('formRegistrarTour','lugar'),50)
                                  );
			
			if(r!=''){
				alert('Error\n'+r);
				return;
			}
			
			fechaTourIni = getFechaInterfazToYYYY_MM_DD(fechaTourIni);
			fechaTourFin = getFechaInterfazToYYYY_MM_DD(fechaTourFin);
      
			xajax_registrarTourRango(selTour, fechaTourIni, fechaTourFin, horaTour, lugar, selProv, cupos, selOficina);											
		}
		
		function limpiarTour(){
			activarTour();
			document.formRegistrarTour.selTour.value = '<NULL>';			
			document.formRegistrarTour.selProv.value = '<NULL>';
			
			document.formRegistrarTour.fechaTourIni.value = '';
      document.formRegistrarTour.fechaTourFin.value = '';				
			document.formRegistrarTour.horaTour.value = '';			
			document.formRegistrarTour.lugar.value = '';	
			document.formRegistrarTour.cupos.value = '0';
		}
		
		function limpiarTour2(){
			activarTour();
			//document.formRegistrarTour.selTour.value = '<NULL>';			
			//document.formRegistrarTour.selProv.value = '<NULL>';
			
			document.formRegistrarTour.fechaTourIni.value = '';			
			document.formRegistrarTour.fechaTourFin.value = '';			
			//document.formRegistrarTour.horaTour.value = '';			
			//document.formRegistrarTour.lugar.value = '';	
			//document.formRegistrarTour.cupos.value = '0';
		}
		
		function cancelarTour(){
			limpiarTour();
		}
		
		function desactivarTour(){
			desactivarObj('selTour');
			desactivarObj('selProv');
			desactivarObj('fechaTourIni');
      desactivarObj('fechaTourFin');
			desactivarObj('horaTour');
			desactivarObj('lugar');
			desactivarObj('cupos');
		}
		
		function activarTour(){
			activarObj('selTour');
			activarObj('selProv');
			activarObj('fechaTourIni');
      activarObj('fechaTourFin');
			activarObj('horaTour');
			activarObj('lugar');
			activarObj('cupos');
		}
		
	</script>
	<br>
	<form name="formRegistrarTour" id="formRegistrarTour">
	<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
	<tr>
	<td width="30%">&nbsp;
		
	</td>
	
	<td width="40%">
		<table border="1" width="100%" height="100%" cellpadding="0" cellspacing="0">
		<tr>
		<td>
		
		<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
			<tr bgcolor="#1373A6">
				<td align="center">
				<p class="textoTituloTablas"> 
					<?php printValueXML('formRegistrarTour','etiqRegTour'); ?>	
				</p>
				</td>	
			</tr>

			<tr>
				<td>
				<p class="textoFormTablas">
					<?php printValueXML('formRegistrarTour','selOficina'); ?>
          <select name="selOficina" id="selOficina" class="selSelOficina">
            <?php printOpcionesCodOfi($_SESSION["oficina"]); ?>
          </select>				
				</p>
				</td>	
			</tr>
      
			<tr>
				<td>
				<p class="textoFormTablas">
					<?php printValueXML('formRegistrarTour','selTour'); ?>
					<select name="selTour" id="selTour" class="selSelTour" onChange="cargarCampoProveedor(this.id);">
						<option value='<NULL>' selected='selected'>- Seleccione -</option>
						<?php printOpcionesCodSer(); ?>
					</select>					
				</p>
				</td>	
			</tr>		

			<tr>
				<td>
				<p class="textoFormTablas">
					<?php printValueXML('formRegistrarTour','fechaTourIni'); ?> </a>
					<input type="text" id="fechaTourIni" name="fechaTourIni" value="<?php echo(getFechaddmmyyyy());?>" class="cajaFecSerTrans" onkeyup="mascaraFecha(this,'/');" maxlength="10" />
					<img src='images/calendar.gif' class='imgCalendario' id='imgFecTourIni' name='imgFecTourIni' title='Seleccione fecha' alt='Seleccione fecha' style='cursor:pointer;' onclick="<?php echo getFechasDeshabilitadas(1); ?> scwShow(scwID('fechaTourIni'),event,'es');">
					
          &nbsp;&nbsp;
          <?php printValueXML('formRegistrarTour','fechaTourFin'); ?> </a> </a>
					<input type="text" id="fechaTourFin" name="fechaTourFin" value="<?php echo(getFechaddmmyyyy());?>" class="cajaFecSerTrans" onkeyup="mascaraFecha(this,'/');" maxlength="10" />
					<img src='images/calendar.gif' class='imgCalendario' id='imgFecTourFin' name='imgFecTourFin' title='Seleccione fecha' alt='Seleccione fecha' style='cursor:pointer;' onclick="<?php echo getFechasDeshabilitadas(1); ?> scwShow(scwID('fechaTourFin'),event,'es');">
          
          &nbsp;&nbsp;
					<?php printValueXML('formRegistrarTour','horaTour'); ?>
					<input type="text" id="horaTour" name="horaTour" class="cajaHoraVlo" onKeyUp="mascaraHora(this);" />
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formRegistrarTour','lugar'); ?> <input type="text" id="lugar" name="lugar" class="cajaLugar"/>
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formRegistrarTour','selProv'); ?>
					<select name="selProv" id="selProv" class="selSelProv" onChange="cargarCampoCupos(this.id);">						
					</select>
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formRegistrarTour','cupos'); ?> <input type="text" id="cupos" name="cupos" value="0" class="cajaCupos"/>
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas">
					<center>										
					<input type="button" id="btnGuardar" name="btnGuardar" value="<?php printValueXML('formRegistrarTour','btnGuardar') ?>" onclick="registrarTour();" class="boton btnTablas2" onmouseover="className='botonHover btnTablas2'" onmouseout="className='boton btnTablas2'" />
					&nbsp;&nbsp;&nbsp;
					<input type="button" id="btnLimpiar" name="btnLimpiar" value="Limpiar Fecha" onclick="limpiarTour2();" class="boton btnTablas3" onmouseover="className='botonHover btnTablas3'" onmouseout="className='boton btnTablas3'" />
					&nbsp;&nbsp;&nbsp;
					<input type="button" id="btnLimpiar" name="btnLimpiar" value="<?php printValueXML('formRegistrarTour','btnLimpiar') ?>" onclick="limpiarTour();" class="boton btnTablas3" onmouseover="className='botonHover btnTablas3'" onmouseout="className='boton btnTablas3'" />
					</center>
				</p>
				</td>	
			</tr>				
							
		</table>	
		
		</td>	
		</tr>		
		</table>					
	</td>
	
	<td width="30%">&nbsp;
		
	</td>
	</tr>
	</table>
	</form>	
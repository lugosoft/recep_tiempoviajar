	<?php
		$verifPermiso = false;
		$verifPermiso = verificarPermiso($_SESSION["user"], 'TOU4');
		if ($verifPermiso == false){
			echo"<script>mostrarMsg('errorPaginaNoPermitida');</script>";
			echo"<a class='textoNoPermisos'>".getValueXML('mensajes', 'errorPaginaNoPermitida')."</a>";
			return;
		}
		
	?>	
	<script>
		function cargarCampoFechaTour(idSelec){
			var cod = document.getElementById(idSelec);
			xajax_cargarSelFechaTour2(cod.value);
		}
		
		function cargarCampoSelNomPax(idSelec){
			var cod = document.getElementById(idSelec);
			xajax_cargarCampoSelNomPax(cod.value);
		}
		
		function cargarCampoNumPax(idSelec){
			var cod = document.getElementById(idSelec);
			xajax_cargarCampoNumPax(cod.value);
		}
		
		function limpiarAnularTour(){
			document.formAnularTour.selTour.value = '<NULL>';
			document.formAnularTour.selFechaTour.value = '<NULL>';
			document.formAnularTour.selNomPax.value = '<NULL>';
			document.getElementById('labelNumpax').innerHTML = '';
		}
		
		function cancelarAsistenciaTour(){
			var selTour = document.formAnularTour.selTour.value;
			var selFechaTour = document.formAnularTour.selFechaTour.value;
			var selNomPax = document.formAnularTour.selNomPax.value;
			var r = '';
			
			r = verificarCamposObligatorios(new Array(selTour,getValueXML('formAnularTour','selTour')),
											new Array(selFechaTour,getValueXML('formAnularTour','selFechaTour')),
											new Array(selNomPax,getValueXML('formAnularTour','selNomPax'))
											);	
			
			if(r != ''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
			
			xajax_preCancelarAsistenciaTour(selNomPax);											
		}		
		
	</script>
	<br>
	<form name="formAnularTour" id="formAnularTour">
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
					<?php printValueXML('formAnularTour','etiqAnuTour'); echo " en ".$_SESSION["oficinaname"]; ?>	
				</p>
				</td>	
			</tr>
					
			<tr>
				<td>
				<p class="textoFormTablas">
					<?php printValueXML('formAnularTour','selTour'); ?>
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
					<?php printValueXML('formAnularTour','selFechaTour'); ?> </a>
					<select name="selFechaTour" id="selFechaTour" class="selSelFechaTour" onChange="cargarCampoSelNomPax(this.id);">
						<option value='<NULL>' selected='selected'>- Seleccione -</option>
					</select>
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formAnularTour','selNomPax'); ?>
					<select name="selNomPax" id="selNomPax" class="selSelNombPax2" onChange="cargarCampoNumPax(this.id);">
						<option value='<NULL>' selected='selected'>- Seleccione -</option>
					</select>&nbsp;&nbsp;
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formAnularTour','numPax'); ?> <a id="labelNumpax" name="labelCupos"></a>
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas">
					<center>										
					<input type="button" id="btnAnular" name="btnAnular" value="<?php printValueXML('formAnularTour','btnAnular') ?>" onclick="cancelarAsistenciaTour();" class="boton btnTablas2" onmouseover="className='botonHover btnTablas2'" onmouseout="className='boton btnTablas2'" />
					&nbsp;&nbsp;&nbsp;
					<input type="button" id="btnLimpiar" name="btnLimpiar" value="<?php printValueXML('formAnularTour','btnLimpiar') ?>" onclick="limpiarAnularTour();" class="boton btnTablas3" onmouseover="className='botonHover btnTablas3'" onmouseout="className='boton btnTablas3'" />
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
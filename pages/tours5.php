	<?php
		$verifPermiso = false;
		$verifPermiso = verificarPermiso($_SESSION["user"], 'TOU5');
		if ($verifPermiso == false){
			echo"<script>mostrarMsg('errorPaginaNoPermitida');</script>";
			echo"<a class='textoNoPermisos'>".getValueXML('mensajes', 'errorPaginaNoPermitida')."</a>";
			return;
		}
		
	?>		
	<script>
		function resetCampoFechaTour(){
			limpiarAnularTour();
		}
    
    function cargarCampoFechaTour(idSelec){
			var cod = document.getElementById(idSelec);
			var ofi = document.getElementById('selOficina').value;
			xajax_cargarSelFechaTour4(cod.value, ofi);
		}
		
		function cargarCampoCuposTour(idSelec){
			var cod = document.getElementById(idSelec);
			xajax_cargarCampoCuposTour(cod.value);
		}
		
		
		function limpiarAnularTour(){
			document.formAnularTour.selTour.value = '<NULL>';
			document.formAnularTour.selFechaTour.value = '<NULL>';
			document.getElementById('labelCuposCreados').innerHTML = '';
			document.getElementById('labelCuposConfirmados').innerHTML = '';
			activarObj('btnAnular');
		}
		
		function cancelarProgramacionTour(){
			var selTour = document.formAnularTour.selTour.value;
			var selFechaTour = document.formAnularTour.selFechaTour.value;
      var selOficina = document.formAnularTour.selOficina.value;
			var r = '';
			
			r = verificarCamposObligatorios(new Array(selTour,getValueXML('formAnularTour','selTour')),
											new Array(selFechaTour,getValueXML('formAnularTour','selFechaTour'))
											);	
			
			if(r != ''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
			
			xajax_cancelarProgramacionTour(selFechaTour, selOficina);											
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
					<?php printValueXML('formAnularTour','etiqAnuProgTour'); ?>	
				</p>
				</td>	
			</tr>

			<tr>
				<td>
				<p class="textoFormTablas">
					<?php printValueXML('formAnularTour','selOficina'); ?>
          <select name="selOficina" id="selOficina" class="selSelOficina" onChange="resetCampoFechaTour();">
            <?php printOpcionesCodOfi($_SESSION["oficina"]); ?>
          </select>				
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
					<select name="selFechaTour" id="selFechaTour" class="selSelFechaTour" onChange="cargarCampoCuposTour(this.id);">
						<option value='<NULL>' selected='selected'>- Seleccione -</option>
					</select>
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formAnularTour','cuposCreados'); ?> <a id="labelCuposCreados" name="labelCuposCreados"></a>
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formAnularTour','cuposConfirmados'); ?> <a id="labelCuposConfirmados" name="labelCuposConfirmados"></a>
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas">
					<center>										
					<input type="button" id="btnAnular" name="btnAnular" value="<?php printValueXML('formAnularTour','btnAnular') ?>" onclick="cancelarProgramacionTour();" class="boton btnTablas2" onmouseover="className='botonHover btnTablas2'" onmouseout="className='boton btnTablas2'" />
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
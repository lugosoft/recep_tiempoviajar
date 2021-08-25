		<script>
		
		function cambiarPassword(){
			var passActual = document.formCambioPassword.passActual.value;
			var passNuevo1 = document.formCambioPassword.passNuevo1.value;
			var passNuevo2 = document.formCambioPassword.passNuevo2.value;
			var usuario = document.formCambioPassword.usuario.value;
			
			if(passNuevo1 != passNuevo2){
				mostrarMsg('errorPasswordNoCoincide');
				return;
			}
			
			var r = '';
			
			r = verificarCamposObligatorios(new Array(passActual,getValueXML('formCambioPassword','passActual')),
											new Array(passNuevo1,getValueXML('formCambioPassword','passNuevo1')), 
											new Array(passNuevo2,getValueXML('formCambioPassword','passNuevo2')),
											new Array(usuario,getValueXML('formCambioPassword','usuario'))
											);	
			
			if(r != ''){
				mostrarMsg('errorCamposObligatorios','\n'+r);
				return;
			}
			
			r = verificarLongitudCampos(new Array(passNuevo1,getValueXML('formCambioPassword','passNuevo1'),15)
										);
			
			if(r!=''){
				alert('Error\n'+r);
				return;
			}
			
			xajax_cambiarPassword(usuario, passActual, passNuevo1);											
		}
		
		function limpiarPassword(){	
			document.formCambioPassword.passActual.value = '';			
			document.formCambioPassword.passNuevo1.value = '';		
			document.formCambioPassword.passNuevo2.value = '';
		}
		
		function cancelarPassword(){
			limpiarPassword();
		}
		
	</script>
	<br>
	<form name="formCambioPassword" id="formCambioPassword">
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
					<?php printValueXML('formCambioPassword','etiqCambioPass'); ?>	
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas">
					<?php printValueXML('formCambioPassword','usuario'); ?> </a>
					<input type="text" id="usuario" name="usuario" value="<?php echo($_SESSION["user"]);?>" class="cajaCodUsr" disabled="disabled" />
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formCambioPassword','passActual'); ?> <input type="password" id="passActual" name="passActual" class="cajaClave"/>
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formCambioPassword','passNuevo1'); ?> <input type="password" id="passNuevo1" name="passNuevo1" class="cajaClave"/>
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formCambioPassword','passNuevo2'); ?> <input type="password" id="passNuevo2" name="passNuevo2" class="cajaClave"/>
				</p>
				</td>	
			</tr>			
			
			
			<tr>
				<td>
				<p class="textoFormTablas">
					<center>										
					<input type="button" id="btnGuardar" name="btnGuardar" value="<?php printValueXML('formCambioPassword','btnGuardar') ?>" onclick="cambiarPassword();" class="boton btnTablas2" onmouseover="className='botonHover btnTablas2'" onmouseout="className='boton btnTablas2'" />
					&nbsp;&nbsp;&nbsp;
					<input type="button" id="btnLimpiar" name="btnLimpiar" value="<?php printValueXML('formCambioPassword','btnLimpiar') ?>" onclick="limpiarPassword();" class="boton btnTablas3" onmouseover="className='botonHover btnTablas3'" onmouseout="className='boton btnTablas3'" />
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
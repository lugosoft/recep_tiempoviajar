
<div id='tablaUsuarios' style='display:none; background:#fff;'>
	<form name="formTablaUsuarios" id="formTablaUsuarios">
	<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
	<tr>
	<td width="20%">&nbsp;
		
	</td>
	
	<td width="60%">
		<table border="1" width="100%" height="100%" cellpadding="0" cellspacing="0">
		<tr>
		<td>
		
		<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
			<tr bgcolor="#1373A6">
				<td align="center">
				<p class="textoTituloTablas"> 
					<?php printValueXML('formTablaUsuarios','etiqUsuarios'); ?>
				</p>
				</td>	
			</tr>
					
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formTablaUsuarios','codUsr'); ?> <input type="text" id="codUsr" name="codUsr" maxlength="15" class="cajaCodUsr" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaUsuarios.clave.id)" />&nbsp;&nbsp;
					<?php printValueXML('formTablaUsuarios','clave'); ?> <input type="password" id="clave" name="clave" class="cajaClave" maxlength="15" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaUsuarios.codRol.id)" />&nbsp;&nbsp;
					<?php printValueXML('formTablaUsuarios','codRol'); ?>
					<select name="codRol" id="codRol" class="selSelRol" onChange="activarSelCliente(this.id);">
						<?php printOpcionesCodRol(); ?>
					</select>&nbsp;&nbsp;
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php printValueXML('formTablaUsuarios','nombre'); ?> <input type="text" id="nombre" name="nombre" class="cajaNombreUsu" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaUsuarios.apellidos.id)" />&nbsp;&nbsp;
					<?php printValueXML('formTablaUsuarios','apellidos'); ?> <input type="text" id="apellidos" name="apellidos" class="cajaApellidosUsu" onKeyUp="pasarFocoOnEnter(event,this.id, document.formTablaUsuarios.apellidos.id)" />
				</p>
				</td>	
			</tr>
			
			<tr>
				<td>
				<p class="textoFormTablas"> 
					<?php /*printValueXML('formTablaDatosReporte','selCliente');*/ ?>
					<select name="selCliente" id="selCliente" style="display:none;">
						<option value='<NULL>' selected='selected'>----</option>
						<?php printOpcionesCodAge(); ?>
					</select>
					&nbsp;&nbsp;&nbsp;&nbsp;
				</p>
				</td>	
			</tr>
			
			<?php include "library/botonesTablas1.php"; ?>								
					<input type="button" class="boxConsultarUsuario boton btnTablas2" id="btnConsultarUsuario" name="btnConsultarUsuario" value="<?php printValueXML('formTablas','btnConsultar') ?>" onclick="opcionBox = 'conUsuariosIni';" />&nbsp;&nbsp;&nbsp;										
			<?php include "library/botonesTablas2.php"; ?>						
		</table>	
		
		</td>	
		</tr>		
		</table>					
	</td>
	
	<td width="20%">&nbsp;
		
	</td>
	</tr>
	</table>
	</form>
</div>


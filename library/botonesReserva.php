<tr>
	<td height="38px">
		<center>
		<input type="button" id="btnIngresarReserva" name="btnIngresarReserva" value="<?php printValueXML('formReservas','btnIngresar') ?>" onClick="opcionBox = ''; iniIngresarReserva();" class="boton btnReserva" onmouseover="className='botonHover btnReserva'" onmouseout="className='boton btnReserva'" />&nbsp;&nbsp;&nbsp;
		<input type="button" id="btnGuardarReserva" name="btnGuardarReserva" value="<?php printValueXML('formReservas','btnGuardar') ?>" onclick="registrarReserva(reservas, document.formReservas.codAge.value, document.formReservas.cantRes.value);" disabled="disabled" class="boton btnReserva" onmouseover="className='botonHover btnReserva'" onmouseout="className='boton btnReserva'" />&nbsp;&nbsp;&nbsp;
		<input type="button" class="boxConsultarRes boton btnReserva" id="btnConsultarReserva" name="btnConsultarReserva" value="<?php printValueXML('formReservas','btnConsultar') ?>" onclick="opcionBox = 'conReservaIni';" />&nbsp;&nbsp;&nbsp;
		
		<input type="button" id="btnActualizarReserva" name="btnActualizarReserva" value="<?php printValueXML('formReservas','btnActualizar') ?>" onclick="actualizarReserva(reservaModificar, document.formReservas.codAge.value, document.formReservas.cantRes.value);" disabled="disabled" class="boton btnReserva" onmouseover="className='botonHover btnReserva'" onmouseout="className='boton btnReserva'" />&nbsp;&nbsp;&nbsp;
		
		<?php
		$verifPermiso = false;
		$verifPermiso = verificarPermiso($_SESSION["user"], 'eliRes');
		if ($verifPermiso == true){
			echo"<input type=\"button\" id=\"btnEliminarReserva\" name=\"btnEliminarReserva\" value=\""; 
			printValueXML('formReservas','btnEliminar'); 
			echo"\" onclick=\"desactivarResRes(reservaModificar, '1');\" disabled=\"disabled\" class=\"boton btnReserva\" onmouseover=\"className='botonHover btnReserva'\" onmouseout=\"className='boton btnReserva'\" />&nbsp;&nbsp;&nbsp;";
		}
		?>
		
		<input type="button" id="btnCancelarReserva" name="btnCancelarReserva" value="<?php printValueXML('formReservas','btnCancelar') ?>" onClick="iniCancelarReserva();" class="boton btnReserva2" onmouseover="className='botonHover btnReserva2'" onmouseout="className='boton btnReserva2'" />
		</center>
	</td>
</tr>
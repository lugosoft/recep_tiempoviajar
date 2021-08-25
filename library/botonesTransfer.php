<tr>
	<td height="38px">
		<center>
		<input type="button" id="btnIngresarTransfer" name="btnIngresarTransfer" value="<?php printValueXML('formTablaTransfer','btnIngresarTransfer') ?>" onClick="ingresarTransfer();" class="boton btnTransfer" onmouseover="className='botonHover btnTransfer'" onmouseout="className='boton btnTransfer'" />&nbsp;&nbsp;&nbsp;
		<input type="button" id="btnGuardarTransfer" name="btnGuardarTransfer" value="<?php printValueXML('formTablaTransfer','btnGuardarTransfer') ?>" onclick="registrarTransfer();" class="boton btnTransfer" onmouseover="className='botonHover btnTransfer'" onmouseout="className='boton btnTransfer'" />&nbsp;&nbsp;&nbsp;
		
		<input type="button" class="boxConsultarTransfer boton btnTransfer" id="btnConsultarTransfer" name="btnConsultaTransfer" value="<?php printValueXML('formTablaTransfer','btnConsultarTransfer') ?>" onclick="opcionBox = 'conTransferIni';" />&nbsp;&nbsp;&nbsp;
		
		<input type="button" id="btnActualizarTransfer" name="btnActualizarTransfer" value="<?php printValueXML('formTablaTransfer','btnActualizarTransfer') ?>" onclick="actualizarTransfer();" disabled="disabled" class="boton btnTransfer" onmouseover="className='botonHover btnTransfer'" onmouseout="className='boton btnTransfer'" />&nbsp;&nbsp;&nbsp;
		<input type="button" id="btnRetirarTransfer" name="btnRetirarTransfer" value="<?php printValueXML('formTablaTransfer','btnRetirarTransfer') ?>" onclick="retirarTransfer();" disabled="disabled" class="boton btnTransfer" onmouseover="className='botonHover btnTransfer'" onmouseout="className='boton btnTransfer'" />&nbsp;&nbsp;&nbsp;
		<input type="button" id="btnCancelarTransfer" name="btnCancelarTransfer" value="<?php printValueXML('formTablaTransfer','btnCancelarTransfer') ?>" onClick="cancelarTransfer();" class="boton btnTransfer2" onmouseover="className='botonHover btnTransfer2'" onmouseout="className='boton btnTransfer2'" />
		</center>
	</td>
</tr>		
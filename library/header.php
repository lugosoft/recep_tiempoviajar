<!--<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<link rel=stylesheet type="text/css" href="../library/styles2.css">
</head>
<body>-->
	
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td height="3">&nbsp;
				
			</td>
		</tr>
		<tr>
			<form id="formHeader" name="formHeader"> 
        <td width="50%" valign="center" align ="left">
          <a id="labelUser" name="labelUser" class="labelUserHeader"><?php printValueXML('formHeader','labelUser'); ?></a>
          <a id="labelUserName" name="labelUserName" class="labelUserNameHeader"><?php @printVar($_SESSION["username"]); ?></a>
          <input type="hidden" id="telUserName" name="telUserName" value="<?php @printVar($_SESSION["usertel"]); ?>">
          
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <a id="labelOfi" name="labelOfi" class="labelUserHeader"><?php printValueXML('formHeader','labelOfi'); ?></a>
          <a id="labelOfiName" name="labelOfiName" class="labelUserNameHeader"><?php @printVar(strtoupper($_SESSION["oficinaname"])); ?></a>
        </td>
        
        <td width="30%" valign="center" align ="left">
          <a id="labelFecha" name="labelFecha" class="labelFechaHeader"><?php @printVar(getFechaCompleta()); ?></a>				
        </td>
			</form>
		  <td width="20%" valign="center" align ="right">
				<input type="button" id="btnLogOut" name="btnLogOut" value="<?php printValueXML('formHeader','btnLogOut') ?>"  class="boton btnLogOut" onClick="window.location = ('?id=99');" onmouseover="className='botonHover btnLogOut'" onmouseout="className='boton btnLogOut'" />
				&nbsp;&nbsp;
			  <img style="border:none; margin-bottom:4px;" src="images/pass.jpg" alt="Cambiar contrasena" title="Cambiar Contrasena" class="imgLanguage" onClick="window.location = ('?id=6');" />
			</td>
		</tr>
	</table>
	
<!--</body>
</html>-->
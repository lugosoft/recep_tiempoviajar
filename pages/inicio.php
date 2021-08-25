<!--<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<link rel=stylesheet type="text/css" href="../library/styles2.css">
</head>
<body>-->

<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td width="100%" height="100%" style="padding: 20px" valign="top">
			<div class="container"> 
				<div class="top"> 
					<?php printValueXML('formIniciar','inicioSesion'); ?>
				</div> 
				<div class="content">
					<form id="formIniciar" name="formIniciar" method="post" action="?id=10"> 
						<p class="textoPanelInicio"> 
							<?php printValueXML('formIniciar','user'); ?> <input type="text" id="user" name="user" class="cajaUser"/> 
						</p> 
						<p class="textoPanelInicio"> 
							<?php printValueXML('formIniciar','pass'); ?> <input type="password" id="pass" name="pass" class="cajaPass" /> 
						</p> 
						<p class="textoPanelInicio"> 
							<?php printValueXML('formIniciar','selOficina'); ?> 
							<select name="oficina" id="oficina" class="selSelOficina">
								<?php printOpcionesCodOfi(); ?>
							</select>
						</p>
						<center>
						  <input type="submit" value="<?php printValueXML('formIniciar','btnEntrar'); ?>" class="boton btnIniciarSesion" onmouseover="className='botonHover btnIniciarSesion'" onmouseout="className='boton btnIniciarSesion'" />
						</center>	 	  
					</form> 
				</div> 
			</div> 
        </td>
    </tr>
</table>

<!--</body>
</html>-->
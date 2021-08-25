<?php 
function getPage2($pID = 0){
    return $pID;
}

$page = @getPage2($_GET['id']);

//$page = @getPage($_GET['id']);
?>
<div id="dhtmlgoodies_menu">
<ul> 

	<li>
		<div onclick="window.location = ('?id=0');"><a><?php printValueXML('menu','inicio'); ?></a></div>
	</li>
	
	<li>
		<div onclick="window.location = ('?id=1');"><a><?php printValueXML('menu','reservas'); ?></a></div>
	</li>
	<!--
	<li>
		<div onclick="window.location = ('?id=2');"><a><?php /*printValueXML('menu','transfer');*/ ?></a></div>
	</li>-->
	
	<li>
		<div><a>Tours</a></div>		
		<ul> <!--Ahora un submenu nivel 1 para Blogger con un par de opciones --> 
			<li><div onclick="window.location = ('?id=31');"><a><?php printValueXML('formRegistrarTour','etiqRegTour'); ?></a></div></li> 
			<li><div onclick="window.location = ('?id=35');"><a>Cancelar Programaci&oacute;n Tour</a></div></li> 
			<li><div onclick="window.location = ('?id=32');"><a><?php printValueXML('formRegistrarVentaTour','etiqRegTour'); ?></a></div></li> 
			<li><div onclick="window.location = ('?id=33');"><a>Confirmar Reserva Tour</a></div></li> 
			<li><div onclick="window.location = ('?id=34');"><a>Cancelar Asistencia Tour</a></div></li>
		</ul> 
	</li>
	
	<!-- Creamos la primer pestana del menu: Blogger -->
	<!-- Metemos la primera opcion -->
	<li>
		<div><a><?php printValueXML('menu','reportes'); ?></a></div>		
		<ul> <!--Ahora un submenu nivel 1 para Blogger con un par de opciones --> 
			<li><a>Reservas </a>  		
				<ul><!-- Ponemos un submenu nivel 2 para Blogger Beta -->
					<li><div onclick="window.location = ('?id=411');"><a>Consecutivos de Reservas</a></div></li> 
					<li><div onclick="window.location = ('?id=414');"><a>Pasajeros X Reserva</a></div></li>					
					
          <li><div onclick="window.location = ('?id=412');"><a>Llegadas</a></div></li> 
					<li><div onclick="window.location = ('?id=413');"><a>Salidas Confirmadas</a></div></li> 
					<!--
          <li><div onclick="window.location = ('?id=416');"><a>Salida X Reserva</a></div></li> 
          -->
          <!--<li><div onclick="window.location = ('?id=415');"><a>Pasajeros X Voucher Reserva</a></div></li>-->
				</ul> 
			</li>
			<!--
			<li><a>Transfer </a>  		
				<ul>
					<li><div onclick="window.location = ('?id=421');"><a>Transfer-IN</a></div></li> 
					<li><div onclick="window.location = ('?id=422');"><a>Transfer-IN Mensual</a></div></li> 
					<li><div onclick="window.location = ('?id=423');"><a>Transfer-OUT</a></div></li>
					<li><div onclick="window.location = ('?id=425');"><a>Transfer-OUT Mensual</a></div></li>
					<li><div onclick="window.location = ('?id=424');"><a>Otros Transfer</a></div></li> 
				</ul> 
			</li>-->
			<li><a>Tours </a>  		
				<ul><!-- Ponemos un submenu nivel 2 para Blogger Beta --> 
					<li><div onclick="window.location = ('?id=455');"><a>Consecutivo de Vouchers</a></div></li> 
          			<li><div onclick="window.location = ('?id=451');"><a>Tours Confirmados</a></div></li> 
					<li><div onclick="window.location = ('?id=454');"><a>Tours Confirmados X Reserva</a></div></li>
					<li><div onclick="window.location = ('?id=453');"><a>Tours sin Confirmar</a></div></li>
          <li><div onclick="window.location = ('?id=458');"><a>Tours Venta Directa</a></div></li>
					<li><div onclick="window.location = ('?id=452');"><a>Programaci&oacute;n de Tours</a></div></li>
				</ul> 
			</li>
			<li><a>Estadisticas </a>  		
				<ul><!-- Ponemos un submenu nivel 2 para Blogger Beta --> 
					<!--<li><div onclick="window.location = ('?id=457');"><a>Consolidado Tours Vendidos</a></div></li>-->
					<li><div onclick="window.location = ('?id=459');"><a>Lista de Agencias</a></div></li>
					<li><div onclick="window.location = ('?id=460');"><a>Lista de Hoteles</a></div></li>
					<li><div onclick="window.location = ('?id=456');"><a>Base Datos de Contactos</a></div></li>
					<li><div onclick="window.location = ('?id=445');"><a>Pasajeros Por Agencia</a></div></li> 
          <li><div onclick="window.location = ('?id=442');"><a>Pasajeros Por Servicio</a></div></li> 
          <li><div onclick="window.location = ('?id=443');"><a>Total Pax Reservas</a></div></li>
          <!--<li><div onclick="window.location = ('?id=441');"><a>Por Nacionalidad</a></div></li> -->
					<!--<li><div onclick="window.location = ('?id=444');"><a>Por Hotel</a></div></li>-->
					
				</ul> 
			</li>
			<li><div onclick="window.location = ('?id=43');"><a>Log</a></div></li>			
		</ul> 
	</li>

	<li>
		<div><a><?php printValueXML('menu','tablas'); ?></a></div>		
		<ul> <!--Ahora un submenu nivel 1 para Blogger con un par de opciones --> 
			<li><div onclick="window.location = ('?id=51');"><a><?php printValueXML('menu','tablaClientes') ?></a></div></li> 
			<li><div onclick="window.location = ('?id=55');"><a><?php printValueXML('menu','tablaProveedores') ?></a></div></li> 
			<li><div onclick="window.location = ('?id=59');"><a><?php printValueXML('menu','tablaPaquetes') ?></a></div></li> 
			<li><div onclick="window.location = ('?id=52');"><a><?php printValueXML('menu','tablaServicios') ?></a></div></li> 
			<li><div onclick="window.location = ('?id=53');"><a><?php printValueXML('menu','tablaVuelos') ?></a></div></li> 
			<li><div onclick="window.location = ('?id=54');"><a><?php printValueXML('menu','tablaHoteles') ?></a></div></li> 
			<li><div onclick="window.location = ('?id=56');"><a><?php printValueXML('menu','tablaUsuarios') ?></a></div></li>
			<!-- Se desactiva las nacionalidades. No es dato importante para la agencia -->
      <!--<li><div onclick="window.location = ('?id=57');"><a>--><?php /*printValueXML('menu','tablaNacionalidades')*/ ?><!--</a></div></li>-->
		</ul> 
	</li> 
	
</ul> 
</div> 
	

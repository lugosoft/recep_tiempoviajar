<?php
	require_once ("../db/funciones_db.php");
	require_once("nusoap/nusoap.php");
	
	$docWsXML = @(new DOMDocument());
	@($docWsXML->load( "operaciones.xml" ));
	
	function getParamNameXML($raiz, $etiqueta){
		global $docWsXML;
		$raiz = $docWsXML->getElementsByTagName( $raiz );
		$valor = 'NULL';
		foreach( $raiz as $reg )
		{
			$etiquetaValor = $reg->getElementsByTagName( $etiqueta );
			$valor = $etiquetaValor->item(0)->nodeValue; 			
		}
		if($valor == '')
			$valor = 'NULL';
			
		return $valor;
	}
	
	function interfaz(	$operacion,
						$param1='<NULL>', $param2='<NULL>',
						$param3='<NULL>', $param4='<NULL>',
						$param5='<NULL>', $param6='<NULL>',
						$param7='<NULL>', $param8='<NULL>',
						$param9='<NULL>', $param10='<NULL>'
					  ){	
		$cod = 'OK';
		$msg = '';
		$banError = false;
		
		$res = array();				

			
		if($param1 != '<NULL>'){
			$np = getParamNameXML($operacion, 'param1');
			if($np != 'NULL')
				$res[0] = getParameter($np, $param1);
			else{
				$banError = true; $msg = $msg.',1'; }
		}

		if($param2 != '<NULL>'){
			$np = getParamNameXML($operacion, 'param2');
			if($np != 'NULL')
				$res[1] = getParameter($np, $param2);
			else{
				$banError = true; $msg = $msg.',2'; }
		}
		
		if($param3 != '<NULL>'){
			$np = getParamNameXML($operacion, 'param3');
			if($np != 'NULL')
				$res[2] = getParameter($np, $param3);
			else{
				$banError = true; $msg = $msg.',3'; }
		}
		
		if($param4 != '<NULL>'){
			$np = getParamNameXML($operacion, 'param4');
			if($np != 'NULL')
				$res[3] = getParameter($np, $param4);
			else{
				$banError = true; $msg = $msg.',4'; }
		}
		
		if($param5 != '<NULL>'){
			$np = getParamNameXML($operacion, 'param5');
			if($np != 'NULL')
				$res[4] = getParameter($np, $param5);
			else{
				$banError = true; $msg = $msg.',5'; }
		}
		
		if($param6 != '<NULL>'){
			$np = getParamNameXML($operacion, 'param6');
			if($np != 'NULL')
				$res[5] = getParameter($np, $param6);
			else{
				$banError = true; $msg = $msg.',6'; }
		}
		
		if($param7 != '<NULL>'){
			$np = getParamNameXML($operacion, 'param7');
			if($np != 'NULL')
				$res[6] = getParameter($np, $param7);
			else{
				$banError = true; $msg = $msg.',7'; }
		}
		
		if($param8 != '<NULL>'){
			$np = getParamNameXML($operacion, 'param8');
			if($np != 'NULL')
				$res[7] = getParameter($np, $param8);
			else{
				$banError = true; $msg = $msg.',8'; }
		}
		
		if($param9 != '<NULL>'){
			$np = getParamNameXML($operacion, 'param9');
			if($np != 'NULL')
				$res[8] = getParameter($np, $param9);
			else{
				$banError = true; $msg = $msg.',9'; }
		}
		
		if($param10 != '<NULL>'){
			$np = getParamNameXML($operacion, 'param10');
			if($np != 'NULL')
				$res[9] = getParameter($np, $param10);
			else{
				$banError = true; $msg = $msg.',10'; }
		}
		

		if($banError == false){
			$res = callStoreProcedure($operacion,$res);
			$cod = $res['cod'];
			$msg = $res['msg'];
		} else{
			$cod = '99';
			$msg = 'Los parametros ['.substr($msg,1).'] enviados no son aceptados para la operacion ['.$operacion.']';
		}
		
		return array(new soapval('cod','xsd:string',$cod), new soapval('msg','xsd:string',$msg));
	}
	
	 
	//Definiendo el namespace para el servicio (a Distinct URI)
	$ns="http://localhost/receptivos/webservice/namespace";
	 
	//Instanciando el servidor SOAP y definiendo la configuración para el archivo WSDL.
	$server = new soap_server();
	$server->configureWSDL('ReceptivosService',$ns);
	$server->wsdl->schemaTargetNamespace=$ns;
	 
	$server->register(	'interfaz',
						array(	'operacion' => 'xsd:string',						// Parametros de entrada
								'param1' => 'xsd:string', 'param2' => 'xsd:string', //
								'param3' => 'xsd:string', 'param4' => 'xsd:string', //
								'param5' => 'xsd:string', 'param6' => 'xsd:string', //
								'param7' => 'xsd:string', 'param8' => 'xsd:string', //
								'param9' => 'xsd:string', 'param10' => 'xsd:string' //
							 ), 
						array('cod' => 'xsd:string', 'msg' => 'xsd:string'), // Parametros de salida
						$ns);
	 
	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : ''; 
	 
	//Invocando el servicio
	$server->service($HTTP_RAW_POST_DATA);
 
?>
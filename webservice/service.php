<?php
	require_once ("../db/funciones_db.php");
	
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
	
	function interfaz($operacion,   $param1='<NULL>', $param2='<NULL>',
									$param3='<NULL>', $param4='<NULL>',
									$param5='<NULL>', $param6='<NULL>',
									$param7='<NULL>', $param8='<NULL>',
									$param9='<NULL>', $param10='<NULL>') { 
									
		$cod = 'OK';
		$msg = '';
		$banError = false;
		
		$res = array();				
			
		if( ($param1 != '<NULL>') and (!is_null($param1)) ){
			$np = getParamNameXML($operacion, 'param1');
			if($np != 'NULL')
				$res[0] = getParameter($np, $param1);
			else{
				$banError = true; $msg = $msg.',1'; }
		}

		if( ($param2 != '<NULL>') and (!is_null($param2)) ){
			$np = getParamNameXML($operacion, 'param2');
			if($np != 'NULL')
				$res[1] = getParameter($np, $param2);
			else{
				$banError = true; $msg = $msg.',2'; }
		}
		
		if( ($param3 != '<NULL>') and (!is_null($param3)) ){
			$np = getParamNameXML($operacion, 'param3');
			if($np != 'NULL')
				$res[2] = getParameter($np, $param3);
			else{
				$banError = true; $msg = $msg.',3'; }
		}
		
		if( ($param4 != '<NULL>') and (!is_null($param4)) ){
			$np = getParamNameXML($operacion, 'param4');
			if($np != 'NULL')
				$res[3] = getParameter($np, $param4);
			else{
				$banError = true; $msg = $msg.',4'; }
		}
		
		if( ($param5 != '<NULL>') and (!is_null($param5)) ){
			$np = getParamNameXML($operacion, 'param5');
			if($np != 'NULL')
				$res[4] = getParameter($np, $param5);
			else{
				$banError = true; $msg = $msg.',5'; }
		}
		
		if( ($param6 != '<NULL>') and (!is_null($param6)) ){
			$np = getParamNameXML($operacion, 'param6');
			if($np != 'NULL')
				$res[5] = getParameter($np, $param6);
			else{
				$banError = true; $msg = $msg.',6'; }
		}
		
		if( ($param7 != '<NULL>') and (!is_null($param7)) ){
			$np = getParamNameXML($operacion, 'param7');
			if($np != 'NULL')
				$res[6] = getParameter($np, $param7);
			else{
				$banError = true; $msg = $msg.',7'; }
		}
		
		if( ($param8 != '<NULL>') and (!is_null($param8)) ){
			$np = getParamNameXML($operacion, 'param8');
			if($np != 'NULL')
				$res[7] = getParameter($np, $param8);
			else{
				$banError = true; $msg = $msg.',8'; }
		}
		
		if( ($param9 != '<NULL>') and (!is_null($param9)) ){
			$np = getParamNameXML($operacion, 'param9');
			if($np != 'NULL')
				$res[8] = getParameter($np, $param9);
			else{
				$banError = true; $msg = $msg.',9'; }
		}
		
		if( ($param10 != '<NULL>') and (!is_null($param10)) ){
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
	    
		return $cod . " - " . $msg;
	} 

	//$server = new SoapServer(null, array('uri' => "http://localhost/receptivos/webservice/namespace"));
	//$server = new SoapServer(null, array('uri' => "urn:namespace"));
	$server = new SoapServer("http://localhost/receptivos/webservice/wsdl/service.wsdl");
	$server->addFunction("interfaz"); 
	$server->handle(); 

?>
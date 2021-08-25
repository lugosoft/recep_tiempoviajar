<?php   
		ini_set("soap.wsdl_cache_enabled", "0");
		$servicio="http://localhost/receptivos/webservice/wsdl/service2.wsdl"; //url del servicio
		$tipoWS = 'PHP';		
		/* Si el tipoWS es <> de PHP*/ 
		$raiz = 'GetGeoIPResult';
		$elemento = 'CountryName';
		/**************************/
		
		$client = new SoapClient($servicio);
		
		if($tipoWS == 'PHP'){
			/************************ Para llamar WS hechos en PHP ************************/	
			$result = $client->interfaz(new SoapParam('confirmareserva', "operacion"),
										new SoapParam('1', "param1"),
										new SoapParam('888', "param2"),
										new SoapParam('2012-02-08', "param3"),
										new SoapParam('', "param4"));
			/******************************************************************************/		
		}else{
			/************************ Para llamar WS Java, .NET ***************************/
			$parametros=array(); //parametros de la llamada		
			$parametros['operacion'] = "confirmareserva";
			$parametros['param1'] = "1";
			$parametros['param2'] = "888";
			$parametros['param3'] = "2012-02-08";
			$parametros['param4'] = "cualquier";
			$result = $client->interfaz($parametros); //Se llama al método "interfaz" del ws 	
			/******************************************************************************/		
		}
		
		if(is_object($result)){
			echo var_dump($result);
			/*$result = obj2array($result);		
			$valNodo = $result[$raiz][$elemento];
			$n = count($valNodo);
			
			if($n == 1){
				echo $valNodo;
			}*/
		}else{
			echo $result;
		}
		
		function obj2array($obj) {
			$out = array();
			foreach ($obj as $key => $val) {
				switch(true) {
					case is_object($val):
						$out[$key] = obj2array($val);
						break;
					case is_array($val):
						$out[$key] = obj2array($val);
						break;
					default:
						$out[$key] = $val;
				}
			}
			return $out;
		}
/*  RESPONSE */
/*
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
   <soap:Body>
      <GetGeoIPResponse xmlns="http://www.webservicex.net/">
         <GetGeoIPResult>
            <ReturnCode>1</ReturnCode>
            <IP>74.125.45.94</IP>
            <ReturnCodeDetails>Success</ReturnCodeDetails>
            <CountryName>United States</CountryName>
            <CountryCode>USA</CountryCode>
         </GetGeoIPResult>
      </GetGeoIPResponse>
   </soap:Body>
</soap:Envelope>

<SOAP-ENV:Envelope SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="urn:namespace" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/">
   <SOAP-ENV:Body>
      <ns1:interfazResponse>
         <return xsi:type="xsd:string">OK -</return>
      </ns1:interfazResponse>
   </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
*/
		
		
?> 
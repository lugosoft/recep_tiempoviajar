<?php   
		ini_set("soap.wsdl_cache_enabled", "0");
		$servicio="http://www.webservicex.net/geoipservice.asmx?wsdl"; //url del servicio
		$parametros=array(); //parametros de la llamada		
		$parametros['IPAddress'] = "190.0.38.162";
		
		$client = new SoapClient($servicio);
		
		$result = $client->GetGeoIP($parametros);//llamamos al métdo que nos interesa con 		
		
		/* Para llamar WS hechos en PHP*/
		//$result = $client->GetGeoIP(new SoapParam($parametros['IPAddress'], "IPAddress"));
		
		
		if(is_object($result)){
			//$resultString = var_dump($result);
			$result = obj2array($result);		
			$valNodo = $result['GetGeoIPResult']['CountryName'];
			$n = count($valNodo);
			
			if($n == 1){
				echo $valNodo;
			}
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
*/
		
		
?> 
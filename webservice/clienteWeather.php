<?php   
		$servicio="http://wsf.cdyne.com/WeatherWS/Weather.asmx?wsdl"; //url del servicio
		$parametros=array(); //parametros de la llamada
		//$parametros['param1'] = "valor";
		
		//$client = new SoapClient($servicio);
		//$result = $client->GetWeatherInformation($parametros);//llamamos al m?tdo que nos interesa con 		
		
		$client = new SoapClient($servicio);
		$result = $client->GetWeatherInformation();
		
		$result = obj2array($result);
		
		$resultArray = $result ['GetWeatherInformationResult']['WeatherDescription'];
		$n=count($resultArray);
		 
		//procesamos el resultado como con cualquier otro array
		for($i=0; $i<$n; $i++){
			$nodo=$resultArray[$i];
			$id = $nodo['WeatherID'];
			$desc = $nodo['Description'];			
			echo "Id ".$id." => $desc<br>";			
			//aqu? ir?a el resto de tu c?digo donde procesas los datos recibidos
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
      <GetWeatherInformationResponse xmlns="http://ws.cdyne.com/WeatherWS/">
         <GetWeatherInformationResult>
            <WeatherDescription>
               <WeatherID>1</WeatherID>
               <Description>Thunder Storms</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/thunderstorms.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>2</WeatherID>
               <Description>Partly Cloudy</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/partlycloudy.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>3</WeatherID>
               <Description>Mostly Cloudy</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/mostlycloudy.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>4</WeatherID>
               <Description>Sunny</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/sunny.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>5</WeatherID>
               <Description>Rain</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/rain.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>6</WeatherID>
               <Description>Showers</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/showers.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>7</WeatherID>
               <Description>Haze</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/haze.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>9</WeatherID>
               <Description>Partly Sunny</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/mostlycloudy.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>10</WeatherID>
               <Description>Mostly Sunny</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/partlycloudy.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>11</WeatherID>
               <Description>Clear</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/sunny.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>12</WeatherID>
               <Description>Fair</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/partlycloudy.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>14</WeatherID>
               <Description>Cloudy</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/mostlycloudy.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>15</WeatherID>
               <Description>N/A</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/na.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>17</WeatherID>
               <Description>Drizzle</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/drizzle.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>18</WeatherID>
               <Description>Fog</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/fog.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>20</WeatherID>
               <Description>Flurries</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/blowingsnow.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>21</WeatherID>
               <Description>Snow and Fog</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/blowingsnow.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>26</WeatherID>
               <Description>Blowing Snow and Fog</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/blowingsnow.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>27</WeatherID>
               <Description>Snow</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/snow.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>28</WeatherID>
               <Description>Rain and Fog</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/rain.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>29</WeatherID>
               <Description>Blowing Snow</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/blowingsnow.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>32</WeatherID>
               <Description>Light Rain</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/rain.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>33</WeatherID>
               <Description>Heavy Rain</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/rain.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>34</WeatherID>
               <Description>Missing Data</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/na.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>35</WeatherID>
               <Description>Snow, Blowing Snow, and Fog</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/blowingsnow.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>36</WeatherID>
               <Description>Unknown Precipitation</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/na.gif</PictureURL>
            </WeatherDescription>
            <WeatherDescription>
               <WeatherID>37</WeatherID>
               <Description>AM CLOUDS</Description>
               <PictureURL>http://ws.cdyne.com/WeatherWS/Images/partlycloudy.gif</PictureURL>
            </WeatherDescription>
         </GetWeatherInformationResult>
      </GetWeatherInformationResponse>
   </soap:Body>
</soap:Envelope>
*/
		
		
?> 
<?php
// Copyright (c) 2018, Altiria TIC SL
// All rights reserved.
// El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
// Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
// más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)
// https://www.altiria.com/api-envio-sms/

function AltiriaSMS($sDestination, $sMessage, $sSenderId, $debug){
	if($debug)        
	echo 'Enter AltiriaSMS <br/>';

	//URL base de los recursos REST
	$baseUrl = 'http://www.altiria.net/apirest/ws';
	 
	//Se inicia el objeto CUrl 
	$ch = curl_init($baseUrl.'/sendSms');

	//XX, YY y ZZ se corresponden con los valores de identificación del
	//usuario en el sistema.
        //domainId solo es necesario si el login no es un email
	$credentials = array(
	    //'domainId' => 'XX', 
	    'login'    => 'YY',
	    'passwd'   => 'ZZ'
	);     

        $destinations = explode(',', $sDestination);

        $jsonMessage = array(
	    'msg' => substr($sMessage,0,160),
	    'senderId' => $sSenderId 
	);

	$jsonData = array(
	    'credentials' => $credentials, 
	    'destination' => $destinations,
	    'message'     => $jsonMessage
	);
	 
	//Se construye el mensaje JSON
	$jsonDataEncoded = json_encode($jsonData);
	 
	//Indicamos que nuestra petición sera Post
	curl_setopt($ch, CURLOPT_POST, 1);

	//Se fija el tiempo máximo de espera para conectar con el servidor (5 segundos)
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	 
	//Se fija el tiempo máximo de espera de la respuesta del servidor (60 segundos)
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	 
	//Para que la peticion no imprima el resultado como un 'echo' comun
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	 
	//Se añade el JSON al cuerpo de la petición codificado en UTF-8
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
	 
	//Se fija el tipo de contenido de la peticion POST
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=UTF-8'));

	//Se envía la petición y se consigue la respuesta
	$response = curl_exec($ch);

	$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	if($debug) {   
		//Error en la respuesta del servidor  	
		if($statusCode != 200){ 
			echo 'ERROR GENERAL: '.$statusCode;
			echo $response;
		}else{
			//Se procesa la respuesta capturada 
			echo 'Código de estado HTTP: '.$statusCode.'<br/>';
			$json_parsed = json_decode($response);
			$status = $json_parsed->status;
			echo 'Código de estado Altiria: '.$status.'<br/>';
			if ($status != '000')
				echo 'Error: '.$response.'<br/>';
			else{
				echo 'Cuerpo de la respuesta: <br/>';
				echo 'destails[0][destination]: '.$json_parsed->details[0]->destination.'<br/>';
				echo 'destails[0][status]: '.$json_parsed->details[0]->status.'<br/>';
				echo 'destails[1][destination]: '.$json_parsed->details[1]->destination.'<br/>';
				echo 'destails[1][status]: '.$json_parsed->details[1]->status.'<br/>';
			}
		}
	}

	//Si ha ocurrido algún error se lanza una excepción
	if(curl_errno($ch))
	    throw new Exception(curl_error($ch));

	return $response;
}

try{
    echo "The function AltiriaSMS returns: ".AltiriaSMS('346xxxxxxxx,346yyyyyyyy','Mensaje de prueba', '', true);    
    //No es posible utilizar el remitente en América pero sí en España y Europa
    //Utilizar esta llamada solo si se cuenta con un remitente autorizado por Altiria
    //echo "The function AltiriaSMS returns: ".AltiriaSMS('346xxxxxxxx,346yyyyyyyy','Mensaje de prueba', 'remitente', true);    
}catch(Exception $e){
   echo 'Error: '.$e->getMessage();
}

?>

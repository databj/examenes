<?php
// Copyright (c) 2020, Altiria TIC SL
// All rights reserved.
// El uso de este c�digo de ejemplo es solamente para mostrar el uso de la pasarela de env�o de SMS de Altiria
// Para un uso personalizado del c�digo, es necesario consultar la API de especificaciones t�cnicas, donde tambi�n podr�s encontrar
// m�s ejemplos de programaci�n en otros lenguajes de programaci�n y otros protocolos (http, REST, web services)

function AltiriaCertPdf($destination,$path, $debug){
	if($debug)        
	echo 'Enter AltiriaCertPdf <br/>';

	//URL base de los recursos REST
	$baseUrl = 'http://www.altiria.net/apirest/ws';
	 
	//Se inicia el objeto CUrl 
	$ch = curl_init($baseUrl.'/certPdfFile');

	//XX, YY y ZZ se corresponden con los valores de identificaci�n del
	//usuario en el sistema.
	// domainId solo es necesario si el login no es un email
	$credentials = array(
	    //'domainId' => 'XX', 
	    'login'    => 'YY',
	    'passwd'   => 'ZZ'
	);     

        $document = array(
	    'destination' => $destination, 
	    'type'    => 'simple',
	    'webSig'   => true
	); 

	$jsonData = array(
	    'credentials' => $credentials, 
	    'document' => $document,
	);
	 
	//Se construye el mensaje JSON
	$jsonDataEncoded = json_encode($jsonData);
	 
	//Indicamos que nuestra petici�n sera Post
	curl_setopt($ch, CURLOPT_POST, 1);

	//Se fija el tiempo m�ximo de espera para conectar con el servidor (5 segundos)
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	 
	//Se fija el tiempo m�ximo de espera de la respuesta del servidor (60 segundos)
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	 
	//Para que la peticion no imprima el resultado como un 'echo' comun
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	 
	//Se a�ade el JSON al cuerpo de la petici�n codificado en UTF-8
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
	 
	//Se fija el tipo de contenido de la peticion POST
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=UTF-8'));

	//Se env�a la petici�n y se consigue la respuesta
	$response = curl_exec($ch);

	$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	if($debug) {   
		//Error en la respuesta del servidor  	
		if($statusCode != 200){ 
			echo 'ERROR GENERAL: '.$statusCode;
			echo $response;
		}else{
			//Se procesa la respuesta capturada 
			echo 'C�digo de estado HTTP: '.$statusCode.'<br/>';
			$json_parsed = json_decode($response);
			$status = $json_parsed->status;
			echo 'C�digo de estado Altiria: '.$status.'<br/>';
			if ($status != '000')
				echo 'Error: '.$response.'<br/>';
			else{
				echo "Respuesta certPdfFile: ".$response."\n";

				//Si ha ocurrido alg�n error se lanza una excepci�n
				if(curl_errno($ch))
				    throw new Exception(curl_error($ch));

				curl_close($ch);

				$url = $json_parsed->url;
					
				//Upload file request			
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/pdf'));
				$filesize = filesize($path);
				$fp = fopen($path, 'rb');
				$binary = fread($fp, $filesize);
				fclose($fp);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $binary); 

				// Get response from the server.
				$httpResponse = curl_exec($ch);

				if(curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200){
				   if (!strstr($httpResponse,"000"))
			             echo "\nError upload cert pdf: ".$httpResponse;
				   else
			             echo "\nResponse upload file: ".$httpResponse;
				}else
				    echo "Error upload cert pdf: ".curl_error($ch).'('.curl_errno($ch).')'.$httpResponse;

				//Si ha ocurrido alg�n error se lanza una excepci�n
				if(curl_errno($ch))
				    throw new Exception(curl_error($ch));

				curl_close($ch);
			}
		}
	}
}

try{
   AltiriaCertPdf('346xxxxxxxx','file.pdf', true);    
}catch(Exception $e){
   echo 'Error: '.$e->getMessage();
}

?>

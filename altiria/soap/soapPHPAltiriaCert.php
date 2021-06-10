<?php
// Copyright (c) 2020, Altiria TIC SL
// All rights reserved.
// El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
// Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
// más ejemplos de programación en otros lenguajes y otros protocolos (http, REST, web services)

require_once('nusoap/nusoap.php');

//Se fija la URL de los servicios web en SOAP 1.1
$client = new nusoap_client('http://www.altiria.net/api/ws/soap?wsdl', true);
//conection timeout = 5 segundos
$client->timeout = 5;
//timeout de espera de respuesta = 60 segundos
$client->response_timeout = 60;
//Codificacion UTF-8
$client->soap_defencoding = 'UTF-8';
$client->decode_utf8 = true;

$err = $client->getError();
if($err){
 echo 'Constructor error'.$err;
}

//Se preparan los datos del servicio web
$operation = 'certPdfFile';
//XX, YY y ZZ se corresponden con los valores de identificacion del usuario en el sistema
//domainId solo es necesario si el login no es un email
//$credentials = array('domainId'=>'XX','login'=>'YY','passwd'=>'ZZ');
$credentials = array('login'=>'YY','passwd'=>'ZZ');
$document = array('destination'=>'346xxxxxxxx','type'=>'simple','webSig'=>true);
$params = array(array('credentials'=>$credentials,'document'=>$document));

//llamada al web service
$result = $client->call($operation, $params);

print_r($result);
echo "<br/>";

if($client->fault){
 echo ('Fault: ');
 print_r($result);
}else{
 $err = $client->getError();
 if($err){
  if (strpos($err,"timed out"))
   //error response timeout
   echo ('ERROR TimeOut');
  else
   //error en la conexion o de connetion timeout
   echo ('Error: '.$err);
 }else{
  //Evaluamos la respuesta de Altiria
  if($result['status']!='000'){
   echo 'ERROR. Codigo de Altiria: '.$result['status'];
  }else{
  //upload file request
  $url = $result['url'];
  $path = 'file.pdf';

  // Set the curl parameters.
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
  curl_close($ch);
  }
 }
}

?>


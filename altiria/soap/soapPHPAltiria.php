<?php
// Copyright (c) 2018, Altiria TIC SL
// All rights reserved.
// El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
// Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
// más ejemplos de programación en otros lenguajes y otros protocolos (http, REST, web services)
// https://www.altiria.com/api-envio-sms/

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
//XX, YY y ZZ se corresponden con los valores de identificacion del usuario en el sistema
#domainId solo es necesario si el login no es un email
$operation = 'sendSms';
$credentials = array('login'=>'YY','passwd'=>'ZZ');
#$credentials = array('domainId'=>'XX','login'=>'YY','passwd'=>'ZZ');
//No es posible utilizar el remitente en América pero sí en España y Europa
$message = array('msg'=>'Mensaje de prueba');
//Utilizar esta lista de parámetros solo si se cuenta con un remitente autorizado por Altiria
//$message = array('msg'=>'Mensaje de prueba', 'senderId'=>'remitente');
$destination = array ('346xxxxxxxx','34yyyyyyyy');
$params = array(array('credentials'=>$credentials,'destination'=>$destination,'message'=>$message));
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
   foreach ($result as $clave => $val){
    if($clave=='details') {
     //Array ([status]=>000 [details]=>Array ([destination]=>34xxxxxxxx [status]=>000))
     if(sizeof($destination)==1) {						
      if ($val['status']=='000')
        echo $val['destination']."  OK <br>";
      else
        echo $val['destination']."  ERROR. Codigo de error de Altiria: ".$val['status']."<br>";
     }
     //Array ( [status] => 000 
     //        [details] => Array ( 
     //          [0] => Array ( [destination] => 346xxxxxxxx [status] => 000 ) 
     //          [1] => Array ( [destination] => 346yyyyyyyy [status] => 000 ) ) 
     //      ) 
     else {
      foreach ($val as $clave2 => $val2){
        if ($val2['status']=='000')
         echo $val2['destination']."  OK <br>";
        else
         echo $val2['destination']."  ERROR. Codigo de error de Altiria: ".$val2['status']."<br>";
      }
     }
    }				
   }
  }
 }
}

?>


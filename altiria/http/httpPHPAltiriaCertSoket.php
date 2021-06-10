<?php
// Copyright (c) 2020, Altiria TIC SL
// All rights reserved.
// El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
// Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
// más ejemplos de programación en otros lenguajes y otros protocolos (http, REST, web services)

// destination: destinatario.
// type: simple/premium
// debug: Si es true muestra por pantalla la respuesta completa del servidor
// XX, YY y ZZ se corresponden con los valores de identificacion del
// usuario en el sistema.
function AltiriaCertPdfFile($destination, $type, $debug){

 $sData ='cmd=certpdffile&';
 // domainId solo es necesario si el login no es un email
 //$sData .='domainId=XX&';
 $sData .='login=YY&';
 $sData .='passwd=ZZ&';
 $sData .='destination='.$destination.'&';
 $sData .='type='.$type.'&';
 $sData .='websig='.'true'.'&';

 //Tiempo máximo de espera para conectar con el servidor = 5 seg
 $timeOut = 5; 
 $fp = fsockopen('www.altiria.net', 80, $errno, $errstr, $timeOut);
 if (!$fp) {
  //Error de conexion o tiempo maximo de conexion rebasado
  $output = "ERROR de conexion: $errno - $errstr<br />\n";
  $output .= "Compruebe que ha configurado correctamente la direccion/url ";
  $output .= "suministrada por altiria<br>";
  return $output;
 } else {
  $buf = "POST /api/http HTTP/1.0\r\n";
  $buf .= "Host: www.altiria.net\r\n";
  $buf .= "Content-type: application/x-www-form-urlencoded; charset=UTF-8\r\n";
  $buf .= "Content-length: ".strlen($sData)."\r\n";
  $buf .= "\r\n";
  $buf .= $sData;
  fputs($fp, $buf);
  $buf = "";

  //Tiempo máximo de espera de respuesta del servidor = 60 seg
  $responseTimeOut = 60;
  stream_set_timeout($fp,$responseTimeOut);
  stream_set_blocking ($fp, true);
  if (!feof($fp)){
   if (($buf=fgets($fp,128))===false){
    // TimeOut?
    $info = stream_get_meta_data($fp);
    if ($info['timed_out']){
     $output = 'ERROR Tiempo de respuesta agotado';
     return $output;
    } else {
     $output = 'ERROR de respuesta';
     return $output;
    }
   } else{
    while(!feof($fp)){
     $buf.=fgets($fp,128);
    }
   }
  } else {
   $output = 'ERROR de respuesta';
   return $output;
  }

  fclose($fp);
  
  //Si la llamada se hace con debug, se muestra la respuesta completa del servidor
  if ($debug){
   return $buf;
  }
  
  //Se comprueba que se ha conectado realmente con el servidor
  //y que se obtenga un codigo HTTP OK 200 
  if (strpos($buf,"HTTP/1.1 200 OK") === false){
   $output = "ERROR. Codigo error HTTP: ".substr($buf,9,3)."<br />\n";
   $output .= "Compruebe que ha configurado correctamente la direccion/url ";
   $output .= "suministrada por Altiria<br>";
   return $output;
  }
  //Se comprueba la respuesta de Altiria
  echo "buffer: ".$buf;

  $json_parsed = json_decode($buf);
  $status = $json_parsed->status;
  echo 'Código de estado Altiria: '.$status.'<br/>';
  if ($status != '000'){
    $output = $buf."<br />\n";
    $output .= " Ha ocurrido algun error. Compruebe la especificacion<br>";
    return $output;
  }else 
    return $output; 
 }
}

function AltiriaCertPdfUpload($url, $path, $debug){

  //Read cert file
  $filesize = filesize($path);
  $fp = fopen($path, 'rb');
  $sData = fread($fp, $filesize);
  fclose($fp);

  //Tiempo máximo de espera para conectar con el servidor = 5 seg
  $timeOut = 5; 
  $fp = fsockopen('www.altiria.net', 80, $errno, $errstr, $timeOut);
  if (!$fp) {
    //Error de conexion o tiempo maximo de conexion rebasado
    $output = "ERROR de conexion: $errno - $errstr<br />\n";
    $output .= "Compruebe que ha configurado correctamente la direccion/url ";
    $output .= "suministrada por altiria<br>";
    return $output;
  } else {
    $url = substr($url,strrpos($url,"80")+2);
    $buf = "POST ".$url." HTTP/1.0\r\n";
    $buf .= "Host: www.altiria.net\r\n";
    $buf .= "Content-type: application/pdf;\r\n";
    $buf .= "Content-length: ".strlen($sData)."\r\n";
    $buf .= "\r\n";
    $buf .= $sData;
    fputs($fp, $buf);
    $buf = "";

  //Tiempo máximo de espera de respuesta del servidor = 60 seg
  $responseTimeOut = 60;
  stream_set_timeout($fp,$responseTimeOut);
  stream_set_blocking ($fp, true);
  if (!feof($fp)){
   if (($buf=fgets($fp,128))===false){
    // TimeOut?
    $info = stream_get_meta_data($fp);
    if ($info['timed_out']){
     $output = 'ERROR Tiempo de respuesta agotado';
     return $output;
    } else {
     $output = 'ERROR de respuesta';
     return $output;
    }
   } else{
    while(!feof($fp)){
     $buf.=fgets($fp,128);
    }
   }
  } else {
   $output = 'ERROR de respuesta';
   return $output;
  }

  fclose($fp);
  
  //Si la llamada se hace con debug, se muestra la respuesta completa del servidor
  if ($debug){
   return $buf;
  }
  
  //Se comprueba que se ha conectado realmente con el servidor
  //y que se obtenga un codigo HTTP OK 200 
  if (strpos($buf,"HTTP/1.1 200 OK") === false){
   $output = "ERROR. Codigo error HTTP: ".substr($buf,9,3)."<br />\n";
   $output .= "Compruebe que ha configurado correctamente la direccion/url ";
   $output .= "suministrada por Altiria<br>";
   return $output;
  }
  //Se comprueba la respuesta de Altiria
  $json_parsed = json_decode($buf);
  $status = $json_parsed->status;
  echo 'Código de estado Altiria: '.$status.'<br/>';
  if ($status != '000'){
    $output = $buf."<br />\n";
    $output .= " Ha ocurrido algun error. Compruebe la especificacion<br>";
    return $output;
  }else 
    return $output;
 }
}

$resp= AltiriaCertPdfFile('346xxxxxxxx', 'simple', true);
echo "=>Response certpdffile:\n".$resp."\n\n";

//Get json object
$json = substr($resp,strrpos($resp,"{"));

//Parse json object
$decodedJson = json_decode($json, true);

if($decodedJson['status']=='000') {
  $resp= AltiriaCertPdfUpload($decodedJson['url'],'file.pdf',true);
  echo "=>Response certPDf upload:\n".$resp."\n";
}
?>

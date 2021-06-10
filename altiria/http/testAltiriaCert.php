<?php
// Copyright (c) 2020, Altiria TIC SL
// All rights reserved.
// El uso de este c�digo de ejemplo es solamente para mostrar el uso de la pasarela de env�o de SMS de Altiria
// Para un uso personalizado del c�digo, es necesario consultar la API de especificaciones t�cnicas, donde tambi�n podr�s encontrar
// m�s ejemplos de programaci�n en otros lenguajes y otros protocolos (http, REST, web services)

include('httpPHPAltiriaCert.php');

// XX, YY y ZZ se corresponden con los valores de identificacion del usuario en el sistema.
$altiriaCert = new AltiriaCert();
$altiriaCert->setUrl("http://www.altiria.net/api/http");
// domainId solo es necesario si el login no es un email
//$altiriaCert->setDomainId('XX');
$altiriaCert->setLogin('YY');
$altiriaCert->setPassword('ZZ');
$altiriaCert->setDebug(true);

$response = $altiriaCert->certPdf('346xxxxxxxx', 'simple');

if (!$response)
  echo "El certificado ha terminado en error";
else {
  echo "Response certpdffile: ".$response."\n";
  $decodedJson = json_decode($response, true);
  $responseUpload =  $altiriaCert->uploadCertPdf($decodedJson['url'],'file.pdf');

  if (!$responseUpload)
    echo 'Error al subir el certificado';
  else
    echo 'Response upload certPdf: '.$responseUpload;
}

?>


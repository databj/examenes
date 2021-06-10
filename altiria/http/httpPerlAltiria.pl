#!/usr/bin/perl

# Copyright (c) 2018, Altiria TIC SL
# All rights reserved.
# El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
# Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
# más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)
# https://www.altiria.com/api-envio-sms/

use strict;
use warnings;
use LWP::UserAgent;
use utf8;
use Encode qw(decode encode);

my $ua = new LWP::UserAgent();
# Timeout en segundos
$ua->timeout(60);
# Se fija la URL sobre la que enviar la petición POST
my $req = new HTTP::Request POST => "http://www.altiria.net/api/http";
$req->header('content-type'=>'application/x-www-form-urlencoded;charset=UTF-8');

# XX, YY y ZZ se corresponden con los valores de identificación del usuario en el sistema
my $data =("cmd=sendsms&login=YY&passwd=ZZ&dest=346xxxxxxx&dest=346yyyyyyyy".
	   "&msg=Mensaje de prueba".
           #domainId solo es necesario si el login no es un email
           #"&domainId=XX".
	   #No es posible utilizar el remitente en América pero sí en España y Europa
	   #Descomentar la línea solo si se cuenta con un remitente autorizado por Altiria
	   #"&senderId=remitente".
           "");

$data = encode('UTF8',$data);

$req->content($data);

my $resp = $ua->request($req);
if ($resp->is_success)		{	
# $resp->code = 200
  my $message = $resp->decoded_content;
  print "\nRespuesta: \n$message\n";
}else {							
  print "HTTP POST error code: ", $resp->code, "\n";
  print $resp->decoded_content;
}

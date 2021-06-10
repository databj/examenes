#!/usr/bin/perl

# Copyright (c) 2020, Altiria TIC SL
# All rights reserved.
# El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
# Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
# más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)
# https://www.altiria.com/api-envio-sms/

use strict;
use warnings;
use HTTP::Request;
use LWP::UserAgent;
use JSON;
use JSON::Parse 'parse_json';
use Try::Tiny;

binmode(STDOUT, ":utf8");

try {
	#Se fija la URL base de los recursos REST
	my $base_url = 'http://www.altiria.net/apirest/ws';

	my $json = JSON->new->utf8;
	
	#Se construye el mensaje JSON
	#XX, YY y ZZ se corresponden con los valores de identificación del usuario en el sistema.
	#domainId solo es necesario si el login no es un email
	my $data_to_json = {credentials=>{
					  #domainId=>'XX',
					  login=>'YY',passwd=>'ZZ'},
			    document=>{destination=>'346xxxxxxxx',type=>'simple',webSig=>'true'}};

	#Se inicia el objeto HTTP 
	my $req = HTTP::Request->new( 'POST', $base_url.'/certPdfFile' );
	#Se añade el JSON al cuerpo de la petición codificado en UTF-8
	$req->header( 'Content-Type' => 'application/json;charset=UTF-8' );
	#Se añade el JSON a la petición
	$req->content( $json->encode($data_to_json) );

	my $ua = LWP::UserAgent->new;
	#Se fija el tiempo máximo de espera de la respuesta del servidor (60 segundos)
	$ua->timeout(60);
	#Se consigue la respuesta
	my $resp = $ua->request($req);

	my $message = $resp->decoded_content;

	my $parsedJson = parse_json ($message);

	my $status = $parsedJson->{status};
	
	if ($status != '000') {
	     print "\nERROR COMANDO CERTPDFFILE: Código Altiria: \n$status\n";
	}else {
		print "Comando procesado correctamente: \n".$message."\n";
	     	print "\nSubiendo fichero\n";

		# Se fija la URL sobre la que enviar la petición POST

		$req = HTTP::Request->new( 'POST',$parsedJson->{url});
		$req->header('content-type'=>'application/pdf');

		# Se lee el fichero y se almacena en un buffer
		my $fname = 'file.pdf';
		my $BLOCK_SIZE=1024;
		open(F,"<$fname") or die("Fichero no encontrado: $fname, $!");
		binmode(F);
		my $buf;
		my $ct=0;
		while(read(F,$buf,$BLOCK_SIZE,$ct*$BLOCK_SIZE)){
			$ct++;
		}
		close(F);

		$req->content($buf);
		$resp = $ua->request($req);
		if ($resp->is_success) {	
		     $message = $resp->decoded_content;
		     print "\nRespuesta al subir certificado: \n$message\n";
		     $parsedJson = parse_json ($message);
		     $status = $parsedJson->{status};
		     if ($status != '000') {
			print "\nERROR AL SUBIR FICHERO: Código Altiria: \n$status\n";
		     }else {
			print "\nProceso terminado con exito.\n";
		     }
		}else {
		     print "HTTP POST error al subir el fichero. Code: ", $resp->code, "\n";
		     print $resp->decoded_content;
		}
	}
}catch { #Se capturan posibles errores en el lado cliente
	print "Error inesperado: $_\n";
};

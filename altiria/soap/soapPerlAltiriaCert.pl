#!/usr/bin/perl

# Copyright (c) 2020, Altiria TIC SL
# All rights reserved.
# El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
# Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
# más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)

use SOAP::Lite;
use strict;
use warnings;
use JSON;
use JSON::Parse 'parse_json';
use Try::Tiny;
use LWP::UserAgent;

binmode(STDOUT, ":utf8");

try {
	#Se fija la URL para SOAP 1.1 
	my $url = 'http://www.altiria.net/api/ws/soap';

	#Se crea el objeto de la petición y se establece el tiempo máximo de respuesta
	my $soap = SOAP::Lite->proxy($url, timeout => 60);

	#Se especifica la operación
	$soap->on_action(sub { sprintf '"certPdfFile"'});
	#Se asocia el namespace del objeto
	$soap->ns("http://www.altiria.net/api/soap","tns");
	#Error en la respuesta del servidor
	$soap->on_fault( sub{ my $soap = shift;
			      my $err = $soap->transport->status;
			      if(index($err, 'timeout') != -1){
				    print "Timeout error \n";
			      }else{
				    print "Error: ".$err;
			      }
			});
	#Se preparan los datos del servicio web. 
	#XX, YY y ZZ se corresponden con los valores de identificación del usuario en el sistema
	my @params = (  SOAP::Data->name('tns:credentials' => \SOAP::Data->value(
			   #domainId solo es necesario si el login no es un email
			   #SOAP::Data->new(name => 'tns:domainId', value => 'XX')->type('xsd:string'),
			   SOAP::Data->new(name => 'tns:login', value => 'YY')->type('xsd:string'),
			   SOAP::Data->new(name => 'tns:passwd', value => 'ZZ')->type('xsd:string')))->type('tns:Credentials'),
			SOAP::Data->name('tns:document' => \SOAP::Data->value(
			   SOAP::Data->new(name => 'tns:destination', value => '346xxxxxxxx')->type('xsd:string'),
			   SOAP::Data->new(name => 'tns:type', value => 'simple')->type('xsd:string'),
			   SOAP::Data->new(name => 'tns:webSig', value => 1)->type('xsd:boolean')))->type('tns:Document'));
	#Se envía la petición
	my $response = $soap->call('CertPdfFileRequest', @params);

	#Se recupera de la respuesta el nodo del objecto CertPdfFileResponse
	my $nodes = $response->valueof('//Envelope/Body/CertPdfFileResponse');

	my $altiria_status = $nodes->{status};
	print "Codigo de estado de Altiria: " .$altiria_status. "\n";
	if($altiria_status eq '000'){
		print "\nSubiendo fichero\n";

		my $ua = new LWP::UserAgent();
		# Timeout en segundos
		$ua->timeout(60);

		# Se fija la URL sobre la que enviar la petición POST
		my $req = new HTTP::Request POST => $nodes->{'url'};
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
		my $resp = $ua->request($req);
		if ($resp->is_success) {	
		     my $message = $resp->decoded_content;
		     print "\nRespuesta al subir certificado: \n$message\n";
	  	     my $parsedJson = parse_json ($message);
		     my $status = $parsedJson->{status};
	  	     if ($status != '000') {
			print "\nERROR AL SUBIR FICHERO: Codigo Altiria: \n$status\n";
		     }else {
			print "\nProceso terminado con exito.\n";
		     }
		}else {
		     print "HTTP POST error al subir el fichero. Code: ", $resp->code, "\n";
	  	     print $resp->decoded_content;
		}
	}else{
		print "Error de Altiria: ".$response."\n";
	}
}catch { #Se capturan posibles errores en el lado cliente
	print "Error inesperado: $_\n";
};

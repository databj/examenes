#!/usr/bin/perl

# Copyright (c) 2020, Altiria TIC SL
# All rights reserved.
# El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
# Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
# más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)

use strict;
use warnings;
use LWP::UserAgent;
use utf8;
use Encode qw(decode encode);
use JSON;
use JSON::Parse 'parse_json';
use Try::Tiny;

binmode(STDOUT, ":utf8");

try {
	my $ua = new LWP::UserAgent();
	# Timeout en segundos
	$ua->timeout(60);
	# Se fija la URL sobre la que enviar la petición POST
	my $req = new HTTP::Request POST => "http://www.altiria.net/api/http";
	$req->header('content-type'=>'application/x-www-form-urlencoded;charset=UTF-8');

	# XX, YY y ZZ se corresponden con los valores de identificación del usuario en el sistema
	# domainId solo es necesario si el login no es un email
	my $data =("cmd=certpdffile&login=XX&passwd=YY&destination=346xxxxxxxx&type=simple&websig=true".
		   #"&domainId=ZZ".
		   "");

	$data = encode('UTF8',$data);

	$req->content($data);

	my $resp = $ua->request($req);
	if ($resp->is_success) {	
		# $resp->code = 200
		my $message = $resp->decoded_content;
		print "\nRespuesta comando certPdfFile: \n$message\n";

		my $parsedJson = parse_json ($message);

		my $status = $parsedJson->{status};
		if ($status != '000') {
			print "\nERROR COMANDO CERTPDFFILE: Código Altiria: \n$status\n";
		}else {
			print "\nSubiendo fichero\n";

			# Se fija la URL sobre la que enviar la petición POST
			$req = new HTTP::Request POST => $parsedJson->{url};
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
	}else {							
	  print "HTTP POST error en la petición al comando. Code: ", $resp->code, "\n";
	  print $resp->decoded_content;
	}
}catch { #Se capturan posibles errores en el lado cliente
	print "Error inesperado: $_\n";
};

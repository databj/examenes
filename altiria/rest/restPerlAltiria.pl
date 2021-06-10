#!/usr/bin/perl

# Copyright (c) 2018, Altiria TIC SL
# All rights reserved.
# El uso de este c�digo de ejemplo es solamente para mostrar el uso de la pasarela de env�o de SMS de Altiria
# Para un uso personalizado del c�digo, es necesario consultar la API de especificaciones t�cnicas, donde tambi�n podr�s encontrar
# m�s ejemplos de programaci�n en otros lenguajes de programaci�n y otros protocolos (http, REST, web services)
# https://www.altiria.com/api-envio-sms/

require HTTP::Request;
require LWP::UserAgent;
use JSON;
use strict;
use warnings;

binmode(STDOUT, ":utf8");

sub altiriaSms{

	if ($_[3] eq 'true'){
		print 'Enter altiriaSms: destinations='.$_[0].', message='.$_[1].', senderId='.$_[2]."\n";
	}

	try {
		#Se fija la URL base de los recursos REST
		my $base_url = 'http://www.altiria.net/apirest/ws';
		
		my @array = split(',', $_[0]);

		my $json = JSON->new->utf8;
		
		#Se construye el mensaje JSON
		#XX, YY y ZZ se corresponden con los valores de identificaci�n del usuario en el sistema.
                #domainId solo es necesario si el login no es un email
		my $data_to_json = {credentials=>{login=>'YY',passwd=>'ZZ'},
                                    #credentials=>{domainId=>'XX',login=>'YY',passwd=>'ZZ'}, 
				    destination=> \@array,
				    message=>{msg=>$_[1],senderId=>$_[2]}
		};

		#Se inicia el objeto HTTP 
		my $request = HTTP::Request->new( 'POST', $base_url.'/sendSms' );
		#Se a�ade el JSON al cuerpo de la petici�n codificado en UTF-8
		$request->header( 'Content-Type' => 'application/json;charset=UTF-8' );
		#Se a�ade el JSON a la petici�n
		$request->content( $json->encode($data_to_json) );

		my $lwp = LWP::UserAgent->new;
		#Se fija el tiempo m�ximo de espera de la respuesta del servidor (60 segundos)
		$lwp->timeout(60);
		#Se consigue la respuesta
		my $response = $lwp->request( $request );

		my $message = $response->decoded_content;

		#El cliente HTTP en caso de timeout devuelve un estado 500 con su correspondiente mensaje
		if(index($message, 'timeout') != -1){
			die 'Timeout error'; #Se lanza una excepci�n
		}

		if ($_[3] eq 'true'){
			if ( $response->is_success ) {
				print "C�digo de estado HTTP: ".$response->code."\n";
				my $decoded = decode_json($message);
				my $altiria_status = $decoded->{'status'};
				print "C�digo de estado de Altiria: " .$altiria_status. "\n";
			
				if($altiria_status eq '000'){#Se procesa la respuesta capturada
					print "Cuerpo de la respuesta: \n";
					print "details[0]destination: ".$decoded->{'details'}[0]{'destination'}."\n";
					print "details[0]status: ".$decoded->{'details'}[0]{'status'}."\n";
					print "details[1]destination: ".$decoded->{'details'}[1]{'destination'}."\n";
					print "details[1]status: ".$decoded->{'details'}[1]{'status'}."\n";
				}else{#Error en la respuesta del servidor
					print "Error de Altiria: ".$message."\n";
				}
			} else {
				print "ERROR GENERAL: ".$response->code."\n";
				print $message."\n";
			}
		}
		return 	$message;	
	};
	catch {
		print "Error: ".$@->what."\n";
        };
}

print "The function altiriaSms returns: ".altiriaSms('346xxxxxxxx,346yyyyyyyy','Mensaje de prueba', '', 'true')."\n";
#No es posible utilizar el remitente en Am�rica pero s� en Espa�a y Europa
#Utilizar esta llamada solo si se cuenta con un remitente autorizado por Altiria
#print "The function altiriaSms returns: ".altiriaSms('346xxxxxxxx,346yyyyyyyy','Mensaje de prueba', 'remitente', 'true')."\n";

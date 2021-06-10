#!/usr/bin/perl

# Copyright (c) 2018, Altiria TIC SL
# All rights reserved.
# El uso de este c�digo de ejemplo es solamente para mostrar el uso de la pasarela de env�o de SMS de Altiria
# Para un uso personalizado del c�digo, es necesario consultar la API de especificaciones t�cnicas, donde tambi�n podr�s encontrar
# m�s ejemplos de programaci�n en otros lenguajes de programaci�n y otros protocolos (http, REST, web services)
# https://www.altiria.com/api-envio-sms/

use SOAP::Lite;
use strict;
use warnings;

binmode(STDOUT, ":utf8");

sub altiriaSms{

	#Si debug 
	if ($_[3] eq 'true'){
		print 'Enter altiriaSms: destinations='.$_[0].', message='.$_[1].', senderId='.$_[2]."\n";
	}

	try {
		#Se fija la URL para SOAP 1.2 
		my $url = 'http://www.altiria.net/api/ws/soap12';

		#Se crea el objeto de la petici�n y se establece el tiempo m�ximo de respuesta
		my $soap = SOAP::Lite->proxy($url, timeout => 60);

		#Se especifica la operaci�n
		$soap->on_action(sub { sprintf '"sendSms"' });

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
		#XX, YY y ZZ se corresponden con los valores de identificaci�n del usuario en el sistema
                #domainId solo es necesario si el login no es un email
		my @params = (  SOAP::Data->name('tns:credentials' => \SOAP::Data->value(
				   #SOAP::Data->new(name => 'tns:domainId', value => 'XX')->type('xsd:string'),
				   SOAP::Data->new(name => 'tns:login', value => 'YY')->type('xsd:string'),
				   SOAP::Data->new(name => 'tns:passwd', value => 'ZZ')->type('xsd:string')))->type('tns:Credentials'));
		
		#Se a�aden los destinatarios al cuerpo de la petici�n
		my @destinations = split(',', $_[0]);
		foreach my $destination (@destinations){
		    push (@params, SOAP::Data->name("tns:destination" => $destination)->type('xsd:string'));
		}		

		#Se a�ade el mensaje al cuerpo de la petici�n
		push (@params, SOAP::Data->name("tns:message" => \SOAP::Data->value(
				   SOAP::Data->new(name => 'tns:msg', value => $_[1])->type('xsd:string'),
				   SOAP::Data->new(name => 'tns:senderId', value => $_[2])->type('xsd:string')
				   ))->type('tns:TextMessage'));
		
		#Se env�a la petici�n
		my $response = $soap->call('TextMessageRequest', @params);

		#Se recupera de la respuesta el nodo del objecto TextMessageResponse
		my $nodes = $response->valueof('//Envelope/Body/TextMessageResponse');

		#Si debug 
		if ($_[3] eq 'true'){
			my $altiria_status = $nodes->{status};
			print "C�digo de estado de Altiria: " .$altiria_status. "\n";
			if($altiria_status eq '000'){
				print "Cuerpo de la respuesta: \n";
				print "details[0]destination: ".$nodes->{'details'}[0]{'destination'}."\n";
				print "details[0]status: ".$nodes->{'details'}[0]{'status'}."\n";
				print "details[1]destination: ".$nodes->{'details'}[1]{'destination'}."\n";
				print "details[1]status: ".$nodes->{'details'}[1]{'status'}."\n";
			}else{
				print "Error de Altiria: ".$response."\n";
			}
		}

		#Se serializa la respuesta
		my $serializer = SOAP::Serializer->new;
		my $xml = $serializer->serialize($response->dataof('//'));
		return $xml;

	};
	catch { #Se capturan posibles errores en el lado cliente
		print "Error: ".$@->what."\n";
        };
}

print "The function altiriaSms returns: ".altiriaSms('346xxxxxxxx,346yyyyyyyy','Mensaje de prueba', '', 'true')."\n";
#No es posible utilizar el remitente en Am�rica pero s� en Espa�a y Europa
#Utilizar esta llamada solo si se cuenta con un remitente autorizado por Altiria
#print "The function altiriaSms returns: ".altiriaSms('346xxxxxxxx,346yyyyyyyy','Mensaje de prueba', 'remitente', 'true')."\n";

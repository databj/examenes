# encoding: iso-8859-15

# Copyright (c) 2018, Altiria TIC SL
# All rights reserved.
# El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
# Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
# más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)
# https://www.altiria.com/api-envio-sms/

require 'net/http'
require 'json' 
require 'uri'
require 'rubygems'
require 'savon'

def altiriaSms(destinations, message, senderId, debug)
	if debug 
	puts "Enter altiriaSms: destinations=#{destinations}, message=#{message}, senderId=#{senderId}"
	end

	begin

	#Se suministra la URL del fichero WSDL para SOAP 1.2
	client = Savon.client(wsdl: 'http://www.altiria.net/api/ws/soap12?wsdl', 
			      open_timeout: 5, #Tiempo maximo de conexión. 
			      read_timeout: 60, #Tiempo maximo de respuesta. 
			      encoding: "UTF-8", #Se fija la codificación de la peticion POST
			      soap_version: 2) #Se fija la versión del cliente SOAP

	#Se envía la petición
	response = client.call(:send_sms, message: { #Se preparan los datos del servicio web. 
			 #XX, YY y ZZ se corresponden con los valores de identificación del usuario en el sistema	
                         #domainId solo es necesario si el login no es un email
                         credentials: {login: 'YY', passwd: 'ZZ'},
			 #credentials: {domainId: 'XX', login: 'YY', passwd: 'ZZ'},
			 destination: destinations.split(","),
                         message: {msg: message, senderId: senderId} 
		   }) 
	if debug 	
		#Se serializa la respuesta	
		filter = response.to_hash
		filter = JSON.parse filter.to_json
	
		#Error en la respuesta del servidor
		unless response.http.code == 200
			puts("ERROR GENERAL: #{response.http.code}")
			puts("#{response.body}")
		else	#Se procesa la respuesta
			puts("Código de estado HTTP: #{response.http.code}")
			puts("Código de estado Altiria: #{filter['text_message_response']['status']}")
			if "#{filter['text_message_response']['status']}" == "000"
				puts "text_message_response.details[0].destination = #{filter['text_message_response']['details'][0]['destination']}"
				puts "text_message_response.details[0].status = #{filter['text_message_response']['details'][0]['status']}"
				puts "text_message_response.details[1].destination = #{filter['text_message_response']['details'][1]['destination']}"
				puts "text_message_response.details[1].status = #{filter['text_message_response']['details'][1]['status']}"
			else
				puts("Error: #{response.body}")
			end
		end
	end

	return Nokogiri::XML(response.to_xml)

	rescue Net::OpenTimeout 
		puts "Tiempo de conexión agotado"
	rescue Net::ReadTimeout 
		puts "Tiempo de respuesta agotado"
	rescue Exception => e
		puts "Error interno: #{e.class}, #{e.message}"
	end

end

puts "The function altiriaSms returns:\n #{altiriaSms('346xxxxxxxx,346yyyyyyyy','Mensaje de prueba', '', true)}"
#No es posible utilizar el remitente en América pero sí en España y Europa
#Utilizar esta llamada solo si se cuenta con un remitente autorizado por Altiria
#puts "The function altiriaSms returns:\n #{altiriaSms('346xxxxxxxx,346yyyyyyyy','Mensaje de prueba', 'remitente', true)}"

# encoding: iso-8859-15

# Copyright (c) 2018, Altiria TIC SL
# All rights reserved.
# El uso de este c�digo de ejemplo es solamente para mostrar el uso de la pasarela de env�o de SMS de Altiria
# Para un uso personalizado del c�digo, es necesario consultar la API de especificaciones t�cnicas, donde tambi�n podr�s encontrar
# m�s ejemplos de programaci�n en otros lenguajes de programaci�n y otros protocolos (http, REST, web services)
# https://www.altiria.com/api-envio-sms/

require 'net/http'
require 'json' 
require 'uri'

def altiriaSms(destinations, message, senderId, debug)
	if debug 
	puts "Enter altiriaSms: destinations=#{destinations}, message=#{message}, senderId=#{senderId}"
	end

	begin
		#XX, YY y ZZ se corresponden con los valores de identificaci�n del
		#usuario en el sistema.
                #domainId solo es necesario si el login no es un email
		credentials = {:login => "YY", :passwd => "ZZ"}
		#credentials = {:domainId => "XX", :login => "YY", :passwd => "ZZ"}
		destination = destinations.split(",")
		messageData = {:msg => message, :senderId => senderId}
		
		#Se construye el mensaje JSON
		jsonData = {:credentials => credentials, :destination => destination, :message => messageData}

        #Se fija la URL base de los recursos REST
        baseUrl = 'http://www.altiria.net/apirest/ws'
		uri = URI.parse(baseUrl+"/sendSms")
		http = Net::HTTP.new(uri.host, uri.port)
		#Se fija el tiempo m�ximo de espera para conectar con el servidor (5 segundos)
		#Se fija el tiempo m�ximo de espera de la respuesta del servidor (60 segundos)
		http.open_timeout = 5
		http.read_timeout = 60

		#Se inicia el objeto HTTP y se env�a la petici�n
		#Se a�ade el JSON al cuerpo de la petici�n codificado en UTF-8
		request = Net::HTTP::Post.new(uri.request_uri,'Content-Type' => 'application/json;charset=UTF-8')
		request.body = jsonData.to_json
		
		#Se consigue la respuesta
		response = http.request(request)

		if debug 
			#Error en la respuesta del servidor
			unless response.code == "200"
				puts("ERROR GENERAL: #{response.code}")
				puts("#{response.body}")
			else	
				#Se procesa la respuesta capturada
				puts("C�digo de estado HTTP: #{response.code}")
				jsonResponse = JSON.parse(response.body)
				puts("C�digo de estado de Altiria: #{jsonResponse['status']}")
				unless jsonResponse['status'].include? "000"
					puts("Error de Altiria: #{response.body}")
				else
					puts("Cuerpo de la respuesta:")
					puts("details[0]destination: #{jsonResponse['details'][0]['destination']}")
					puts("details[0]status: #{jsonResponse['details'][0]['status']}")
					puts("details[1]destination: #{jsonResponse['details'][1]['destination']}")
					puts("details[1]status: #{jsonResponse['details'][1]['status']}")
				end
			end
		end

		return response

	rescue Net::OpenTimeout 
		puts "Tiempo de conexi�n agotado"
	rescue Net::ReadTimeout 
		puts "Tiempo de respuesta agotado"
	rescue Exception => e
		puts "Error interno: #{e}"
	end

end

puts "The function altiriaSms returns: #{altiriaSms('346xxxxxxxx,346yyyyyyyy','Mensaje de prueba', '', true).body}"
#No es posible utilizar el remitente en Am�rica pero s� en Espa�a y Europa
#Utilizar esta llamada solo si se cuenta con un remitente autorizado por Altiria
#puts "The function altiriaSms returns: #{altiriaSms('346xxxxxxxx,346yyyyyyyy','Mensaje de prueba', 'remitente', true).body}"

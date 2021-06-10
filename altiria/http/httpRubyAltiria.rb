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

def altiriaSms(destinations, message, senderId, debug)
	if debug 
	puts "Enter altiriaSms: destinations=#{destinations}, message=#{message}, senderId=#{senderId}"
	end

	begin

		#Se fija la URL sobre la que enviar la petición POST
		url = "http://www.altiria.net/api/http"
		uri = URI.parse(url)
		http = Net::HTTP.new(uri.host, uri.port)
		#Se fija el tiempo máximo de espera para conectar con el servidor (5 segundos)
		#Se fija el tiempo máximo de espera de la respuesta del servidor (60 segundos)
		http.open_timeout = 5
		http.read_timeout = 60

                #Se crea la lista de parámetros a enviar en la petición POST
                #XX, YY y ZZ se corresponden con los valores de identificación del usuario en el sistema.
                #No es posible utilizar el remitente en América pero sí en España y Europa
                # domainId solo es necesario si el login no es un email
                post_data = {'cmd' => 'sendsms', 'login' => 'YY', 'passwd' => 'ZZ',
                             #'cmd' => 'sendsms', 'domainId' => 'XX', 'login' => 'YY', 'passwd' => 'ZZ',
                             'dest' => destinations.split(","), 'msg' => message, 'senderId' => senderId}
                
		#Se envía la petición y se consigue la respuesta
		#La codificación es de tipo "application/x-www-form-urlencoded;charset=utf-8" 
		#fijado por el método "post_form"		
		response = Net::HTTP.post_form( uri, post_data)

		if debug 
			unless response.code == "200" #Error en la respuesta del servidor
				puts("ERROR GENERAL: #{response.code}")
				puts("#{response.body}")
			else	#Se procesa la respuesta
				puts("Código de estado HTTP: #{response.code}")
				if "#{response.body}".include? "ERROR errNum:"
					puts("Error de Altiria: #{response.body}")
				else
					puts("Cuerpo de la respuesta: \n#{response.body}")
				end
			end
		end

		return response

	rescue Net::OpenTimeout 
		puts "Tiempo de conexión agotado"
	rescue Net::ReadTimeout 
		puts "Tiempo de respuesta agotado"
	rescue Exception => e
		puts "Error interno: #{e.class}"
	end

end

puts "The function altiriaSms returns: #{altiriaSms('346xxxxxxxx,346yyyyyyyy','Mensaje de prueba', '', true).body}"
#No es posible utilizar el remitente en América pero sí en España y Europa
#Utilizar esta llamada solo si se cuenta con un remitente autorizado por Altiria
#puts "The function altiriaSms returns: #{altiriaSms('346xxxxxxxx,346yyyyyyyy','Mensaje de prueba', 'remitente', true).body}"

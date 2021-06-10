# encoding: utf8

# Copyright (c) 2020, Altiria TIC SL
# All rights reserved.
# El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
# Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
# más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)

require 'net/http'
require 'json' 
require 'uri'

def altiriaCert(destination, type)
	puts "Enter altiriaCert: destination=#{destination}, type=#{type}"

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
                post_data = {'cmd' => 'certpdffile',
			     #'domainId' => 'XX', 
			     'login' => 'YY', 'passwd' => 'ZZ',
                             'destination' => destination, 'type' => type, 'webSig' => 'true'}
		#Se envía la petición y se consigue la respuesta
		#La codificación es de tipo "application/x-www-form-urlencoded;charset=utf-8" 
		#fijado por el método "post_form"		
		response = Net::HTTP.post_form( uri, post_data)
		unless response.code == "200" #Error en la respuesta del servidor
			puts("ERROR GENERAL cmd: #{response.code}")
			puts("#{response.body}")
		else	#Se procesa la respuesta
			puts("Código de estado HTTP cmd: #{response.code}")
			puts("Cuerpo respuesta cmd: #{response.body}")
			parsedJson = JSON.parse(response.body)
			unless parsedJson['status'].include? "000"
				puts("Error de Altiria cmd: #{response.body}")
			else
				puts("Código de estado Alriria cmd: #{parsedJson['status']}")

				file = File.open("file.pdf", "rb")

				#Se fija la URL base de los recursos REST
				uri = URI.parse(parsedJson['url'])

				#Se inicia el objeto HTTP y se envía la petición
				#Se añade el JSON al cuerpo de la petición codificado en UTF-8
				request = Net::HTTP::Post.new(uri.request_uri,'Content-Type' => 'application/pdf')
				request.body = file.read
	
				#Se consigue la respuesta
				response = http.request(request)
				unless response.code == "200" #Error en la respuesta del servidor
					puts("ERROR GENERAL subiendo fichero: #{response.code}")
					puts("#{response.body}")
				else	#Se procesa la respuesta
					puts("Código de estado HTTP subiendo fichero: #{response.code}")
					puts("Cuerpo respuesta subiendo fichero: #{response.body}")
					parsedJson = JSON.parse(response.body)
					unless parsedJson['status'].include? "000"
						puts("Error de Altiria subiendo fichero: #{response.body}")
					else
						puts("Proceso terminado con éxito")
					end
				end
			end
		end
	rescue Net::OpenTimeout 
		puts "Tiempo de conexión agotado"
	rescue Net::ReadTimeout 
		puts "Tiempo de respuesta agotado"
	rescue Exception => e
		puts "Error interno: #{e}"
	end

end

altiriaCert('346xxxxxxxx','simple')

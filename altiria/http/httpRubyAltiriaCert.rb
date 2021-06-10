# encoding: utf8

# Copyright (c) 2020, Altiria TIC SL
# All rights reserved.
# El uso de este c�digo de ejemplo es solamente para mostrar el uso de la pasarela de env�o de SMS de Altiria
# Para un uso personalizado del c�digo, es necesario consultar la API de especificaciones t�cnicas, donde tambi�n podr�s encontrar
# m�s ejemplos de programaci�n en otros lenguajes de programaci�n y otros protocolos (http, REST, web services)

require 'net/http'
require 'json' 
require 'uri'

def altiriaCert(destination, type)
	puts "Enter altiriaCert: destination=#{destination}, type=#{type}"

	begin
		#Se fija la URL sobre la que enviar la petici�n POST
		url = "http://www.altiria.net/api/http"
		uri = URI.parse(url)
		http = Net::HTTP.new(uri.host, uri.port)
		#Se fija el tiempo m�ximo de espera para conectar con el servidor (5 segundos)
		#Se fija el tiempo m�ximo de espera de la respuesta del servidor (60 segundos)
		http.open_timeout = 5
		http.read_timeout = 60

                #Se crea la lista de par�metros a enviar en la petici�n POST
                #XX, YY y ZZ se corresponden con los valores de identificaci�n del usuario en el sistema.
                #No es posible utilizar el remitente en Am�rica pero s� en Espa�a y Europa
                # domainId solo es necesario si el login no es un email
                post_data = {'cmd' => 'certpdffile',
			     #'domainId' => 'XX', 
			     'login' => 'YY', 'passwd' => 'ZZ',
                             'destination' => destination, 'type' => type, 'webSig' => 'true'}
		#Se env�a la petici�n y se consigue la respuesta
		#La codificaci�n es de tipo "application/x-www-form-urlencoded;charset=utf-8" 
		#fijado por el m�todo "post_form"		
		response = Net::HTTP.post_form( uri, post_data)
		unless response.code == "200" #Error en la respuesta del servidor
			puts("ERROR GENERAL cmd: #{response.code}")
			puts("#{response.body}")
		else	#Se procesa la respuesta
			puts("C�digo de estado HTTP cmd: #{response.code}")
			puts("Cuerpo respuesta cmd: #{response.body}")
			parsedJson = JSON.parse(response.body)
			unless parsedJson['status'].include? "000"
				puts("Error de Altiria cmd: #{response.body}")
			else
				puts("C�digo de estado Alriria cmd: #{parsedJson['status']}")

				file = File.open("file.pdf", "rb")

				#Se fija la URL base de los recursos REST
				uri = URI.parse(parsedJson['url'])

				#Se inicia el objeto HTTP y se env�a la petici�n
				#Se a�ade el JSON al cuerpo de la petici�n codificado en UTF-8
				request = Net::HTTP::Post.new(uri.request_uri,'Content-Type' => 'application/pdf')
				request.body = file.read
	
				#Se consigue la respuesta
				response = http.request(request)
				unless response.code == "200" #Error en la respuesta del servidor
					puts("ERROR GENERAL subiendo fichero: #{response.code}")
					puts("#{response.body}")
				else	#Se procesa la respuesta
					puts("C�digo de estado HTTP subiendo fichero: #{response.code}")
					puts("Cuerpo respuesta subiendo fichero: #{response.body}")
					parsedJson = JSON.parse(response.body)
					unless parsedJson['status'].include? "000"
						puts("Error de Altiria subiendo fichero: #{response.body}")
					else
						puts("Proceso terminado con �xito")
					end
				end
			end
		end
	rescue Net::OpenTimeout 
		puts "Tiempo de conexi�n agotado"
	rescue Net::ReadTimeout 
		puts "Tiempo de respuesta agotado"
	rescue Exception => e
		puts "Error interno: #{e}"
	end

end

altiriaCert('346xxxxxxxx','simple')

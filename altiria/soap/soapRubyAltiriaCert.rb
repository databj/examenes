# encoding: utf8

# Copyright (c) 2020, Altiria TIC SL
# All rights reserved.
# El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
# Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
# más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)

require 'net/http'
require 'json' 
require 'uri'
require 'rubygems'
require 'savon'

def altiriaCert(destination, type)
	puts "Enter altiriaCert: destination=#{destination}, type=#{type}"

	begin

	#Se suministra la URL del fichero WSDL para SOAP 1.1
	client = Savon.client(wsdl: 'http://www.altiria.net/api/ws/soap?wsdl', 
			      open_timeout: 5, #Tiempo maximo de conexión. 
			      read_timeout: 60, #Tiempo maximo de respuesta. 
			      encoding: "UTF-8", #Se fija la codificación de la peticion POST
			      soap_version: 2) #Se fija la versión del cliente SOAP

	#Se envía la petición
	#XX, YY y ZZ se corresponden con los valores de identificación del usuario en el sistema
	# domainId solo es necesario si el login no es un email
	response = client.call(:cert_pdf_file, message: { #Se preparan los datos del servicio web. 
			 credentials: {
				#domainId: 'XX',
			        login: 'YY', passwd: 'ZZ'},
			 document: {destination: destination, type: type, webSig: true}
		   }) 
	#Se serializa la respuesta	
	filter = response.to_hash
	filter = JSON.parse filter.to_json

	#Error en la respuesta del servidor
	unless response.http.code == 200
		puts("ERROR GENERAL: #{response.http.code}")
		puts("#{response.body}")
	else	#Se procesa la respuesta
		puts("Código de estado HTTP: #{response.http.code}")
		puts("Código de estado Altiria cmd: #{filter['cert_pdf_file_response']['status']}")
		if "#{filter['cert_pdf_file_response']['status']}" == "000"
			file = File.open("file.pdf", "rb")

			#Se fija la URL base de los recursos REST
			uri = URI.parse(filter['cert_pdf_file_response']['url'])
			http = Net::HTTP.new(uri.host, uri.port)
			#Se fija el tiempo máximo de espera para conectar con el servidor (5 segundos)
			#Se fija el tiempo máximo de espera de la respuesta del servidor (60 segundos)
			http.open_timeout = 5
			http.read_timeout = 60

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
		else
			puts("Error: #{response.body}")
		end
	end
	rescue Net::OpenTimeout 
		puts "Tiempo de conexión agotado"
	rescue Net::ReadTimeout 
		puts "Tiempo de respuesta agotado"
	rescue Exception => e
		puts "Error interno: #{e.class}, #{e.message}"
	end
end

altiriaCert('346xxxxxxxx','simple')

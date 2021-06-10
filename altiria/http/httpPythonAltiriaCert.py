# -*- coding: utf-8 -*-

# Copyright (c) 2020, Altiria TIC SL
# All rights reserved.
# El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
# Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
# más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)

import requests
import json

def altiriaCert(destination, fType):
        print 'Enter altiriaCert: destination= '+destination+', fType= '+fType

	try:
		#Se crea la lista de parámetros a enviar en la petición POST
		#XX, YY y ZZ se corresponden con los valores de identificación del usuario en el sistema.
		#domainId solo es necesario si el login no es un email
		payload = [
		    ('cmd', 'certpdffile'),
		    #('domainId', 'XX'),
		    ('login', 'YY'),
		    ('passwd', 'ZZ'),
                    ('destination', destination),
		    ('type', fType),
		    ('webSig', 'true'),
		]

		#Se fija la codificacion de caracteres de la peticion POST
		contentType = {'Content-Type':'application/x-www-form-urlencoded;charset=utf-8'} 
	
		#Se fija la URL sobre la que enviar la petición POST
		url = 'http://www.altiria.net/api/http'

		#Se envía la petición y se recupera la respuesta
		r = requests.post(url,
		    data=payload,
		    headers=contentType,
		    #Se fija el tiempo máximo de espera para conectar con el servidor (5 segundos)
		    #Se fija el tiempo máximo de espera de la respuesta del servidor (60 segundos)
		    timeout=(5, 60)) #timeout(timeout_connect, timeout_read)

		if str(r.status_code) != '200': #Error en la respuesta del servidor
			print 'Error general comando certPdfFile: '+str(r.status_code)
		else: #Se procesa la respuesta 
			print 'Codigo de estado HTTP cmd: '+str(r.status_code)
			print 'Respuesta certPdfFile: '+str(r.text)
			parsed_json = json.loads(r.text)
			status = parsed_json['status']
			if status == '000': 
				print 'Codigo de estado Altiria cmd: '+status
				url = parsed_json['url']
				f = open("file.pdf", "rb")
				try:
					contentType = {'Content-Type':'application/pdf'}
					r = requests.post(url,
					    data=f,
					    headers=contentType,
					    #Se fija el tiempo máximo de espera para conectar con el servidor (5 segundos)
					    #Se fija el tiempo máximo de espera de la respuesta del servidor (60 segundos)
					    timeout=(5, 60)) #timeout(timeout_connect, timeout_read)
				finally:
					f.close()
				if str(r.status_code) != '200': #Error en la respuesta del servidor
					print 'Error general subiendo fichero: '+str(r.status_code)
				else: #Se procesa la respuesta 
					print 'Codigo de estado HTTP subiendo fichero: '+str(r.status_code)
					print 'Respuesta subiendo fichero: '+str(r.text)
					parsed_json = json.loads(r.text)
					status = parsed_json['status']
					if status == '000': 
						print 'Proceso terminado con exito'
					else:
						print "Error Altiria. Codigo de estado: "+status
			else:
				print "Error Altiria. Codigo de estado: "+status

	except  requests.ConnectTimeout:
		print "Tiempo de conexión agotado"
	
	except  requests.ReadTimeout:
		print "Tiempo de respuesta agotado"

	except Exception as ex:
		print "Error interno: "+str(ex)
		
altiriaCert('346xxxxxxxx','simple')

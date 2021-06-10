# -*- coding: utf-8 -*-

# Copyright (c) 2020, Altiria TIC SL
# All rights reserved.
# El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
# Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
# más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)

import requests
import json as JSON
 
def altiriaCert(destination, fType):
        print 'Enter altiriaCert: destination='+destination+', type: '+fType

	try:
                #Se fija la URL base de los recursos REST
                baseUrl = 'http://www.altiria.net/apirest/ws'
		
		#Se construye el mensaje JSON
		#XX, YY y ZZ se corresponden con los valores de identificación del usuario en el sistema.
		#domainId solo es necesario si el login no es un email
		#credentials = {'domainId': 'XX', 'login': 'YY', 'passwd': 'ZZ'}
		credentials = {'login': 'YY', 'passwd': 'ZZ'}

		document = {'destination': destination, 'type': fType, 'webSig': True}

		jsonData = {'credentials': credentials, 'document': document}	

		#Se fija el tipo de contenido de la peticion POST
		contentType = {'Content-Type':'application/json;charset=UTF-8'} 

		#Se añade el JSON al cuerpo de la petición 
		#Se fija el tiempo máximo de espera para conectar con el servidor (5 segundos)
		#Se fija el tiempo máximo de espera de la respuesta del servidor (60 segundos)
		#timeout(timeout_connect, timeout_read)
		#Se envía la petición y se recupera la respuesta
		r = requests.post(baseUrl+'/certPdfFile', data=JSON.dumps(jsonData), headers=contentType, timeout=(5, 60)) 

		#Error en la respuesta del servidor
		if str(r.status_code) != '200':
			print 'ERROR GENERAL: '+str(r.status_code)
			print r.text
		else:
			#Se procesa la respuesta capturada
			print 'Codigo de estado HTTP cmd: '+str(r.status_code)
			jsonParsed = JSON.loads(r.text)
			status = str(jsonParsed['status'])
			print 'Codigo de estado Altiria: '+status
			if status != '000':
				print 'Error: '+r.text
			else:
				print 'Respuesta cmd: '+str(r.text)
				f = open("file.pdf", "rb")
				try:
					contentType = {'Content-Type':'application/pdf'}
					r = requests.post(str(jsonParsed['url']),
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
					parsed_json = JSON.loads(r.text)
					status = parsed_json['status']
					if status == '000': 
						print 'Proceso terminado con exito'
					else:
						print "Error Altiria. Codigo de estado: "+status
	except  requests.ConnectTimeout:
		print "Tiempo de conexión agotado"
	
	except  requests.ReadTimeout:
		print "Tiempo de respuesta agotado"

	except Exception as ex:
		print "Error interno: "+str(ex)
		
altiriaCert('346xxxxxxxx','simple')

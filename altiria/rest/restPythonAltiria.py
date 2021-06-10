# -*- coding: utf-8 -*-

# Copyright (c) 2018, Altiria TIC SL
# All rights reserved.
# El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
# Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
# más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)
# https://www.altiria.com/api-envio-sms/

import requests
import json as JSON
 
def altiriaSms(destinations, message, senderId, debug):
	if debug:
	        print 'Enter altiriaSms: '+destinations+', message: '+message+', senderId: '+senderId

		try:
                        
                        #Se fija la URL base de los recursos REST
                        baseUrl = 'http://www.altiria.net/apirest/ws'
			
			#Se construye el mensaje JSON
			#XX, YY y ZZ se corresponden con los valores de identificación del usuario en el sistema.
                        #domainId solo es necesario si el login no es un email
			#credentials = {'domainId': 'XX', 'login': 'YY', 'passwd': 'ZZ'}
                        credentials = {'login': 'YY', 'passwd': 'ZZ'}
		  	destination = destinations.split(",")

			messageData = {'msg': message
                                       #No es posible utilizar el remitente en América pero sí en España y Europa
                                       #Descomentar la línea si se cuenta con un remitente autorizado por Altiria
                                       #,'senderId': senderId
                        }
			jsonData = {'credentials': credentials, 'destination': destination, 'message': messageData}	

			#Se fija el tipo de contenido de la peticion POST
			contentType = {'Content-Type':'application/json;charset=UTF-8'} 

			#Se añade el JSON al cuerpo de la petición 
			#Se fija el tiempo máximo de espera para conectar con el servidor (5 segundos)
			#Se fija el tiempo máximo de espera de la respuesta del servidor (60 segundos)
			#timeout(timeout_connect, timeout_read)
			#Se envía la petición y se recupera la respuesta
			r = requests.post(baseUrl+'/sendSms', data=JSON.dumps(jsonData), headers=contentType, timeout=(5, 60)) 

			if debug:
				#Error en la respuesta del servidor
				if str(r.status_code) != '200':
					print 'ERROR GENERAL: '+str(r.status_code)
					print r.text
				else:
					#Se procesa la respuesta capturada
					print 'Código de estado HTTP: '+str(r.status_code)
					jsonParsed = JSON.loads(r.text)
					status = str(jsonParsed['status'])
					print 'Código de estado Altiria: '+status
					if status != '000':
						print 'Error: '+r.text
					else:
						print 'Cuerpo de la respuesta:'
						print "details[0]['destination']: "+str(jsonParsed['details'][0]['destination'])
						print "details[0]['status']: "+str(jsonParsed['details'][0]['status'])
						print "details[1]['destination']: "+str(jsonParsed['details'][1]['destination'])
						print "details[1]['status']: "+str(jsonParsed['details'][1]['status'])

			return r.text

		except  requests.ConnectTimeout:
			print "Tiempo de conexión agotado"
		
		except  requests.ReadTimeout:
			print "Tiempo de respuesta agotado"

		except Exception as ex:
			print "Error interno: "+str(ex)
		
print 'The function altiriaSms returns: \n'+altiriaSms('346xxxxxxxx,346yyyyyyyy','Mensaje de prueba', 'remitente', True)

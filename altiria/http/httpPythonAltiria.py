# -*- coding: utf-8 -*-

# Copyright (c) 2018, Altiria TIC SL
# All rights reserved.
# El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
# Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
# más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)
# https://www.altiria.com/api-envio-sms/

import requests

def altiriaSms(destinations, message, senderId, debug):
	if debug:
	        print 'Enter altiriaSms: '+destinations+', message: '+message+', senderId: '+senderId

		try:
			#Se crea la lista de parámetros a enviar en la petición POST
			#XX, YY y ZZ se corresponden con los valores de identificación del usuario en el sistema.
			payload = [
			    ('cmd', 'sendsms'),
                            # domainId solo es necesario si el login no es un email
			    #('domainId', 'XX'),
			    ('login', 'YY'),
			    ('passwd', 'ZZ'),
                            #No es posible utilizar el remitente en América pero sí en España y Europa
                            ('senderId', senderId),
			    ('msg', message)
			]

			#add destinations
			for destination in destinations.split(","):
			    payload.append(('dest', destination))

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

			if debug:
				if str(r.status_code) != '200': #Error en la respuesta del servidor
					print 'ERROR GENERAL: '+str(r.status_code)
				else: #Se procesa la respuesta 
					print 'Código de estado HTTP: '+str(r.status_code)
					if (r.text).find("ERROR errNum:"):
                                                print 'Error de Altiria: '+r.text
					else:
						print 'Cuerpo de la respuesta: \n'+r.text	

			return r.text

		except  requests.ConnectTimeout:
			print "Tiempo de conexión agotado"
		
		except  requests.ReadTimeout:
			print "Tiempo de respuesta agotado"

		except Exception as ex:
			print "Error interno: "+str(ex)
		
print 'The function altiriaSms returns: \n'+altiriaSms('346xxxxxxxx,346yyyyyyyy','Mesaje de prueba', '', True)
#No es posible utilizar el remitente en América pero sí en España y Europa
#Utilizar esta llamada solo si se cuenta con un remitente autorizado por Altiria
#print 'The function altiriaSms returns: \n'+altiriaSms('346xxxxxxxx,346yyyyyyyy','Mesaje de prueba', 'remitente', True)

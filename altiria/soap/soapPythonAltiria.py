# -*- coding: utf-8 -*-

# Copyright (c) 2018, Altiria TIC SL
# All rights reserved.
# El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
# Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
# más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)
# https://www.altiria.com/api-envio-sms/

from suds.client import Client

def altiriaSms(destinations, message, senderId, debug):
	if debug:
	        print 'Enter altiriaSms: '+destinations+', message: '+message+', senderId: '+senderId

		try:

			#Se suministra la URL del fichero WSDL para SOAP 1.2
			client = Client('http://www.altiria.net/api/ws/soap12?wsdl')

			client.set_options(timeout=60,  #Tiempo maximo de respuesta.
                                           #Se fija el tipo de contenido de la peticion POST
					   headers={'Content-Type': 'application/soap+xml','charset': 'UTF-8'}, 
					   faults=False) #Imprescindible para poder recuperar el estado HTTP en la respuesta

			#Se preparan los datos del servicio web
			#XX, YY y ZZ se corresponden con los valores de identificación del usuario en el sistema	 
			credentialsData = client.factory.create('Credentials')
                        #domainId solo es necesario si el login no es un email
			#credentialsData.domainId = 'XX'
			credentialsData.login = 'YY'
			credentialsData.passwd = 'ZZ'

			messageData = client.factory.create('TextMessage')
			messageData.msg = message.decode('utf8')
			messageData.senderId = senderId

			response = client.service.sendSms(credentialsData, destinations.split(','), messageData)
			
			if debug:
				httpStatus = response[0]
				if httpStatus != 200: #Error en la respuesta del servidor
					print 'ERROR GENERAL: '+str(httpStatus)
					print str(response[1])
				else: #Se procesa la respuesta
					print 'Código de estado HTTP: '+str(httpStatus)
					print 'Codigo de estado Altiria: '+response[1].status
					if response[1].status != '000':
						print 'Error: '+str(response[1])
					else:
						print 'Cuerpo de la respuesta:'
						print 'destination[0].status= '+response[1].details[0].status
						print 'destination[0].destination= '+response[1].details[0].destination
						print 'destination[1].status= '+response[1].details[1].status
						print 'destination[1].destination= '+response[1].details[1].destination
			return str(response)

		except Exception as ex:
			if str(ex).index('timed out')!=-1:
				print 'Error TimeOut'
			else:
				print 'Error interno: '+str(ex)
		
print 'The function altiriaSms returns: \n'+altiriaSms('346xxxxxxxx,346yyyyyyyy','Mensaje de prueba', '', True)
#No es posible utilizar el remitente en América pero sí en España y Europa
#Utilizar esta llamada solo si se cuenta con un remitente autorizado por Altiria
#print 'The function altiriaSms returns: \n'+altiriaSms('346xxxxxxxx,346yyyyyyyy','Mensaje de prueba', 'remitente', True)

# -*- coding: utf-8 -*-

# Copyright (c) 2020, Altiria TIC SL
# All rights reserved.
# El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
# Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
# más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)

from suds.client import Client
import requests
import json

def altiriaCert(destination, fType):
	        print 'Enter altiriaCert: destination='+destination+', type: '+fType

		try:
			#Se suministra la URL del fichero WSDL para SOAP 1.2
			client = Client('http://www.altiria.net/api/ws/soap12?wsdl')

			client.set_options(timeout=60,  #Tiempo maximo de respuesta.
                                           #Se fija el tipo de contenido de la peticion POST
					   headers={'Content-Type': 'application/soap+xml','charset': 'UTF-8'}, 
					   faults=False) #Imprescindible para poder recuperar el estado HTTP en la respuesta

			#Se preparan los datos del servicio web
			#XX, YY y ZZ se corresponden con los valores de identificación del usuario en el sistema
			#domainId solo es necesario si el login no es un email	 
			credentialsData = client.factory.create('Credentials')
			#credentialsData.domainId = 'XX'
			credentialsData.login = 'YY'
			credentialsData.passwd = 'ZZ'

			documentData = client.factory.create('Document')
			documentData.destination = destination
			documentData.type = fType
			documentData.webSig = True

			response = client.service.certPdfFile(credentialsData, documentData)
			
			httpStatus = response[0]
			if httpStatus != 200: #Error en la respuesta del servidor
				print 'ERROR GENERAL: '+str(httpStatus)
				print str(response[1])
			else: #Se procesa la respuesta
				print 'Codigo de estado HTTP cmd: '+str(httpStatus)
				print 'Codigo de estado Altiria cmd: '+response[1].status
				if response[1].status != '000':
					print 'Error: '+str(response[1])
				else:
					print 'Respuesta certPdfFile: '+str(response[1])
					if response[1].status == '000': 
						f = open("file.pdf", "rb")
						try:
							contentType = {'Content-Type':'application/pdf'}
							r = requests.post(response[1].url,
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
		except Exception as ex:
				print 'Error: '+str(ex)
		
altiriaCert('346xxxxxxxx','simple')

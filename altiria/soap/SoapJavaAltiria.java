// Copyright (c) 2018, Altiria TIC SL
// All rights reserved.
// El uso de este c�digo de ejemplo es solamente para mostrar el uso de la pasarela de env�o de SMS de Altiria
// Para un uso personalizado del c�digo, es necesario consultar la API de especificaciones t�cnicas, donde tambi�n podr�s encontrar
// m�s ejemplos de programaci�n en otros lenguajes de programaci�n y otros protocolos (http, REST, web services)
// https://www.altiria.com/api-envio-sms/

package net.altiria.api.soap;

import java.net.URL;
import java.util.List;
import javax.xml.ws.BindingProvider;
import javax.xml.ws.WebServiceException;

public class SoapJavaAltiria {

public static void main(String[] args) {
try {
  //Se suministra la URL del fichero WSDL en SOAP 1.2
  URL wsdlURL = new URL("http://www.altiria.net/api/ws/soap12?wsdl");

  net.altiria.api.soap.SmsGatewayService service =
    new net.altiria.api.soap.SmsGatewayService(wsdlURL);
  net.altiria.api.soap.SmsGatewayPort soapApi = service.getSmsGatewayApi();
			    
  BindingProvider bp = (BindingProvider)soapApi;
  //Tiempo maximo de respuesta. 
  bp.getRequestContext().put("com.sun.xml.internal.ws.request.timeout", 60000);

  //Se preparan los datos del servicio web
  net.altiria.api.soap.TextMessageRequest textMessageRequest = 
    new net.altiria.api.soap.TextMessageRequest();

  //XX, YY y ZZ se corresponden con los valores de identificaci�n del usuario en el sistema	    	    
  net.altiria.api.soap.Credentials credentials = new net.altiria.api.soap.Credentials();
  //domainId solo es necesario si el login no es un email
  //credentials.setDomainId("XX");
  credentials.setLogin("YY");
  credentials.setPasswd("ZZ");

  textMessageRequest.setCredentials(credentials);
			    
  net.altiria.api.soap.TextMessage message = new net.altiria.api.soap.TextMessage();
  message.setMsg("Mensaje de prueba");

  //No es posible utilizar el remitente en Am�rica pero s� en Espa�a y Europa
  //Descomentar la l�nea solo si se cuenta con un remitente autorizado por Altiria
  //message.setSenderId("remitente");

  textMessageRequest.setMessage(message);
			    
  textMessageRequest.getDestination().add("346xxxxxxxx");
  textMessageRequest.getDestination().add("346yyyyyyyy");
			    
  net.altiria.api.soap.TextMessageResponse textMessageResponse = null;
			    
  try {
    textMessageResponse = soapApi.sendSms(textMessageRequest);	

    String status = textMessageResponse.getStatus();
		    
    if(!status.equals("000")) 
      System.out.println("ERROR. Codigo de Altiria: " + status);
    else {
      List<net.altiria.api.soap.TextDestination> destinations = 
        textMessageResponse.getDetails();
				
      for(int i=0;i<destinations.size();i++) {
        System.out.println("sendSms.destination("+i+").status=" 
           + destinations.get(i).getStatus());
				    
        System.out.println("sendSms.destination("+i+").msisdn=" 
           + destinations.get(i).getDestination());
				    
        if(destinations.get(i).getIdAck()!=null) 
          System.out.println("sendSms.destination("+i+").idAck=" 
            + destinations.get(i).getIdAck());
      }
    }
  } 
  catch (WebServiceException e){
    System.out.println("Excepcion:"+e.toString());
    return;
  }
} 
catch (Exception e) {
  System.out.println("Excepcion:"+e.toString());
}
}
}

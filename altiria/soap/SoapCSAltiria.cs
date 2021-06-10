using System;
using System.Net;

// Copyright (c) 2018, Altiria TIC SL
// All rights reserved.
// El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
// Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
// más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)
// https://www.altiria.com/api-envio-sms/

namespace SoapCSAltiria {

class SoapCSAltiria {
static void Main(string[] args) {
string[] dest = new string[2];
SmsGatewayService sms = new SmsGatewayService();
TextMessageRequest request = new TextMessageRequest();
Credentials cr = new Credentials();
TextMessage tm = new TextMessage();
TextMessageResponse response = new TextMessageResponse();

// Tiempo maximo de respuesta en milisegundos
sms.Timeout = 60000; //milisec

// XX, YY y ZZ se corresponden con los valores de identificación del usuario en el sistema
//domainId solo es necesario si el login no es un email	    	    
//cr.domainId = "XX";
cr.login = "YY";
cr.passwd = "ZZ";

tm.encoding = "UTF-8";
tm.msg = "Mensaje de prueba";
//No es posible utilizar el remitente en América pero sí en España y Europa
//Descomentar la línea solo si se cuenta con un remitente autorizado por Altiria
//tm.senderId = "remitente";

dest[0] = "346xxxxxxxx";
dest[1] = "346yyyyyyyy";

request.credentials = cr;
request.destination = dest;
request.message = tm;

try {
 response = sms.sendSms(request);

 if (response.status != "000")
   Console.WriteLine("Código de error de Altiria: " + response.status);
 else {
   Console.WriteLine("Código de Altiria: " + response.status);
   foreach (TextDestination rd in response.details)
     Console.WriteLine("  " + rd.destination + ": Código de respuesta " + rd.status);
 }
}
catch (WebException e) {
  if (e.Status == WebExceptionStatus.Timeout)
    Console.WriteLine("Error TimeOut");
  else
    Console.WriteLine("ERROR " + e.Message);   
}
catch (Exception e) {
  Console.WriteLine("ERROR: " + e.Message);
}            
}
}
}

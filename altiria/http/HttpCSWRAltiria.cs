// Copyright (c) 2018, Altiria TIC SL
// All rights reserved.
// El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
// Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
// más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)
// https://www.altiria.com/api-envio-sms/

using System;
using System.Text;
using System.Net;
using System.IO;

namespace ConsoleCOld {
class HttpCSWRAltiria {
static void Main(string[] args) {
	
//Se fija la URL sobre la que enviar la petición POST
HttpWebRequest loHttp =
  (HttpWebRequest)WebRequest.Create("http://www.altiria.net/api/http");

// Compone el mensaje a enviar
// XX, YY y ZZ se corresponden con los valores de identificación del usuario en el sistema.
string lcPostData =
  "cmd=sendsms&login=YY&passwd=ZZ&dest=346xxxxxxxx&dest=346yyyyyyyy" +
  //domainId solo es necesario si el login no es un email
  //"&domainId=XX" +
  "&msg=Mensaje de prueba"; 
  //No es posible utilizar el remitente en América pero sí en España y Europa
  //Descomentar la línea solo si se cuenta con un remitente autorizado por Altiria
  //lcPostData=lcPostData + "&senderId=remitente";

// Se codifica en utf-8
byte[] lbPostBuffer = System.Text.Encoding.GetEncoding("utf-8").GetBytes(lcPostData);
loHttp.Method = "POST";
loHttp.ContentType = "application/x-www-form-urlencoded";
loHttp.ContentLength = lbPostBuffer.Length;

//Fijamos tiempo de espera de respuesta = 60 seg
loHttp.Timeout = 60000;
String error = "";
String response = "";
// Envía la peticion
try {
  Stream loPostData = loHttp.GetRequestStream();
  loPostData.Write(lbPostBuffer, 0, lbPostBuffer.Length);
  loPostData.Close();
  // Prepara el objeto para obtener la respuesta
  HttpWebResponse loWebResponse = (HttpWebResponse)loHttp.GetResponse();
  // La respuesta vendría codificada en utf-8
  Encoding enc = System.Text.Encoding.GetEncoding("utf-8");
  StreamReader loResponseStream =
  new StreamReader(loWebResponse.GetResponseStream(), enc);
  // Conseguimos la respuesta en una cadena de texto
  response = loResponseStream.ReadToEnd();
  loWebResponse.Close();
  loResponseStream.Close();
}
catch (WebException e) {
  if (e.Status == WebExceptionStatus.ConnectFailure)
     error = "Error en la conexión";
  else if (e.Status == WebExceptionStatus.Timeout)
     error = "Error TimeOut";
  else
     error = e.Message;
}
finally {
  if (error != "")
     Console.WriteLine(error);
  else
     Console.WriteLine(response);
}
}
}
}

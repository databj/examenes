// Copyright (c) 2018, Altiria TIC SL
// All rights reserved.
// El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
// Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
// más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)
// https://www.altiria.com/api-envio-sms/

using System;
using System.Collections.Generic;
using System.Net;
using System.Net.Http;
using System.Net.Http.Headers;

namespace ConsoleCOld {
class HttpCSHCAltiria {
static void Main(string[] args) {
Envio();
}
static async void Envio() {
HttpClient client = new HttpClient();
client.BaseAddress = new Uri("http://www.altiria.net");
//Establecemos el TimeOut para obtener la respuesta del servidor
client.Timeout = TimeSpan.FromSeconds(60);

//Se compone el mensaje a enviar
// XX, YY y ZZ se corresponden con los valores de identificación del usuario en el sistema.
var postData = new List<KeyValuePair<string, string>>();
postData.Add(new KeyValuePair<string, string>("cmd", "sendsms"));
//domainId solo es necesario si el login no es un email
//postData.Add(new KeyValuePair<string, string>("domainId", "XX"));
postData.Add(new KeyValuePair<string, string>("login", "YY"));
postData.Add(new KeyValuePair<string, string>("passwd", "ZZ"));
postData.Add(new KeyValuePair<string, string>("dest", "346xxxxxxxx"));
postData.Add(new KeyValuePair<string, string>("dest", "346yyyyyyyy"));
postData.Add(new KeyValuePair<string, string>("msg", "Mensaje de prueba"));
//No es posible utilizar el remitente en América pero sí en España y Europa
//Descomentar la línea solo si se cuenta con un remitente autorizado por Altiria
//postData.Add(new KeyValuePair<string, string>("senderId", "remitente"));

HttpContent content = new FormUrlEncodedContent(postData);
String err = "";
String resp="";
try {
   //Se fija la URL sobre la que enviar la petición POST
   HttpRequestMessage request = new HttpRequestMessage(HttpMethod.Post, "/api/http");
   request.Content = content;
   content.Headers.ContentType.CharSet = "UTF-8";
   request.Content.Headers.ContentType = 
     new MediaTypeHeaderValue("application/x-www-form-urlencoded");
   HttpResponseMessage response = client.SendAsync(request).Result;
   var responseString = response.Content.ReadAsStringAsync();
   resp = responseString.Result;
}
catch (Exception e) {
   err = e.Message;
}
finally {
   if (err != "")
     Console.WriteLine(err);
   else
     Console.WriteLine(resp);
} 
}
}
}

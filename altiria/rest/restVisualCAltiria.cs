using System;
using System.Text;
using System.Net;
using System.IO;

// Copyright (c) 2020, Altiria TIC SL
// All rights reserved.
// El uso de este c�digo de ejemplo es solamente para mostrar el uso de la pasarela de env�o de SMS de Altiria
// Para un uso personalizado del c�digo, es necesario consultar la API de especificaciones t�cnicas, donde tambi�n podr�s encontrar
// m�s ejemplos de programaci�n en otros lenguajes de programaci�n y otros protocolos (http, REST, web services)
// https://www.altiria.com/api-envio-sms/

namespace RestVCAltiria {
  class Program {
    static void Main(string[] args) {
      var response = "";
      var error = "";
      try {
        //Se fija la URL sobre la que enviar la petici�n POST
        var httpWebRequest = (HttpWebRequest)WebRequest.
                                Create("http://www.altiria.net/apirest/ws/sendSms");
        httpWebRequest.ContentType = "application/json";
        httpWebRequest.Method = "POST";
        //Establecemos el TimeOut para obtener la respuesta del servidor
        httpWebRequest.Timeout = 60000;

        //domainId solo es necesario si el login no es un email
        using (var streamWriter = new StreamWriter(httpWebRequest.GetRequestStream())) {
          string json = "{\"credentials\":"
                       //+ "{\"domainId\":\"XX\","
                      + "\"login\":\"YY\",\"passwd\":\"ZZ\"},";
          json += " \"destination\":[\"346xxxxxxxx\",\"346yyyyyyyy\"],";
          //No es posible utilizar el remitente en Am�rica pero s� en Espa�a y Europa
          //Descomentar la l�nea solo si se cuenta con un remitente autorizado por Altiria
          //json += " \"message\": {\"msg\":\"Mensaje de prueba\"," 
                    + "\"senderId\":\"remitente\"}}";
          json += " \"message\": {\"msg\":\"Mensaje de prueba\"}}";
          streamWriter.Write(json);
          streamWriter.Flush();
          streamWriter.Close();
        }
            
        var httpResponse = (HttpWebResponse)httpWebRequest.GetResponse();
        using (var streamReader = new StreamReader(httpResponse.GetResponseStream())) {
          response = streamReader.ReadToEnd();
        }
          
      }catch (WebException e) {
        if (e.Status == WebExceptionStatus.ConnectFailure)
          error = "Error en la conexi�n";
        else if (e.Status == WebExceptionStatus.Timeout)
          error = "Error TimeOut";
        else
          error = e.Message;
      }finally {
        if (error != "")
          Console.WriteLine(error);
        else
          Console.WriteLine(response);
      }
    }
  }
}

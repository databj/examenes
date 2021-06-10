Imports System.Net
Imports System.Net.Http

' Copyright (c) 2018, Altiria TIC SL
' All rights reserved.
' El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
' Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
' más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)
' https://www.altiria.com/api-envio-sms/

Module HttpVBHCAltiria

Sub Main()
Dim client As HttpClient = New HttpClient
client.BaseAddress = New Uri("Http://www.altiria.net")
'Fijamos TimeOut de espera de respuesta del servidor = 60 seg
client.Timeout = TimeSpan.FromSeconds(60)

'Se compone el mensaje a enviar
'XX, YY y ZZ se corresponden con los valores de identificación del usuario en el sistema.
Dim postData As List(Of KeyValuePair(Of String, String))
postData = New List(Of KeyValuePair(Of String, String))
postData.Add(New KeyValuePair(Of String, String)("cmd", "sendsms"))
'domainId solo es necesario si el login no es un email
'postData.Add(New KeyValuePair(Of String, String)("domainId", "XX"))
postData.Add(New KeyValuePair(Of String, String)("login", "YY"))
postData.Add(New KeyValuePair(Of String, String)("passwd", "ZZ"))
postData.Add(New KeyValuePair(Of String, String)("dest", "346xxxxxxxx"))
postData.Add(New KeyValuePair(Of String, String)("dest", "346yyyyyyyy"))
postData.Add(New KeyValuePair(Of String, String)("msg", "Mensaje de prueba"))
' No es posible utilizar el remitente en América pero sí en España y Europa
' Descomentar la línea solo si se cuenta con un remitente autorizado por Altiria
' postData.Add(New KeyValuePair(Of String, String)("senderId", "remitente"))

Dim content As HttpContent = New FormUrlEncodedContent(postData)
Dim err = ""
Dim resp = ""
Try
  'Se fija la URL sobre la que enviar la petición POST
  Dim request As HttpRequestMessage
  request = New HttpRequestMessage(HttpMethod.Post, "/api/http")
  request.Content = content
  content.Headers.ContentType.CharSet = "UTF-8"
  Dim contentType = "application/x-www-form-urlencoded"
  request.Content.Headers.ContentType = New Headers.MediaTypeHeaderValue(contentType)
  Dim response As HttpResponseMessage = client.SendAsync(request).Result

  Dim responseString = response.Content.ReadAsStringAsync
  resp = responseString.Result

Catch e1 As Exception
   err = e1.Message
Finally
   If (err <> "") Then
      Console.WriteLine(err)
   Else
      Console.WriteLine(resp)
   End If
End Try
End Sub

End Module

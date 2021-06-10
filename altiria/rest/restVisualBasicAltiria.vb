Imports System.IO
Imports System.Net
Imports System.Text

' Copyright (c) 2020, Altiria TIC SL
' All rights reserved.
' El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
' Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
' más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)
' https://www.altiria.com/api-envio-sms/

Module RestVBAltiria

  Sub Main()

    Dim err = ""
    Dim resp = ""
    Try
      'Compone el mensaje a enviar
      'XX, YY y ZZ se corresponden con los valores 
      'de identificación del usuario en el sistema.
      'domainId solo es necesario si el login no es un email
      Dim json = "{""credentials"":{""login"":""YY"",""passwd"":""ZZ""},"
      'Dim json = "{""credentials"":{""domainId"":""XX"", ""login"":""YY"",""passwd"":""ZZ""},"
      json += " ""destination"":[""346xxxxxxxx"",""346yyyyyyyy""],"
      'No es posible utilizar el remitente en América pero­ sí en España y Europa
      'Descomentar la lí­nea solo si se cuenta con un remitente autorizado por Altiria
      'json += " ""message"": {""msg"":""Mensaje de prueba"",""senderId"":""remitente""}}"
      json += " ""message"": {""msg"":""Mensaje de prueba""}}"

      Dim jsonDataBytes = Encoding.UTF8.GetBytes(json)

      Dim req As WebRequest = WebRequest.Create("http://www.altiria.net/apirest/ws/sendSms")
      req.ContentType = "application/json"
      req.Method = "POST"
      req.ContentLength = jsonDataBytes.Length
      'Fijamos TimeOut de espera de respuesta del servidor = 60 seg
      req.Timeout = 60000

      Dim stream = req.GetRequestStream()
      stream.Write(jsonDataBytes, 0, jsonDataBytes.Length)
      stream.Close()

      Dim response = req.GetResponse().GetResponseStream()

      Dim reader As New StreamReader(response)
      'Conseguimos la respuesta en una cadena de texto
      resp = reader.ReadToEnd()
      reader.Close()
      response.Close()
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

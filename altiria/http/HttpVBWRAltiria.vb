Imports System.Net

' Copyright (c) 2018, Altiria TIC SL
' All rights reserved.
' El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
' Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
' más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)
' https://www.altiria.com/api-envio-sms/

Module HttpVBWRAltiria

Sub Main()
'Se fija la URL sobre la que enviar la petición POST
Dim loHttp As HttpWebRequest
loHttp =
  CType(WebRequest.Create("http://www.altiria.net/api/http"), HttpWebRequest)

'Compone el mensaje a enviar
'XX, YY y ZZ se corresponden con los valores de identificación del usuario en el sistema.
' domainId solo es necesario si el login no es un email
Dim lcPostData As String =
  "cmd=sendsms&login=YY&passwd=ZZ&dest=346xxxxxxxx&dest=346yyyyyyyy" +
' "&domainId=XX" +
  "&msg=Texto de prueba"
' No es posible utilizar el remitente en América pero sí en España y Europa
' Descomentar la línea solo si se cuenta con un remitente autorizado por Altiria
' lcPostData += "&senderId=remitente"

'Lo codifica en utf-8
Dim lbPostBuffer As Byte() =
  System.Text.Encoding.GetEncoding("utf-8").GetBytes(lcPostData)

loHttp.Method = "POST"
loHttp.ContentType = "application/x-www-form-urlencoded"
loHttp.ContentLength = lbPostBuffer.Length

'Fijamos TimeOut de espera de respuesta del servidor = 60 seg
loHttp.Timeout = 60000
Dim err As String = ""
Dim response As String = ""

'Envía la peticion
Try
  Dim loPostData As System.IO.Stream = loHttp.GetRequestStream()
  loPostData.Write(lbPostBuffer, 0, lbPostBuffer.Length)
  loPostData.Close()

  'Prepara el objeto para obtener la respuesta
  Dim loWebResponse As HttpWebResponse = CType(loHttp.GetResponse(), HttpWebResponse)
  'La respuesta vendría codificada en utf-8
  Dim enc As System.Text.Encoding = System.Text.Encoding.GetEncoding("utf-8")
  Dim loResponseStream As System.IO.StreamReader =
    New System.IO.StreamReader(loWebResponse.GetResponseStream(), enc)
  'Conseguimos la respuesta en una cadena de texto
  response = loResponseStream.ReadToEnd()
  loWebResponse.Close()
  loResponseStream.Close()

Catch e As WebException
  If (e.Status = WebExceptionStatus.ConnectFailure) Then
     err = "Error en la conexión"
  ElseIf (e.Status = WebExceptionStatus.Timeout) Then
     err = "Error Time Out"
  Else
     err = e.Message
  End If

Finally
  If (err <> "") Then
     Console.WriteLine(err)
  Else
     Console.WriteLine(response)
  End If
End Try
End Sub
End Module

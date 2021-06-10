Imports System.Net
Imports SoapVBAltiria.SoapVBAltiria

' Copyright (c) 2018, Altiria TIC SL
' All rights reserved.
' El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
' Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
' más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)
' https://www.altiria.com/api-envio-sms/

Module SoapVBAltiria

 Sub Main()
   Dim dest(1) As String
   Dim sms As SmsGatewayService = New SmsGatewayService()

   Dim request As TextMessageRequest = New TextMessageRequest()
   Dim cr As Credentials = New Credentials()
   Dim tm As TextMessage = New TextMessage()
   Dim response As TextMessageResponse = New TextMessageResponse()

   ' Tiempo maximo de respuesta en milisegundos
   sms.Timeout = 60000 'milisec

   ' XX, YY y ZZ se corresponden con los valores de identificación del usuario en el sistema	
   'domainId solo es necesario si el login no es un email    	    
   'cr.domainId = "XX"
   cr.login = "YY"
   cr.passwd = "ZZ"

   tm.encoding = "UTF-8"
   tm.msg = "Mensaje de prueba"
   
   ' No es posible utilizar el remitente en América pero sí en España y Europa
   ' Descomentar la línea solo si se cuenta con un remitente autorizado por Altiria 
   ' tm.senderId = "remitente"

   dest(0) = "346xxxxxxxx"
   dest(1) = "346yyyyyyyy"

   request.credentials = cr
   request.destination = dest
   request.message = tm

   Try
     response = sms.sendSms(request)

     If (response.status <> "000") Then
       Console.WriteLine("Código de error de Altiria: " + response.status)
     Else
       Console.WriteLine("Código de Altiria: " + response.status)
       For Each rd As TextDestination In response.details
         Console.WriteLine("  " + rd.destination + ": Código de respuesta " + rd.status)
       Next rd

     End If
   Catch e As WebException
     If (e.Status = WebExceptionStatus.Timeout) Then
       Console.WriteLine("Error TimeOut")
     Else
       Console.WriteLine("ERROR " + e.Message)
     End If
   Catch e As Exception
       Console.WriteLine("ERROR " + e.Message)
   End Try

 End Sub

End Module

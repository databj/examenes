program HttpDelphiAltiria2;

// Copyright (c) 2018, Altiria TIC SL
// All rights reserved.
// El uso de este c�digo de ejemplo es solamente para mostrar el uso de la pasarela de env�o de SMS de Altiria
// Para un uso personalizado del c�digo, es necesario consultar la API de especificaciones t�cnicas, donde tambi�n podr�s encontrar
// m�s ejemplos de programaci�n en otros lenguajes de programaci�n y otros protocolos (http, REST, web services)
// https://www.altiria.com/api-envio-sms/

{$APPTYPE CONSOLE}

{$R *.res}

uses
  System.SysUtils, Classes, System.Net.HTTPClient, System.Net.HTTPClientComponent;
var
  SUrl : String;
  client : TNetHTTPClient;
  response : IHTTPResponse;
  Parametros : TStringList;
begin
 try
   client := TNetHTTPClient.Create(nil);
   client.ContentType :='application/x-www-form-urlencoded';
   //Se fija la URL sobre la que enviar la petici�n POST
   SUrl:='http://www.altiria.net/api/http';
   //XX, YY y ZZ se corresponden con los valores de identificaci�n del usuario en el sistema
   Parametros := TStringList.Create();
   Parametros.Add('cmd=sendsms');
   //domainId solo es necesario si el login no es un email
   //Parametros.Add('domainId=XX');
   Parametros.Add('login=YY');
   Parametros.Add('passwd=ZZ');
   Parametros.Add('dest=346xxxxxxxx');
   Parametros.Add('dest=346yyyyyyyy');
   Parametros.Add(UTF8Encode('msg=Mensaje de prueba'));
   //No es posible utilizar el remitente en Am�rica pero s� en Espa�a y Europa
   //Descomentar la l�nea solo si se cuenta con un remitente autorizado por Altiria
   //Parametros.Add('senderId=remitente');

   Response:=client.Post(SUrl,Parametros);

   if Response.StatusCode = 200 then
     WriteLn(Response.ContentAsString())
   else
     begin
       WriteLn('C�digo de error: ' + IntToStr(Response.StatusCode));
       WriteLn(Response.StatusText);
     end;
 except
   on E: ENetHTTPClientException do
     WriteLn ('ERROR Conexi�n.  ' + E.Message);

   on E: Exception do
     Writeln(E.ClassName, ': ', E.Message);
 end;
 Parametros.Free;
 Client.Free;
end.
  


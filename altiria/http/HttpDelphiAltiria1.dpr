program HttpDelphiAltiria1;

// Copyright (c) 2018, Altiria TIC SL
// All rights reserved.
// El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
// Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
// más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)
// https://www.altiria.com/api-envio-sms/


{$APPTYPE CONSOLE}

{$R *.res}

uses
  System.SysUtils, Classes, IdHTTP,System.WideStrUtils;

var
  DResultado,SUrl : String;
  Parametros : TStringList;
  IdHTTP1: TIdHTTP;

begin
 try
   //Se fija la URL sobre la que enviar la petición POST
   SUrl:='http://www.altiria.net/api/http';
   //Compone el mensaje a enviar
   //XX, YY y ZZ se corresponden con los valores de identificación del usuario en el sistema
   Parametros := TStringList.Create();
   Parametros.Add('cmd=sendsms');
   //domainId solo es necesario si el login no es un email
   //Parametros.Add('domainId=XX');
   Parametros.Add('login=YY');
   Parametros.Add('passwd=ZZ');
   Parametros.Add('dest=346xxxxxxxx');
   Parametros.Add('dest=346yyyyyyyy');
   Parametros.Add(UTF8Encode('msg=Mensaje de prueba'));
   //No es posible utilizar el remitente en América pero sí en España y Europa
   //Descomentar la línea solo si se cuenta con un remitente autorizado por Altiria
   //Parametros.Add('senderId=remitente');

   IdHTTP1:= TIdHTTP.Create(nil);

   //Se fija el tiempo máximo de espera para conectar con el servidor (5000)
   //Se fija el tiempo máximo de espera de la respuesta del servidor (60000)
   IdHTTP1.ConnectTimeout := 5000;
   IdHTTP1.ReadTimeout:=60000;

   IdHTTP1.Request.ContentType :='application/x-www-form-urlencoded';
   IdHTTP1.Request.Charset := 'UTF-8';
   IdHTTP1.Request.ContentEncoding := 'UTF-8';

   // Enviamos un mensaje, recibiendo en "DResultado" la respuesta del servidor
   DResultado:=IdHTTP1.Post(SUrl,Parametros);
   WriteLn(DResultado);

 except
   on E: Exception do
     if E.ClassName='EIdConnectTimeout' then
       WriteLn ('ERROR Connect Timeout')
     else if E.ClassName='EIdReadTimeout' then
       WriteLn ('ERROR Response Timeout')
     else
       Writeln(E.ClassName, ': ', E.Message);
 end;
 Parametros.Free;
 IdHTTP1.Free;
end.

  

package mypackage;

// Copyright (c) 2018, Altiria TIC SL
// All rights reserved.
// El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
// Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
// más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)
// https://www.altiria.com/api-envio-sms/

import java.io.IOException;

import com.google.gson.JsonArray;
import com.google.gson.JsonObject;
import com.google.gson.JsonPrimitive;

import org.apache.http.client.config.RequestConfig;
import org.apache.http.client.methods.CloseableHttpResponse;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.CloseableHttpClient;
import org.apache.http.impl.client.HttpClientBuilder;
import org.apache.http.util.EntityUtils;

public class RestJavaAltiria {
	
public static void main(String args[]) throws Exception{

//Se construye el mensaje JSON
JsonObject textMessageFilter = new JsonObject();
		
JsonObject credentials = new JsonObject();
//XX, YY y ZZ se corresponden con los valores de identificación del
//usuario en el sistema.
// domainId solo es necesario si el login no es un email
//credentials.addProperty("domainId","XX"); 
credentials.addProperty("login","YY");
credentials.addProperty("passwd","ZZ");
		
JsonArray destinations = new JsonArray();
destinations.add(new JsonPrimitive(new String("346xxxxxxxx")));
destinations.add(new JsonPrimitive(new String("346yyyyyyyy")));
		
JsonObject textMessage = new JsonObject();
textMessage.addProperty("msg", "Mensaje de prueba");

//No es posible utilizar el remitente en América pero sí en España y Europa
//Descomentar la línea solo si se cuenta con un remitente autorizado por Altiria
//textMessage.addProperty("senderId", "remitente");

textMessageFilter.add("credentials", credentials);
textMessageFilter.add("destination", destinations);
textMessageFilter.add("message", textMessage);
		
//Se fija el tiempo máximo de espera para conectar con el servidor (5000)
//Se fija el tiempo máximo de espera de la respuesta del servidor (60000)
RequestConfig config = RequestConfig.custom()
 .setConnectTimeout(5000)
 .setSocketTimeout(60000)
 .build();
		
//Se inicia el objeto HTTP
HttpClientBuilder builder = HttpClientBuilder.create();
builder.setDefaultRequestConfig(config);
CloseableHttpClient httpClient = builder.build();
		
//Se fija la URL base de los recursos REST
String baseUrl = "http://www.altiria.net/apirest/ws";
HttpPost request = new HttpPost(baseUrl+"/sendSms");

//Se añade el JSON al cuerpo de la petición codificado en UTF-8
request.setEntity(new StringEntity(textMessageFilter.toString(),"UTF-8"));
		
//Se fija el tipo de contenido de la peticion POST
request.addHeader("content-type", "application/json;charset=UTF-8");
		
CloseableHttpResponse response = null;
		
try {
  System.out.println("Enviando petición");
  //Se envía la petición
  response = httpClient.execute(request);
  //Se consigue la respuesta
  String resp = EntityUtils.toString(response.getEntity());
		    
 //Error en la respuesta del servidor
 if (response.getStatusLine().getStatusCode()!=200){
  System.out.println("ERROR: Código de error HTTP:  " + response.getStatusLine().getStatusCode());
  System.out.println("Compruebe que ha configurado correctamente la direccion/url y el content-type");
  return;
 }else {
  //Se procesa la respuesta capturada en la cadena 'response'
  if (resp.startsWith("ERROR")){
   System.out.println(resp);
   System.out.println("Código de error de Altiria. Compruebe las especificaciones");
  } else
    System.out.println(resp);
 }
}
catch (Exception e) {
  System.out.println("Excepción");
  e.printStackTrace();
  return;
}
finally {
  //En cualquier caso se cierra la conexión
  request.releaseConnection();
  if(response!=null) {
   try {
    response.close();
   }
   catch(IOException ioe) {
    System.out.println("ERROR cerrando recursos");
   }
  }
}
}
}

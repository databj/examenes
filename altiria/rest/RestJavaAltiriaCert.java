package mypackage;

// Copyright (c) 2020, Altiria TIC SL
// All rights reserved.
// El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
// Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
// más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)

import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.util.TreeMap;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import com.google.gson.JsonObject;

import org.apache.commons.io.IOUtils;
import org.apache.http.client.config.RequestConfig;
import org.apache.http.client.methods.CloseableHttpResponse;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.ByteArrayEntity;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.CloseableHttpClient;
import org.apache.http.impl.client.HttpClientBuilder;
import org.apache.http.util.EntityUtils;

public class RestJavaAltiriaCert {

	public static void main(String args[]) throws Exception {

		// Se construye el mensaje JSON
		JsonObject certPdfFilter = new JsonObject();

		// XX, YY y ZZ se corresponden con los valores de identificación del usuario en el sistema.
		// domainId solo es necesario si el login no es un email
		JsonObject credentials = new JsonObject();
		
		// credentials.addProperty("domainId","XX");
		credentials.addProperty("login", "YY");
		credentials.addProperty("passwd", "ZZ");

		JsonObject document = new JsonObject();
		document.addProperty("destination", "346xxxxxxxx");
		document.addProperty("type", "simple");
		document.addProperty("webSig", true);

		certPdfFilter.add("credentials", credentials);
		certPdfFilter.add("document", document);

		// Se fija el tiempo máximo de espera para conectar con el servidor (5000)
		// Se fija el tiempo máximo de espera de la respuesta del servidor (60000)
		RequestConfig config = RequestConfig.custom().setConnectTimeout(5000).setSocketTimeout(60000).build();

		// Se inicia el objeto HTTP
		HttpClientBuilder builder = HttpClientBuilder.create();
		builder.setDefaultRequestConfig(config);
		CloseableHttpClient httpClient = builder.build();

		// Se fija la URL sobre la que enviar la petición POST
		String baseUrl = "http://www.altiria.net/apirest/ws";
		HttpPost request = new HttpPost(baseUrl + "/certPdfFile");

		// Se añade el JSON al cuerpo de la petición codificado en UTF-8
		request.setEntity(new StringEntity(certPdfFilter.toString(), "UTF-8"));

		// Se fija el tipo de contenido de la peticion POST
		request.addHeader("content-type", "application/json;charset=UTF-8");

		CloseableHttpResponse response = null;
		InputStream is = null;

		try {
			System.out.println("Enviando petición");
			// Se envía la petición
			response = httpClient.execute(request);
			// Se consigue la respuesta
			String resp = EntityUtils.toString(response.getEntity());

			// Error en la respuesta del servidor
			if (response.getStatusLine().getStatusCode() != 200) {
				System.out.println("ERROR: Código de error HTTP:  " + response.getStatusLine().getStatusCode());
				System.out.println("Compruebe que ha configurado correctamente la direccion/url y el content-type");
				return;
			} else {
				if (response != null) {
					response.close();
					response = null;
				}
				// Se procesa la respuesta capturada en la cadena 'response'
				Gson gson = new GsonBuilder().create();
				TreeMap<String, String> map = gson.fromJson(resp, TreeMap.class);

				String status = map.get("status");
				if (!status.equals("000"))
					System.out.println("ERROR: código de estado: " + status);
				else {
					String url = map.get("url");

					File file = new File("file.pdf");
					is = new FileInputStream(file);

					request = new HttpPost(url);
					request.setEntity(new ByteArrayEntity(IOUtils.toByteArray(is)));
					request.setHeader("Content-type", "application/pdf");

					System.out.println("Subiendo fichero");
					// Se envía la petición
					response = httpClient.execute(request);
					// Se consigue la respuesta
					resp = EntityUtils.toString(response.getEntity());

					if (response.getStatusLine().getStatusCode() != 200)
						System.out.println("ERROR AL SUBIR EL FICHERO: Código de error HTTP:  "
								+ response.getStatusLine().getStatusCode());
					else {
						// Se procesa la respuesta capturada en la cadena 'response'
						gson = new GsonBuilder().create();
						map = gson.fromJson(resp, TreeMap.class);
						status = map.get("status");
						if (status.equals("000"))
							System.out.println("Fichero subido correctamente: " + resp);
						else
							System.out.println("ERROR: Error al subir el fichero: " + resp);
					}
				}
			}
		} catch (Exception e) {
			System.out.println("Excepción");
			e.printStackTrace();
			return;
		} finally {
			// En cualquier caso se cierra la conexión
			request.releaseConnection();
			if (response != null) {
				try {
					response.close();
				} catch (IOException ioe) {
					System.out.println("ERROR cerrando recursos");
				}
			}
			if (is != null) {
				try {
					is.close();
				} catch (IOException ioe) {
					System.out.println("ERROR cerrando recursos");
				}
			}
		}
	}
}


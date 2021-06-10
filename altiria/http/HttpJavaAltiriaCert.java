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
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.List;
import java.util.TreeMap;

import org.apache.http.client.methods.CloseableHttpResponse;
import org.apache.commons.io.IOUtils;
import org.apache.http.NameValuePair;
import org.apache.http.impl.client.CloseableHttpClient;
import org.apache.http.client.config.RequestConfig;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.ByteArrayEntity;
import org.apache.http.impl.client.HttpClientBuilder;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

public class HttpJavaAltiriaCert {
	public static void main(String[] args) {

		// Se fija el tiempo máximo de espera para conectar con el servidor (5000)
		// Se fija el tiempo máximo de espera de la respuesta del servidor (60000)
		RequestConfig config = RequestConfig.custom().setConnectTimeout(5000).setSocketTimeout(60000).build();

		// Se inicia el objeto HTTP
		HttpClientBuilder builder = HttpClientBuilder.create();
		builder.setDefaultRequestConfig(config);
		CloseableHttpClient httpClient = builder.build();

		// Se fija la URL sobre la que enviar la petición POST
		HttpPost post = new HttpPost("http://www.altiria.net/api/http");

		// Se crea la lista de parámetros a enviar en la petición POST
		List<NameValuePair> parametersList = new ArrayList<NameValuePair>();
		// XX, YY y ZZ se corresponden con los valores de identificación del usuario en
		// el sistema.
		parametersList.add(new BasicNameValuePair("cmd", "certpdffile"));
		// domainId solo es necesario si el login no es un email
		// parametersList.add(new BasicNameValuePair("domainId", "XX"));
		parametersList.add(new BasicNameValuePair("login", "YY"));
		parametersList.add(new BasicNameValuePair("passwd", "ZZ"));
		parametersList.add(new BasicNameValuePair("destination", "346xxxxxxxx"));
		parametersList.add(new BasicNameValuePair("type", "simple"));
		parametersList.add(new BasicNameValuePair("websig", "true"));

		try {
			// Se fija la codificacion de caracteres de la peticion POST
			post.setEntity(new UrlEncodedFormEntity(parametersList, "UTF-8"));
		} catch (UnsupportedEncodingException uex) {
			System.out.println("ERROR: codificación de caracteres no soportada");
		}

		CloseableHttpResponse response = null;

		InputStream is = null;

		try {
			System.out.println("Enviando petición al comando certPdfFile");
			// Se envía la petición
			response = httpClient.execute(post);
			// Se consigue la respuesta
			String resp = EntityUtils.toString(response.getEntity());

			// Error en la respuesta del servidor
			if (response.getStatusLine().getStatusCode() != 200) {
				System.out.println("ERROR: Código de error HTTP:  " + response.getStatusLine().getStatusCode());
				System.out.println("Compruebe que ha configurado correctamente la direccion/url ");
				System.out.println("suministrada por Altiria");
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

					post = new HttpPost(url);
					post.setEntity(new ByteArrayEntity(IOUtils.toByteArray(is)));
					post.setHeader("Content-type", "application/pdf");

					System.out.println("Subiendo fichero");
					// Se envía la petición
					response = httpClient.execute(post);
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
			post.releaseConnection();
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


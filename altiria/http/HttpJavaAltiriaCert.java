package mypackage;

// Copyright (c) 2020, Altiria TIC SL
// All rights reserved.
// El uso de este c�digo de ejemplo es solamente para mostrar el uso de la pasarela de env�o de SMS de Altiria
// Para un uso personalizado del c�digo, es necesario consultar la API de especificaciones t�cnicas, donde tambi�n podr�s encontrar
// m�s ejemplos de programaci�n en otros lenguajes de programaci�n y otros protocolos (http, REST, web services)

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

		// Se fija el tiempo m�ximo de espera para conectar con el servidor (5000)
		// Se fija el tiempo m�ximo de espera de la respuesta del servidor (60000)
		RequestConfig config = RequestConfig.custom().setConnectTimeout(5000).setSocketTimeout(60000).build();

		// Se inicia el objeto HTTP
		HttpClientBuilder builder = HttpClientBuilder.create();
		builder.setDefaultRequestConfig(config);
		CloseableHttpClient httpClient = builder.build();

		// Se fija la URL sobre la que enviar la petici�n POST
		HttpPost post = new HttpPost("http://www.altiria.net/api/http");

		// Se crea la lista de par�metros a enviar en la petici�n POST
		List<NameValuePair> parametersList = new ArrayList<NameValuePair>();
		// XX, YY y ZZ se corresponden con los valores de identificaci�n del usuario en
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
			System.out.println("ERROR: codificaci�n de caracteres no soportada");
		}

		CloseableHttpResponse response = null;

		InputStream is = null;

		try {
			System.out.println("Enviando petici�n al comando certPdfFile");
			// Se env�a la petici�n
			response = httpClient.execute(post);
			// Se consigue la respuesta
			String resp = EntityUtils.toString(response.getEntity());

			// Error en la respuesta del servidor
			if (response.getStatusLine().getStatusCode() != 200) {
				System.out.println("ERROR: C�digo de error HTTP:  " + response.getStatusLine().getStatusCode());
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
					System.out.println("ERROR: c�digo de estado: " + status);
				else {
					String url = map.get("url");

					File file = new File("file.pdf");
					is = new FileInputStream(file);

					post = new HttpPost(url);
					post.setEntity(new ByteArrayEntity(IOUtils.toByteArray(is)));
					post.setHeader("Content-type", "application/pdf");

					System.out.println("Subiendo fichero");
					// Se env�a la petici�n
					response = httpClient.execute(post);
					// Se consigue la respuesta
					resp = EntityUtils.toString(response.getEntity());

					if (response.getStatusLine().getStatusCode() != 200)
						System.out.println("ERROR AL SUBIR EL FICHERO: C�digo de error HTTP:  "
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
			System.out.println("Excepci�n");
			e.printStackTrace();
			return;
		} finally {
			// En cualquier caso se cierra la conexi�n
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


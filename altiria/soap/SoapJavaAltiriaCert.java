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
import java.net.URL;
import java.util.List;
import java.util.TreeMap;

import org.apache.commons.io.IOUtils;
import org.apache.http.client.config.RequestConfig;
import org.apache.http.client.methods.CloseableHttpResponse;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.ByteArrayEntity;
import org.apache.http.impl.client.CloseableHttpClient;
import org.apache.http.impl.client.HttpClientBuilder;
import org.apache.http.util.EntityUtils;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

public class SoapJavaAltiriaCert {

	public static void main(String[] args) {
		try {
			// Se suministra la URL del fichero WSDL www.altiria.net/sustituirWSDLUrl?wsdl
			// Se debe reemplazar la cadena /sustituirWSDLUrl por la parte correspondiente
			// de la URL suministrada por Altiria para el fichero WSDL en SOAP 1.2 al
			// dar de alta el servicio
			URL wsdlURL = new URL("http://www.altiria.net/ws/soap12?wsdl");

			net.altiria.api.soap.SmsGatewayService service = new net.altiria.api.soap.SmsGatewayService(wsdlURL);
			net.altiria.api.soap.SmsGatewayPort soapApi = service.getSmsGatewayApi();

			BindingProvider bp = (BindingProvider) soapApi;
			// Tiempo maximo de respuesta.
			bp.getRequestContext().put("com.sun.xml.internal.ws.request.timeout", 60000);

			// Se preparan los datos del servicio web
			net.altiria.api.soap.CertPdfFileRequest certPdfFileRequest = new net.altiria.api.soap.CertPdfFileRequest();

			// XX, YY y ZZ se corresponden con los valores de identificación del usuario en
			// el sistema
			// domainId solo es necesario si el login no es un email
			net.altiria.api.soap.Credentials credentials = new net.altiria.api.soap.Credentials();
			// credentials.setDomainId("XX");
			credentials.setLogin("YY");
			credentials.setPasswd("ZZ");

			certPdfFileRequest.setCredentials(credentials);

			net.altiria.api.soap.Document document = new net.altiria.api.soap.Document();
			document.setDestination("346xxxxxxxx");
			document.setType("simple");
			document.setWebSig(true);

			certPdfFileRequest.setDocument(document);

			net.altiria.api.soap.CertPdfFileResponse certPdfFileResponse = null;

			CloseableHttpResponse response = null;
			InputStream is = null;
			HttpPost request = null;
			
			try {
				certPdfFileResponse = soapApi.certPdfFile(certPdfFileRequest);
				String status = certPdfFileResponse.getStatus();
				if (!status.equals("000"))
					System.out.println("ERROR. Codigo de Altiria: " + status);
				else {
					// Se fija el tiempo máximo de espera para conectar con el servidor (5000)
					// Se fija el tiempo máximo de espera de la respuesta del servidor (60000)
					RequestConfig config = RequestConfig.custom().setConnectTimeout(5000).setSocketTimeout(60000)
							.build();

					// Se inicia el objeto HTTP
					HttpClientBuilder builder = HttpClientBuilder.create();
					builder.setDefaultRequestConfig(config);
					CloseableHttpClient httpClient = builder.build();

					String url = certPdfFileResponse.getUrl();

					File file = new File("file.pdf");
					is = new FileInputStream(file);

					request = new HttpPost(url);
					request.setEntity(new ByteArrayEntity(IOUtils.toByteArray(is)));
					request.setHeader("Content-type", "application/pdf");

					System.out.println("Subiendo fichero");
					// Se envía la petición
					response = httpClient.execute(request);
					
					// Se consigue la respuesta
					String resp = EntityUtils.toString(response.getEntity());

					if (response.getStatusLine().getStatusCode() != 200)
						System.out.println("ERROR AL SUBIR EL FICHERO: Código de error HTTP:  "
								+ response.getStatusLine().getStatusCode());
					else {
						// Se procesa la respuesta capturada en la cadena 'response'
						Gson gson = new GsonBuilder().create();
						TreeMap<String, String> map = gson.fromJson(resp, TreeMap.class);
						status = map.get("status");
						if (status.equals("000"))
							System.out.println("Fichero subido correctamente: " + resp);
						else
							System.out.println("ERROR: Error al subir el fichero: " + resp);
					}
				}
			} catch (WebServiceException e) {
				System.out.println("Excepcion:" + e.toString());
				return;
			} finally {
				if (request != null)
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
		} catch (Exception e) {
			System.out.println("Excepcion:" + e.toString());
		}
	}
}

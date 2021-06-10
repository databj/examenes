// Copyright (c) 2020, Altiria TIC SL
// All rights reserved.
// El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
// Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
// más ejemplos de programación en otros lenguajes de programación y otros protocolos (http, REST, web services)

const querystring = require('querystring');
const http = require('http');
const URL = require('url').URL;
const fs = require('fs');

function altiriaCert(domainId, login, passwd, destination, type) {
  // Se contruye la cadena del post desde un objeto
  // domainId solo es necesario si el login no es un email
  var post_data = querystring.stringify({
      'cmd' : 'certpdffile',
	//'domainId' : domainId,
      'login': login,
      'passwd': passwd,
      'destination' : destination,
      'type' : type,
      'webSig': 'true'
  });

  // Un objeto de opciones sobre donde se envia el post
  var post_options = {
      host: 'www.altiria.net',
      port: '80',
      path: '/api/http',
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'Content-Length': Buffer.byteLength(post_data)
      }
  };

  // Se efectua la petición
  var post_req = http.request(post_options, function(res) {
      res.setEncoding('utf8');
      res.on('data', function (data) {
          //Es necesario procesar la respuesta y los posibles errores
          console.log('Respuesta cmd: ' + data);
	  var parsedJson = JSON.parse(data);
	  if(parsedJson.status!='000') {
		console.log("Error de Altiria cmd:"+data);
	  }else{
		console.log("Codigo de estado Alriria cmd: "+parsedJson.status);

		var options = new URL(parsedJson.url);

		const imageBuffer = fs.readFileSync('file.pdf');

		// Un objeto de opciones sobre donde se envia el post
		var post_options = {
			host: options.hostname,
			port: options.port,
			path: options.pathname,
			method: 'POST',
			headers: {
			  'Content-Type': 'application/pdf'
			}
		};
		var post_req = http.request(post_options, function(res) {
			res.setEncoding('utf8');
			res.on('data', function (data) {
				console.log('Respuesta subir fichero: ' + data);
				var parsedJson = JSON.parse(data);
				if(parsedJson.status!='000') {
					console.log("Error de Altiria al subir fichero:"+data);
				}else{
					console.log("Proceso terminado con exito");
				}
			}, function (error) {
				console.log("Codigo de estado HTTP subiendo fichero: "+error)
			});
		});
		post_req.write(imageBuffer);
		post_req.end();
	  }

      }, function (error) {
		console.log("Codigo de estado HTTP cmd: "+error)
      });
  });

  // post the data
  post_req.write(post_data);
  post_req.end();

}

// XX, YY y ZZ se corresponden con los valores de identificacion del
// usuario en el sistema.
altiriaCert('XX','YY','ZZ','346xxxxxxxx','simple');

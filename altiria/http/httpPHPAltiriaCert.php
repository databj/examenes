<?php
// Copyright (c) 2020, Altiria TIC SL
// All rights reserved.
// El uso de este código de ejemplo es solamente para mostrar el uso de la pasarela de envío de SMS de Altiria
// Para un uso personalizado del código, es necesario consultar la API de especificaciones técnicas, donde también podrás encontrar
// más ejemplos de programación en otros lenguajes y otros protocolos (http, REST, web services)

class AltiriaCert{

	public $url;
	public $domainId;
	public $login;
	public $password;
	public $debug;

	public function getUrl() {
		return $this->url;
	}

	public function setUrl($val) {
		$this->url = $val;
		return $this;
	}

	public function getDomainId() {
		return $this->domain;
	}

	public function setDomainId($val) {
		$this->domain = $val;
		return $this;
	}

	public function getLogin() {
		return $this->login;
	}

	public function setLogin($val) {
		$this->login = $val;
		return $this;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword($val) {
		$this->password = $val;
		return $this;
	}

	public function getDebug() {
		return $this->debug;
	}

	public function setDebug($val) {
		$this->debug = $val;
		return $this;
	}

	public function certPdf($destination, $type) {

		$return=false;

		// Set the curl parameters.
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->getUrl());
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded; charset=UTF-8'));
		curl_setopt($ch, CURLOPT_HEADER, false);
		// Max timeout in seconds to complete http request
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);

		$COMANDO='cmd=certpdffile&login='.$this->getLogin().'&passwd='.$this->getPassword();
		$COMANDO='cmd=certpdffile&login='.$this->getLogin().'&passwd='.$this->getPassword();
		$COMANDO.='&destination='.$destination;
		$COMANDO.='&type='.$type;
		$COMANDO.='&websig='.'true';
		if($this->getDomainId() != NULL)
			$COMANDO.= '&domainId='.$this->getDomainId();

		// Set the request as a POST FIELD for curl.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $COMANDO);

		// Get response from the server.
		$httpResponse = curl_exec($ch);

		if(curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200){
			$this->logMsg("Server Altiria response: ".$httpResponse);
			$json_parsed = json_decode($httpResponse);
			$status = $json_parsed->status;
			echo 'Código de estado Altiria: '.$status.'<br/>';
			if ($status != '000'){
				$this->logMsg("Error cert pdf: ".$httpResponse);
				return false;
			}else
				$return = $httpResponse;
		}else{
			$this->logMsg("Error cert pdf: ".curl_error($ch).'('.curl_errno($ch).')'.$httpResponse);
			$return = false;
		}
		curl_close($ch);
		return $return;
	}

	public function uploadCertPdf($url, $path) {

		$return=false;

		// Set the curl parameters.
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/pdf'));
		$filesize = filesize($path);
		$fp = fopen($path, 'rb');
		$binary = fread($fp, $filesize);
		fclose($fp);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $binary); 

		// Get response from the server.
		$httpResponse = curl_exec($ch);

		if(curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200){
			$this->logMsg("Server Altiria response: ".$httpResponse);

			$json_parsed = json_decode($httpResponse);
			$status = $json_parsed->status;
			echo 'Código de estado Altiria: '.$status.'<br/>';
			if ($status != '000'){
				$this->logMsg("Error upload cert pdf: ".$httpResponse);
				return false;
			}else 
				$return = $httpResponse;
		}else{
			$this->logMsg("Error upload cert pdf: ".curl_error($ch).'('.curl_errno($ch).')'.$httpResponse);
			$return = false;
		}
		curl_close($ch);
		return $return;
	}

	public function logMsg($msg) {
		if ($this->getDebug()===true)
		    error_log("\n".date(DATE_RFC2822)." : ".$msg."\r\n", 3, "app.log");
	}
}
?>

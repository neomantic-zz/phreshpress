<?php

class Cafepress_Request {

	private $__xmlResponse = '';

	protected $__url;

	public function __construct( $url ) {
		$this->__url = $url;
	}

	public function get() {

		$curl = curl_init();

		curl_setopt( $curl, CURLOPT_URL, $this->__url );

		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );

		$response = curl_exec( $curl );

		$this->__xmlResponse = $response;

		return $this->__xmlResponse;
	}



	public function post() {

	}

	public response() {
		return $this->__xmlResponse;
	}

	public function hasError() {

		$domDocument = new DOMDocument;

		$domDocument->loadXML( $this->__xmlResponse );

		$pathParser = new DOMXPath( $domDocument );

		$nodeList = $pathParser->query('//exception-message');

		return $nodeList->length > 0;
	}

}
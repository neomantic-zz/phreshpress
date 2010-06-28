<?php

class Cafepress_Request {

	protected	$__url;
	protected	$__curl = null;

	private		$__response = null;

	public function __construct( $url, $response ) {

		$this->__url = $url;

		$this->__response = $response;

		$this->__curl = curl_init( $this->__url );

		curl_setopt( $this->__curl, CURLOPT_RETURNTRANSFER, 1 );

	}

	public function get() {
		return $this->__execute();
	}


	public function post() {

		curl_setopt( $this->__curl, CURLOPT_HEADER, false);
		curl_setopt( $this->__curl, CURLOPT_POST, 1);

		return $this->__execute();

	}

	public function response() {
		return $this->__response;
	}

	protected function __execute() {

		$curlResponse = curl_exec( $this->__curl );

		curl_close( $this->__curl );

		$this->__curl = null;

		if ( $curlResponse !== false ) {

			$this->__response->loadXML( $curlResponse );

			return $this->isSuccessful();

		}

		return false;
	}


	public function isSuccessful() {
		return $this->__response->isSuccessful();
	}

}
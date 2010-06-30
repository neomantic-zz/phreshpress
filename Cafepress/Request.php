<?php
/******
* 	Cafepress API PHP
*    Copyright (C) 2010 Chad Albers <calbers@neomantic.com>
*
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
**/

class Cafepress_Request {


	const API_URL = 'http://api.cafepress.com/';

	const API_VERSION = '3';

	protected	$__curl = null;

	private		$__response = null;

	public function __construct( $url, $response ) {

		$this->__response = $response;

		$this->__curl = curl_init( $url );

		curl_setopt( $this->__curl, CURLOPT_RETURNTRANSFER, 1 );

	}

	public function get() {
		return $this->__execute();
	}


	public function post( $postFields = array() ) {

		curl_setopt( $this->__curl, CURLOPT_HEADER, false );

		curl_setopt( $this->__curl, CURLOPT_POST, 1);

		if ( !empty( $postFields ) ) {
			curl_setopt( $this->__curl, CURLOPT_POSTFIELDS, $postFields );
		}

		return $this->__execute();

	}

	public function getResponse() {
		return $this->__response;
	}

	protected function __execute() {

		$curlResponse = curl_exec( $this->__curl );

		$this->__curl = null;

		if ( $curlResponse !== false ) {

			$this->__response->setXML( $curlResponse );

			return $this->isSuccessful();

		}

		return false;
	}


	public function isSuccessful() {
		return $this->__response->hasError();
	}

}
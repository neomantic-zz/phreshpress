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

require_once 'Store.php';

class Cafepress_User {

	public $email = '';
	public $password = '';
	private $__userToken = '';

	public function __construct( $email, $password ) {
		$this->email = $email;
		$this->password = $password;
	}


	public function setAccountCredentials( $email, $password ) {
		$this->email = $email;
		$this->password = $password;
	}

	public function isAuthenticated() {
		return !empty($this->__userToken);
	}

	public function authenticate( $appKey, $email = '', $password = '' ) {

		if ( !empty( $email ) ) {
			$this->email = $email;
		}

		if ( !empty( $password ) ) {
			$this->password = $password;
		}


		$url = sprintf( '%sauthentication.getUserToken.cp?v=%s&appKey=%s&email=%s&password=%s',
						Cafepress_Store::API_URL,
						Cafepress_Store::API_VERSION,
						$appKey,
						$this->email,
						$this->password
						);

		$curl = curl_init();

		curl_setopt( $curl, CURLOPT_URL, $url );

		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );

		$domDocument = Cafepress_Store::getResponse( $curl );

		curl_close( $curl );

		if ( !Cafepress_Store::hasError( $domDocument ) ) {

			$pathParser = new DOMXPath( $domDocument );

			$rootContentNode = $pathParser->query('/');

			$this->__userToken = $rootContentNode->item(0)->textContent;

		}

		return $this->__userToken;

	}

	public function getUserToken(){
		return $this->__userToken;
	}

}

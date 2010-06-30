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

require_once 'StoreObject.php';
require_once 'Store.php';
require_once 'UserRequest.php';

class Cafepress_User extends Cafepress_StoreObject {

	protected	$__email		= '';
	protected	$__password		= '';

	public function __construct( $email, $password, $store = null ) {
		$this->__email = $email;
		$this->__password = $password;
		parent::__construct( $store );
	}

	public function setAccountCredentials( $email, $password, $store ) {

		$this->setEmail( $email );
		$this->setPassword( $password );
		$this->setStore( $store );
	}

	public function setEmail( $email ) {
		if ( !empty( $email ) && ( $email != $this->__email ) ) {
			$this->__email = $email;
			$this->__revokeToken();
		}
	}

	public function setPassword( $password ) {
		if ( !empty( $password ) && ( $password != $this->__password ) ) {
			$this->__password = $password;
			$this->__revokeToken();
		}
	}

	public function setStore( $store ) {
		if ( $store != null ) { // not optimal, probably should be in parent
			parent::setStore( $store );
			$this->__revokeToken();
		}
	}

	protected function __revokeToken() {
		$this->__response = null;
	}

	public function isAuthenticated() {
		return $this->getUserToken() != '';
	}

	public function authenticate( $email = '', $password = '', $store = null ) {

		$this->setAccountCredentials( $email, $password, $store );

		if ( ( $this->__email != '' ) &&
			 ( $this->__password != '' ) &&
			 ( $this->__store != null ) ) {



			$request = new Cafepress_UserRequest(
										$this->__email,
										$this->__password,
										$this->__store
										 );

			if ( $request->isSuccessful() ) {
				$this->__response = $request->getResponse();
				return true;
			}
		}

		return false;
	}

	public function getUserToken(){
		if ( !$this->hasResponse() ) {
			return '';
		}
		return $this->__response->queryToken();
	}
}

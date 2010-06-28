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
require_once 'Design.php';
require_once 'User.php';
require_once 'ProductRequest.php';

class Cafepress_Product {

	private $__merchandiseId = '';

	protected $__store;

	public function __construct( $merchandiseId, $store ) {
		$this->__merchandiseId = $merchandiseId;
		$this->__store = $store;
		$this->create();
	}


	public function getMerchandiseId() {
		return $this->__merchandiseId;
	}

	public function setMerchandiseId( $merchandiseId ){
		$this->__merchandiseId = $merchandiseId;
		$this->create();
	}

	public function create( $merchandiseId = '', $store = null ) {

		if ( $this->__store->isAuthenticated() ) {

			$merchandiseId = !empty( $merchandiseId ) ? $merchandiseId : $this->__merchandiseId;

			$store = ( $store != null ) ? $store : $this->__store;

			$request = new Cafepress_ProductRequest( $merchandiseId, $store );

			return $request->isSuccessful();
		}

		return false;
	}

	public function addDesignToFront( $design ) {

	}

}

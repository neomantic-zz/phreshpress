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
require_once 'Product.php';
require_once 'User.php';
require_once 'DesignRequest.php';


class Cafepress_Design {

	protected $__store;

	protected $__imagePath = '';

	protected $__imageId = '';

	public function __construct( $imagePath, $store ) {
		$this->__imagePath = $imagePath;
		$this->__store = $store;
		$this->create();
	}

	public function setImagePath( $imagePath ) {
		$this->__imagePath = $imagePath;
		$this->create();
	}

	public function getImageId() {
		return $this->__imageId;
	}

	public function create( $imagePath = '', $store = null ) {

		if ( $this->__store->isAuthenticated() ) {

			$imagePath = !empty( $imagePath ) ? $imagePath : $this->__imagePath;

			$store = $store != null ? $store : $this->__store;

			$request = new Cafepress_DesignRequest( $imagePath, $store );

			if ( $request->isSuccessful() ) {
				$this->__imageId = $request->response()->queryImageId();
				return true;
			}
		}

		return false;
	}
}
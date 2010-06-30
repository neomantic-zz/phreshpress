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

require_once 'Design.php';
require_once 'Product.php';
require_once 'User.php';
require_once 'Designer.php';

class Cafepress_Store {

	const API_URL = 'http://api.cafepress.com/';
	const API_VERSION = '3';

	public $name = '';
	public $appKey = '';
	public $user = null;

	public function __construct( $appKey, $name, $user = null ) {
		$this->appKey = $appKey;
		$this->name = $name;
		$this->user = $user;
	}

	public function isAuthenticated(){
		return ( $this->user == null ) ? false : $this->user->isAuthenticated();
	}

	public function authenticate( $email = '', $password = '' ) {
		if ( !empty( $email) && !empty( $password) ) {
			$this->user = $this->createUser( $email, $password );
		}

		if ( !$this->user->isAuthenticated() ) {
			$this->user->authenticate();
		}
	}

	public function createUser( $email, $password ) {
		return new Cafepress_User( $email, $password, $this );
	}

	public function createProduct( $merchandiseId ) {'authenticating' );
		if ( !$this->isAuthenticated() ) {
			return false;
		}

		return new Cafepress_Product( $merchandiseId, $this );
	}

	public function createDesign( $imagePath ){
		if ( !$this->isAuthenticated() ) {
			return false;
		}
		return new Cafepress_Design( $imagePath, $this );
	}

	public function createProductWithDesign( $merchandiseId, $imagePath, $positions = array( Cafepress_Product::FRONT_CENTER ) ) {
		if ( !$this->isAuthenticated() ) {
			return false;
		}

		$product = $this->createProduct( $merchandiseId );

		$design = $this->createDesign( $imagePath );

		if ( $product && $design ) {

			$designer = new Cafepress_Designer( $product, $this );

			$designs = array();

			foreach ( $positions as $position ) {
				$designs[ $position ] = $design;
			}

			$designer->addDesigns( $designs );

			return $designer->getProductMarketUri();
		}

		return false;
	}

}


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
require_once 'Request.php';
require_once 'ProductResponse.php';

class Cafepress_ProductRequest extends Cafepress_Request {

	public function __construct( $merchandiseId, $store ) {

		if ( $store->isAuthenticated() ) {

			$url = sprintf( '%sproduct.create.cp?v=%s&appKey=%s&merchandiseId=%s&fieldTypes=writable',
							Cafepress_Request::API_URL,
							Cafepress_Request::API_VERSION,
							$store->getAppKey(),
							$merchandiseId
							);

			parent::__construct( $url, new Cafepress_ProductResponse() );

			$this->get();
		}
	}
}
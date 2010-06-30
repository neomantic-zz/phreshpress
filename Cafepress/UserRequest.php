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
require_once 'UserResponse.php';


class Cafepress_UserRequest extends Cafepress_Request {

	public function __construct( $email, $password, $store ) {

		$url = sprintf( '%sauthentication.getUserToken.cp?v=%s&appKey=%s&email=%s&password=%s',
								Cafepress_Request::API_URL,
								Cafepress_Request::API_VERSION,
								$store->appKey,
								$email,
								$password
						);

		parent::__construct( $url, new Cafepress_UserResponse() );

		$this->get();
	}

}


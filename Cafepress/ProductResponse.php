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

require_once "Response.php";

class Cafepress_ProductResponse extends Cafepress_Response {

	public function queryFrontCenter() {
		$this->queryPosition('FrontCenter');
	}

	public function queryBack() {
		$this->queryPosition( 'BackCenter');
	}

	public function queryPosition( $position ) {
		return $this->__xPathParser->query( $pathParser->query( "//mediaConfiguration[@name='" . $position . "']" ));
	}

	public function queryStoreId() {
		return $this->__xPathParser->query( "//@storeId" );
	}

}
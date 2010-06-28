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
require_once 'DesignResponse.php';

class Cafepress_DesignRequest extends Cafepress_Request {

	const DEFAULT_FOLDER = 'Images';
	const UPLOAD_URL = 'http://upload.cafepress.com/';

	public $folder = self::DEFAULT_FOLDER;

	public function __construct( $imagePath, $store,  $folder = '' ) {

		if ( $store->isAuthenticated() ) {

			$folder = !empty( $folder ) ? $folder : $this->folder;

			$postFields = array(
								'userToken' => $store->user->getUserToken(),
								'appKey' => $store->appKey,
								'folder' => $folder,
								'cpFile1' => '@' . $imagePath // wish I understood the need for '@'?
								);

			parent::__construct( self::UPLOAD_URL . 'image.upload.cp',
								 new Cafepress_DesignResponse() );

			$this->post( $postFields );
		}

	}

}
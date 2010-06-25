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

class Cafepress_Design {

	const DEFAULT_FOLDER = 'Images';
	const UPLOAD_URL = 'http://upload.cafepress.com/';

	private $__user = null;

	public $imagePath = '';
	public $imageId = '';
	public $appKey = '';

	public function __construct( $user, $appKey, $imagePath ) {
		$this->__user = $user;
		$this->imagePath = $imagePath;
		$this->appKey = $appKey;
		$this->__create();
	}


	private function __create() {

		if ( $this->__user->isAuthenticated() ) {

			$curl = curl_init();

			curl_setopt( $curl, CURLOPT_URL, self::UPLOAD_URL . 'image.upload.cp' );
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt( $curl, CURLOPT_HEADER, false);
			curl_setopt( $curl, CURLOPT_POST, 1);
			curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
														  'userToken' => $this->__user->getUserToken(),
														  'appKey' => $this->appKey,
														  'folder' => self::DEFAULT_FOLDER,
														  'cpFile1' => '@' . $this->imagePath // wish I understood the need for '@'?
														  ));

			$domDocument = Cafepress_Store::getResponse( $curl );

			curl_close( $curl );

			if ( !Cafepress_Store::hasError( $domDocument ) ){

				$pathParser = new DOMXPath( $domDocument );

				$rootContentNode = $pathParser->query('//value');

				$this->imageId = $rootContentNode->item(0)->nodeValue; //would have multiple items, if we are uploading, multiple Images
			}

		}
	}
}
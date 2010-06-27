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

class Cafepress_Product {

	private $__merchandiseId = '';
	private $__domDocument = null;
	private $__marketUri = '';

	protected $__store;

	public function __construct( $merchandiseId, $store, $user ) {
		$this->__merchandiseId = $merchandiseId;
		$this->user = $user;
		$this->__store = $store;
		$this->__create();
	}


	public function getMerchandiseId() {
		return $this->__merchandiseId;
	}

	public function setMerchandiseId( $merchandiseId ){
		$this->__merchandiseId = $merchandiseId;
		if ( $this->__domDocument != null ){
			$this->__create();
		}
	}

	private function __create() {

		$url = sprintf( '%sproduct.create.cp?v=%s&appKey=%s&merchandiseId=%s&fieldTypes=writable',
						Cafepress_Store::API_URL,
						Cafepress_Store::API_VERSION,
						$this->__store->appKey,
						$this->__merchandiseId
						);

		$curl = curl_init();

		curl_setopt( $curl, CURLOPT_URL, $url );

		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );

		$domDocument = Cafepress_Store::getResponse( $curl );

		curl_close( $curl );

		if ( !Cafepress_Store::hasError( $domDocument) ) {
			$this->__domDocument = $domDocument;
		}

		return false;
	}

	public function addDesign( $design, $position = 'front', $storeName = '' ) {

		if ( $this->__domDocument != null ) {

			$positionAttribute = 'FrontCenter';

			$storeName = !empty( $storeName ) : $storeName ? $this->__store->name;

			$pathParser = new DOMXPath( $this->__domDocument );

			$nodeList = $pathParser->query( "//mediaConfiguration[@name='" . $positionAttribute . "']" );

			$nodeList->item(0)->setAttribute( 'designId',  $design->imageId );

			$nodeList = $pathParser->query( "//@storeId" );

			//add the store name
			$nodeList->item(0)->value = $storeName;

			$curl = curl_init();

			$url = sprintf('%sproduct.save.cp?v=%s&appKey=%s&userToken=%s&value=%s&fieldTypes=readonly',
						   Cafepress_Store::API_URL,
						   Cafepress_Store::API_VERSION,
						   $this->__store->appKey,
						   $this->user->getUserToken(),
						   urlencode( $this->__domDocument->saveXML() )
						   );

			curl_setopt( $curl, CURLOPT_URL, $url );

			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );

			$domDocument = Cafepress_Store::getResponse( $curl );

			curl_close( $curl );

			if ( !Cafepress_Store::hasError( $domDocument ) ){
				$pathParser = new DOMXPath( $domDocument );
				$nodeList = $pathParser->query('//@marketplaceUri');
				$this->__marketUri = $nodeList->item(0)->nodeValue;
			}

		}

		return $this->__marketUri;

	}

	public function addDesignToFront( $design ) {
		$this->__create();
		return $this->addDesign( $design , 'front' );
	}

	public function getMarketUri() {
		return $this->__marketUri;
	}


}

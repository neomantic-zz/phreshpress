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


require_once "Store.php";
require_once "Product.php";
require_once "Design.php";
require_once "DesignerResponse.php";

class Cafepress_DesignerRequest extends Cafepress_Request {

	public function __construct( $designs, $product, $store  ) {

		if ( $store->isAuthenticated() ) {

			$productResponse = $product->getResponse();

			foreach( $designs as $position => $design ) {
				$nodeList = $productResponse->queryPosition( $position );
				$nodeList->item(0)->setAttribute( 'designId',  $design->getImageId() );
			}

			$nodeList = $productResponse->queryStoreId();

			//add the store name
			$nodeList->item(0)->value = $store->name;

			$url = sprintf('%sproduct.save.cp?v=%s',
						   Cafepress_Store::API_URL,
						   Cafepress_Store::API_VERSION );

			$postFields = array(
								'userToken' => $store->user->getUserToken(),
								'appKey' => $store->appKey,
								'value' => $productResponse->getXML()
								);

			parent::__construct( $url, new Cafepress_DesignerResponse() );

			$this->post( $postFields );
		}
	}
}
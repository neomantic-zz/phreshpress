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

require_once 'Product.php';
require_once 'DesignerRequest.php';

class Cafepress_Designer {

	protected $__product;
	protected $__designs = array();
	protected $__store;


	public function __construct( $product, $store, $designs = array() ) {
		$this->__product = $product;
		$this->__store = $store;

		if ( !empty( $designs ) ) {
			$this->__designs = $designs;
			$this->addDesigns();
		}
	}

	public function addDesigns( $designs = array(), $product = null ) {

		if ( ( $this->__store != null ) && ( $this->__store->isAuthenticated() ) ) {

			$this->__designs = !empty( $designs ) ? $designs : $this->__designs;

			$this->__product = $product != null ? $product : $this->__product;

			if ( !empty( $this->__designs ) ) {
				$request = new Cafepress_DesignerRequest(
														 $this->__designs,
														 $this->__product,
														 $this->__store
														 );
				if ( $request->isSuccessful() ) {
					$this->__response = $request->response();
					return true;
				}
			}
		}

		return false;
	}

	public function addDesign( $design, $position = Cafepress_Product::FRONT_CENTER ,  $product = null ) {
		return $this->addDesigns( array( $position => $design ), $product );
	}

	public function addDesignToFrontCenter( $design, $product = null ) {
		return $this->addDesign( $design, $product );
	}

	public function getProductMarketUri() {
		return $this->__response->queryMarketplaceUri();
	}

	public function setProduct( $product ) {
		$this->__product = $product;
	}

	public function getProduct(){
		return $this->__product;
	}

	public function setDesigns( $designs ) {
		$this->__designs = $designs;
	}

	public function getDesigns( $designs ) {
		return $this->__designs;
	}

}

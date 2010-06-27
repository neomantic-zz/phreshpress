<?php

class Cafepress_UserResponse extends Cafepress_Response {

	public function __construct( $xmlResponse ) {
		parent::__construct( $xmlResponse );
	}

	public function queryToken() {

		$rootContentNode = $this->__xPathParser->query('/');

		return $rootContentNode->item(0)->textContent;
	}

}

<?php

class Cafepress_UserRequest extends Cafepress_Request {

	public function __construct( $email, $password, $appKey ) {

		$this->__url = sprintf( '%sauthentication.getUserToken.cp?v=%s&appKey=%s&email=%s&password=%s',
								Cafepress_Store::API_URL,
								Cafepress_Store::API_VERSION,
								$appKey,
								$email,
								$password
								);

		parent::__construct();

		$this->get();
	}

	public function response() {
		return new Cafepress_UserResponse( parent::response() );
	}
}


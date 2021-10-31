<?php

class EtsyAuth {
	
	/*
	 * Values from 'values.JSON' file
	 */
	private $vals;
	
	
	/*
	 * OAuth class
	 */
	private $oauth;
	
	
	/*
	 * Callback URL
	 */
	private $callback;
	
	
	/*
	 * Scope
	 */
	private $scope;
	
	
	/*
	 * Request token
	 */
	private $req_token;
	
	
	/*
	 * URL to be displayed to authenticate user
	 */
	private $clickable_url;
	
	
	/*
	 * Access token
	 */
	private $access_token;
	
	
	/*
	 * OAuth setToken method_exists
	 */
	private $set_token;
	
	
	/*
	 * Decoded JSON values
	 */
	private $json;
	
	
	/*
	 * Constructor, accepts values from JSON file
	 */
	function __construct( $vals ) {
		
		// Define vars
		$this->vals = $vals;
		
	}
	
	
	/*
	 * Function, gets request token
	 */
	function etsyGetRequestToken() {
		
		// Instantiate the OAuth object
		$this->oauth = new OAuth( $this->vals['values']['oauth_consumer_key'], $this->vals['values']['oauth_consumer_secret'] );
		
		
		// Disable SSL checks
		//$this->oauth->disableSSLChecks();
		
		
		// Get callback URL from JSON file
		$this->callback = $this->vals['values']['callback_url'];
		
		
		// Get permission scope
		$this->scope = $this->vals['values']['scope'];
		
		
		// Make request for verifier
		$this->req_token = $this->oauth->getRequestToken( 'https://openapi.etsy.com/v2/oauth/request_token?scope=' . $this->scope, $this->callback );
		
		
		// Print clickable url
		$this->clickable_url = sprintf(
			'<a href="%s">%s</a>',
			$this->req_token['login_url'],
			$this->req_token['login_url']
		);
		print $this->clickable_url;
		
		
		// Write values to JSON file
		$this->vals['values']['oauth_req_token_secret'] = $this->req_token['oauth_token_secret'];
		file_put_contents( 'values.json',json_encode( $this->vals ) );
		
	}
	
	
	/*
	 * Function, returns values
	 */
	function returnValues() {
		
		// Write values to JSON file
		$this->vals['values']['oauth_req_token'] = $_GET['oauth_token'];
		$this->vals['values']['oauth_verifier']  = $_GET['oauth_verifier'];
		file_put_contents( 'values.json',json_encode( $this->vals ) );
		
	}
	
	
	/*
	 * Method, sets token
	 */
	function setToken() {
		
		// Instantiate the OAuth object
		$this->oauth = new OAuth( $this->vals['values']['oauth_consumer_key'], $this->vals['values']['oauth_consumer_secret'] );
		$this->oauth->disableSSLChecks();
		
		
		// Set token
		$this->oauth->setToken( $this->vals['values']['oauth_req_token'], $this->vals['values']['oauth_req_token_secret'] );
		
		
		// Get access token
		$this->access_token = $this->oauth->getAccessToken( 'https://openapi.etsy.com/v2/oauth/access_token', null, $this->vals['values']['oauth_verifier'] );
		
		
		// Write values to json file
		$this->vals['values']['oauth_token'] = $this->access_token['oauth_token'];
		$this->vals['values']['oauth_token_secret'] = $this->access_token['oauth_token_secret'];
		file_put_contents( 'values.json', json_encode( $this->vals ) );
		
	}
	
	
	/*
	 * Method, makes call to API
	 * If user is authenticated, will return data
	 */
	function makeAPIcall() {
		
		// Instantiate the OAuth object
		$this->oauth = new OAuth( $this->vals['values']['oauth_consumer_key'], $this->vals['values']['oauth_consumer_secret'], OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
		$this->oauth->disableSSLChecks();
		
		
		// Set token
		$this->oauth->setToken( $this->vals['values']['oauth_token'], $this->vals['values']['oauth_token_secret'] );
		
		
		// Make test API call
		$this->data = $this->oauth->fetch("https://openapi.etsy.com/v2/users/__SELF__", null, OAUTH_HTTP_METHOD_GET);
		$this->json = $this->oauth->getLastResponse();
		print_r(json_decode($this->json, true));
		
	}
	
}


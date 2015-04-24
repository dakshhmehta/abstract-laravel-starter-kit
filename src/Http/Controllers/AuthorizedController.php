<?php namespace Kit\Http\Controllers;

use Illuminate\Routing\Controller;

class AuthorizedController extends Controller {

	/**
	 * Whitelisted auth routes.
	 *
	 * @var array
	 */
	protected $whitelist = array();

	/**
	 * Initializer.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// Apply the auth filter
		//$this->middleware('auth');
	}
}

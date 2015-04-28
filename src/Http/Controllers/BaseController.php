<?php namespace Kit\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\MessageBag;
use Sentry;
use Kit\Models\User;

class BaseController extends Controller {

	protected $theme = 'frontend';

	/**
	 * Message bag.
	 *
	 * @var Illuminate\Support\MessageBag
	 */
	protected $messageBag = null;

	/**
	 * Initializer.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
		$this->messageBag = new MessageBag;
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public function view($uri, $data = array()){

		if(Sentry::check())
			$data['currentUser'] = Sentry::getUser();
		else
			$data['currentUser'] = new User(['first_name' => 'Guest']);

		return View::make($this->theme.'.'.$uri, $data);
	}

}

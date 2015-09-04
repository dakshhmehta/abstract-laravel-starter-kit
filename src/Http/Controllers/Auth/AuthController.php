<?php namespace Kit\Http\Controllers\Auth;

use Activation;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Factory as Validator;
use Illuminate\View\Factory as View;
use Kit\Http\Controllers\BaseController;
use Lang;
use Mail;
use Reminder;
use Session;
use URL;

class AuthController extends BaseController {
	protected $auth;
	protected $request;


	public function __construct(Sentinel $auth, Request $request){
		parent::__construct();

		$this->auth = $auth;
		$this->request = $request;
	}

	/**
	 * Account sign in.
	 *
	 * @return View
	 */
	public function getSignin(View $view)
	{
		// Is the user logged in?
		if ($this->auth->check())
		{
			return $redirector->route('account');
		}

		// Show the page
		return $view->make('kit::frontend.auth.signin');
	}

	/**
	 * Account sign in form processing.
	 *
	 * @return Redirect
	 */
	public function postSignin(Validator $validator, Redirector $redirector)
	{
		// Declare the rules for the form validation
		$rules = array(
			'email'    => 'required|email',
			'password' => 'required|between:3,32',
		);

		// Create a new validator instance from our validation rules
		$validator = $validator->make($this->request->all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return $redirector->back()->withInput()->withErrors($validator);
		}

		try {
			// Try to log the user in
			$user = $this->auth->authenticate($this->request->only('email', 'password'), $this->request->get('remember-me', 0));

			if($user == false){
				return $redirector->back()->with('error', Lang::get('kit::auth/message.signin.error'));
			}

			// Get the page we were before
			$redirect = Session::get('loginRedirect', 'account');

			// Unset the page we were before from the session
			Session::forget('loginRedirect');

			// Redirect to the users page
			return $redirector->to($redirect)->with('success', Lang::get('kit::auth/message.signin.success'));
		}
		catch (ThrottlingException $e)
		{
			return $redirector->back()->with('error', $e->getMessage());
		}

		// Ooops.. something went wrong
		return $redirector->back()->withInput()->withErrors($this->messageBag);
	}

	/**
	 * Account sign up.
	 *
	 * @return View
	 */
	public function getSignup(View $view)
	{
		// Is the user logged in?
		if ($this->auth->check())
		{
			return $redirector->route('account');
		}

		// Show the page
		return $view->make('kit::frontend.auth.signup');
	}

	/**
	 * Account sign up form processing.
	 *
	 * @return Redirect
	 */
	public function postSignup(Validator $validator, Redirector $redirector)
	{
		// Declare the rules for the form validation
		$rules = array(
			'first_name'       => 'required|min:3',
			'last_name'        => 'required|min:3',
			'email'            => 'required|email|unique:users',
			'email_confirm'    => 'required|email|same:email',
			'password'         => 'required|between:3,32',
			'password_confirm' => 'required|same:password',
		);

		// Create a new validator instance from our validation rules
		$validator = $validator->make($this->request->all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return $redirector->back()->withInput()->withErrors($validator);
		}

		try
		{
			// Register the user
			$user = $this->auth->register(array(
				'first_name' => Input::get('first_name'),
				'last_name'  => Input::get('last_name'),
				'email'      => Input::get('email'),
				'password'   => Input::get('password'),
			));

			$activation = Activation::create($user);

			// Data to be used on the email view
			$data = array(
				'user'          => $user,
				'activationUrl' => URL::route('activate', [$activation->getCode(), $user->id]),
			);

			// Send the activation code through email
			try {
				Mail::send('kit::emails.register-activate', $data, function($m) use ($user)
				{
					$m->to($user->email, $user->first_name . ' ' . $user->last_name);
					$m->subject('Welcome ' . $user->first_name);
				});
			}
			catch(\Swift_TransportException $e)
			{
				Activation::complete($user, $activation->getCode());
			}

			// Redirect to the register page
			return $redirector->route('signin')->with('success', Lang::get('kit::auth/message.signup.success'));
		}
		catch (\Cartalyst\Sentinel\Users\UserExistsException $e)
		{
			$this->messageBag->add('email', Lang::get('kit::auth/message.account_already_exists'));
		}

		// Ooops.. something went wrong
		return $redirector->back()->withInput()->withErrors($this->messageBag);
	}

	/**
	 * User account activation page.
	 *
	 * @param  string  $actvationCode
	 * @return
	 */
	public function getActivate($activationCode = null, $userId = null, Validator $validator, Redirector $redirector)
	{
		// Is the user logged in?
		if ($this->auth->check())
		{
			return $redirector->route('account');
		}

		try
		{
			// Get the user we are trying to activate
			$user = $this->auth->getUserRepository()->findById($userId);

			// Try to activate this user account
			if (Activation::complete($user, $activationCode))
			{
				// Redirect to the login page
				return $redirector->route('signin')->with('success', Lang::get('kit::auth/message.activate.success'));
			}

			// The activation failed.
			$error = Lang::get('kit::auth/message.activate.error');
		}
		catch (\Cartalyst\Sentinel\Users\UserNotFoundException $e)
		{
			$error = Lang::get('kit::auth/message.activate.error');
		}

		// Ooops.. something went wrong
		return $redirector->route('signin')->with('error', $error);
	}

	/**
	 * Forgot password page.
	 *
	 * @return View
	 */
	public function getForgotPassword(View $view)
	{
		// Show the page
		return $view->make('kit::frontend.auth.forgot-password');
	}

	/**
	 * Forgot password form processing page.
	 *
	 * @return Redirect
	 */
	public function postForgotPassword(Validator $validator, Redirector $redirector)
	{
		// Declare the rules for the validator
		$rules = array(
			'email' => 'required|email',
		);

		// Create a new validator instance from our dynamic rules
		$validator = $validator->make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return $redirector->route('forgot-password')->withInput()->withErrors($validator);
		}

		try
		{
			// Get the user password recovery code
			$user = $this->auth->getUserRepository()->where('email', Input::get('email'))->firstOrFail();

			$reminder = Reminder::create($user);

			// Data to be used on the email view
			$data = array(
				'user'              => $user,
				'forgotPasswordUrl' => URL::route('forgot-password-confirm', [$reminder->code, $user->id]),
			);

			// Send the activation code through email
			Mail::send('kit::emails.forgot-password', $data, function($m) use ($user)
			{
				$m->to($user->email, $user->first_name . ' ' . $user->last_name);
				$m->subject('Account Password Recovery');
			});
		}
		catch (\Cartalyst\Sentinel\Users\UserNotFoundException $e)
		{
			// Even though the email was not found, we will pretend
			// we have sent the password reset code through email,
			// this is a security measure against hackers.
		}

		//  Redirect to the forgot password
		return $redirector->route('forgot-password')->with('success', Lang::get('kit::auth/message.forgot-password.success'));
	}

	/**
	 * Forgot Password Confirmation page.
	 *
	 * @param  string  $passwordResetCode
	 * @param  integer $userId ID of the user
	 * @return View
	 */
	public function getForgotPasswordConfirm($passwordResetCode = null, $userId = null, View $view, Redirector $redirector)
	{
		try
		{
			// Find the user
			$user = $this->auth->getUserRepository()->findById($userId);

			// Show the page if user has requested a forget password
			if(Reminder::exists($user))
				return $view->make('kit::frontend.auth.forgot-password-confirm');
		}
		catch(\Cartalyst\Sentinel\Users\UserNotFoundException $e)
		{
			// Redirect to the forgot password page
			return $redirector->route('forgot-password')->with('error', Lang::get('kit::auth/message.account_not_found'));
		}

	}

	/**
	 * Forgot Password Confirmation form processing page.
	 *
	 * @param  string  $passwordResetCode
	 * @return Redirect
	 */
	public function postForgotPasswordConfirm($passwordResetCode = null, $userId = null, Validator $validator, Redirector $redirector)
	{
		// Declare the rules for the form validation
		$rules = array(
			'password'         => 'required',
			'password_confirm' => 'required|same:password'
		);

		// Create a new validator instance from our dynamic rules
		$validator = $validator->make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return $redirector->route('forgot-password-confirm', $passwordResetCode)->withInput()->withErrors($validator);
		}

		try
		{
			// Find the user using the password reset code
			$user = $this->auth->getUserRepository()->findById($userId);

			// Attempt to reset the user password
			if (Reminder::exists($user) and Reminder::complete($user, $passwordResetCode, Input::get('password')))
			{
				// Password successfully reseted
				return $redirector->route('signin')->with('success', Lang::get('kit::auth/message.forgot-password-confirm.success'));
			}
			else
			{
				// Ooops.. something went wrong
				return $redirector->route('signin')->with('error', Lang::get('kit::auth/message.forgot-password-confirm.error'));
			}
		}
		catch (\Cartalyst\Sentinel\Users\UserNotFoundException $e)
		{
			// Redirect to the forgot password page
			return $redirector->route('forgot-password')->with('error', Lang::get('kit::auth/message.account_not_found'));
		}
	}

	/**
	 * Logout page.
	 *
	 * @return Redirect
	 */
	public function getLogout(Redirector $redirector)
	{
		// Log the user out
		$this->auth->logout();

		// Redirect to the users page
		return $redirector->to('/')->with('success', 'You have successfully logged out!');
	}

}

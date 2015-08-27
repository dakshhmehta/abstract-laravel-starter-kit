<?php namespace Kit\Http\Controllers\Auth;

use Kit\Http\Controllers\BaseController;
use Sentinel;
use Redirect;
use View;
use Validator;
use Session;
use Lang;
use Mail;
use Input;
use URL;
use Activation;

class AuthController extends BaseController {

	/**
	 * Account sign in.
	 *
	 * @return View
	 */
	public function getSignin()
	{
		// Is the user logged in?
		if (Sentinel::check())
		{
			return Redirect::route('account');
		}

		// Show the page
		return View::make('kit::frontend.auth.signin');
	}

	/**
	 * Account sign in form processing.
	 *
	 * @return Redirect
	 */
	public function postSignin()
	{
		// Declare the rules for the form validation
		$rules = array(
			'email'    => 'required|email',
			'password' => 'required|between:3,32',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		try
		{
			// Try to log the user in
			Sentinel::authenticate(Input::only('email', 'password'), Input::get('remember-me', 0));

			// Get the page we were before
			$redirect = Session::get('loginRedirect', 'account');

			// Unset the page we were before from the session
			Session::forget('loginRedirect');

			// Redirect to the users page
			return Redirect::to($redirect)->with('success', Lang::get('kit::auth/message.signin.success'));
		}
		catch (\Cartalyst\Sentinel\Users\UserNotFoundException $e)
		{
			$this->messageBag->add('email', Lang::get('kit::auth/message.account_not_found'));
		}
		catch (\Cartalyst\Sentinel\Users\UserNotActivatedException $e)
		{
			$this->messageBag->add('email', Lang::get('kit::auth/message.account_not_activated'));
		}
		catch (\Cartalyst\Sentinel\Throttling\UserSuspendedException $e)
		{
			$this->messageBag->add('email', Lang::get('kit::auth/message.account_suspended'));
		}
		catch (\Cartalyst\Sentinel\Throttling\UserBannedException $e)
		{
			$this->messageBag->add('email', Lang::get('kit::auth/message.account_banned'));
		}

		// Ooops.. something went wrong
		return Redirect::back()->withInput()->withErrors($this->messageBag);
	}

	/**
	 * Account sign up.
	 *
	 * @return View
	 */
	public function getSignup()
	{
		// Is the user logged in?
		if (Sentinel::check())
		{
			return Redirect::route('account');
		}

		// Show the page
		return View::make('kit::frontend.auth.signup');
	}

	/**
	 * Account sign up form processing.
	 *
	 * @return Redirect
	 */
	public function postSignup()
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
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		try
		{
			// Register the user
			$user = Sentinel::register(array(
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
			return Redirect::route('signin')->with('success', Lang::get('kit::auth/message.signup.success'));
		}
		catch (\Cartalyst\Sentinel\Users\UserExistsException $e)
		{
			$this->messageBag->add('email', Lang::get('kit::auth/message.account_already_exists'));
		}

		// Ooops.. something went wrong
		return Redirect::back()->withInput()->withErrors($this->messageBag);
	}

	/**
	 * User account activation page.
	 *
	 * @param  string  $actvationCode
	 * @return
	 */
	public function getActivate($activationCode = null, $userId = null)
	{
		// Is the user logged in?
		if (Sentinel::check())
		{
			return Redirect::route('account');
		}

		try
		{
			// Get the user we are trying to activate
			$user = Sentinel::getUserRepository()->findById($userId);

			// Try to activate this user account
			if (Activation::complete($user, $activationCode))
			{
				// Redirect to the login page
				return Redirect::route('signin')->with('success', Lang::get('kit::auth/message.activate.success'));
			}

			// The activation failed.
			$error = Lang::get('kit::auth/message.activate.error');
		}
		catch (\Cartalyst\Sentinel\Users\UserNotFoundException $e)
		{
			$error = Lang::get('kit::auth/message.activate.error');
		}

		// Ooops.. something went wrong
		return Redirect::route('signin')->with('error', $error);
	}

	/**
	 * Forgot password page.
	 *
	 * @return View
	 */
	public function getForgotPassword()
	{
		// Show the page
		return View::make('kit::frontend.auth.forgot-password');
	}

	/**
	 * Forgot password form processing page.
	 *
	 * @return Redirect
	 */
	public function postForgotPassword()
	{
		// Declare the rules for the validator
		$rules = array(
			'email' => 'required|email',
		);

		// Create a new validator instance from our dynamic rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::route('forgot-password')->withInput()->withErrors($validator);
		}

		try
		{
			// Get the user password recovery code
			$user = Sentinel::getUserRepository()->findByLogin(Input::get('email'));

			// Data to be used on the email view
			$data = array(
				'user'              => $user,
				'forgotPasswordUrl' => URL::route('forgot-password-confirm', $user->getResetPasswordCode()),
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
		return Redirect::route('forgot-password')->with('success', Lang::get('kit::auth/message.forgot-password.success'));
	}

	/**
	 * Forgot Password Confirmation page.
	 *
	 * @param  string  $passwordResetCode
	 * @return View
	 */
	public function getForgotPasswordConfirm($passwordResetCode = null)
	{
		try
		{
			// Find the user using the password reset code
			$user = Sentinel::getUserRepository()->findByResetPasswordCode($passwordResetCode);
		}
		catch(\Cartalyst\Sentinel\Users\UserNotFoundException $e)
		{
			// Redirect to the forgot password page
			return Redirect::route('forgot-password')->with('error', Lang::get('kit::auth/message.account_not_found'));
		}

		// Show the page
		return View::make('kit::frontend.auth.forgot-password-confirm');
	}

	/**
	 * Forgot Password Confirmation form processing page.
	 *
	 * @param  string  $passwordResetCode
	 * @return Redirect
	 */
	public function postForgotPasswordConfirm($passwordResetCode = null)
	{
		// Declare the rules for the form validation
		$rules = array(
			'password'         => 'required',
			'password_confirm' => 'required|same:password'
		);

		// Create a new validator instance from our dynamic rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::route('forgot-password-confirm', $passwordResetCode)->withInput()->withErrors($validator);
		}

		try
		{
			// Find the user using the password reset code
			$user = Sentinel::getUserRepository()->findByResetPasswordCode($passwordResetCode);

			// Attempt to reset the user password
			if ($user->attemptResetPassword($passwordResetCode, Input::get('password')))
			{
				// Password successfully reseted
				return Redirect::route('signin')->with('success', Lang::get('kit::auth/message.forgot-password-confirm.success'));
			}
			else
			{
				// Ooops.. something went wrong
				return Redirect::route('signin')->with('error', Lang::get('kit::auth/message.forgot-password-confirm.error'));
			}
		}
		catch (\Cartalyst\Sentinel\Users\UserNotFoundException $e)
		{
			// Redirect to the forgot password page
			return Redirect::route('forgot-password')->with('error', Lang::get('kit::auth/message.account_not_found'));
		}
	}

	/**
	 * Logout page.
	 *
	 * @return Redirect
	 */
	public function getLogout()
	{
		// Log the user out
		Sentinel::logout();

		// Redirect to the users page
		return Redirect::to('/')->with('success', 'You have successfully logged out!');
	}

}

<?php namespace Kit\Http\Controllers\Account;

use Kit\Http\Controllers\AuthorizedController;
use Input;
use Redirect;
use Sentinel;
use Validator;
use View;

class ChangeEmailController extends AuthorizedController {

	/**
	 * User change email page.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Get the user information
		$user = Sentinel::getUser();

		// Show the page
		return View::make('kit::frontend.account.change-email', compact('user'));
	}

	/**
	 * Users change email form processing page.
	 *
	 * @return Redirect
	 */
	public function postIndex()
	{
		// Declare the rules for the form validation
		$rules = array(
			'current_password' => 'required|between:3,32',
			'email'            => 'required|email|unique:users,email,'.Sentinel::getUser()->email.',email',
			'email_confirm'    => 'required|same:email',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		// Grab the user
		$user = Sentinel::getUser();

		// Check the user current password
		if ( ! Sentinel::validateCredentials($user, ['password' => Input::get('current_password')]))
		{
			// Set the error message
			$this->messageBag->add('current_password', 'Your current password is incorrect');

			// Redirect to the change email page
			return Redirect::route('change-email')->withErrors($this->messageBag);
		}

		// Update the user email
		Sentinel::update($user, ['email' => Input::get('email')]);

		// Redirect to the settings page
		return Redirect::route('change-email')->with('success', 'Email successfully updated');
	}

}

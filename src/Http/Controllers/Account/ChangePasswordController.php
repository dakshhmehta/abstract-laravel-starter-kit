<?php namespace Kit\Http\Controllers\Account;

use Kit\Http\Controllers\AuthorizedController;
use Input;
use Redirect;
use Sentinel;
use Validator;
use View;

class ChangePasswordController extends AuthorizedController {

	/**
	 * User change password page.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Get the user information
		$user = Sentinel::getUser();

		// Show the page
		return View::make('kit::frontend.account.change-password', compact('user'));
	}

	/**
	 * User change password form processing page.
	 *
	 * @return Redirect
	 */
	protected function postIndex()
	{
		// Declare the rules for the form validation
		$rules = array(
			'old_password'     => 'required|between:3,32',
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

		// Grab the user
		$user = Sentinel::getUser();

		// Check the user current password
		if ( ! Sentinel::validateCredentials($user, ['password' => Input::get('old_password')]))
		{
			// Set the error message
			$this->messageBag->add('old_password', 'Your current password is incorrect.');

			// Redirect to the change password page
			return Redirect::route('change-password')->withErrors($this->messageBag);
		}

		// Update the user password
		Sentinel::update($user, ['password' => Input::get('password')]);

		// Redirect to the change-password page
		return Redirect::route('change-password')->with('success', 'Password successfully updated');
	}

}

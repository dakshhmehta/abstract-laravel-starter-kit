<?php namespace Kit\Http\Controllers;

use Illuminate\Routing\Controller;
use Validator;
use View;
use Redirect;
use Input;

class ContactUsController extends Controller {

	/**
	 * Contact us page.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		return View::make('kit::frontend.contact-us');
	}

	/**
	 * Contact us form processing page.
	 *
	 * @return Redirect
	 */
	public function postIndex()
	{
		// Declare the rules for the form validation
		$rules = array(
			'name'        => 'required',
			'email'       => 'required|email',
			'description' => 'required',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			return Redirect::route('contact-us')->withErrors($validator)->withInput();
		}

		# TODO !
	}

}

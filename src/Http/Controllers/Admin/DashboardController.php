<?php namespace Kit\Http\Controllers\Admin;

use Kit\Http\Controllers\AdminController;
use View;

class DashboardController extends AdminController {

	/**
	 * Show the administration dashboard page.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Show the page
		return View::make('kit::backend.dashboard');
	}

}

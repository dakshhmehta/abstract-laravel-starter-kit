<?php namespace Kit\Models;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Users\EloquentUser as SentinelUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends SentinelUserModel {

	use SoftDeletes;

    protected $dates = ['deleted_at'];

	/**
	 * Returns the user full name, it simply concatenates
	 * the user first and last name.
	 *
	 * @return string
	 */
	public function fullName()
	{
		return "{$this->first_name} {$this->last_name}";
	}

	/**
	 * Returns the user Gravatar image url.
	 *
	 * @return string
	 */
	public function gravatar()
	{
		// Generate the Gravatar hash
		$gravatar = md5(strtolower(trim($this->gravatar)));

		// Return the Gravatar url
		return "//gravatar.org/avatar/{$gravatar}";
	}

	public function isActivated(){
		return Activation::completed($this);
	}

}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class KitDatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('PostsSeeder');
		$this->call('CommentsSeeder');
	}

}

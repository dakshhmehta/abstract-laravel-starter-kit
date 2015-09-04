<?php

namespace Kit\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Kit\Http\Controllers\CRUDController;
use Kit\Models\Task;

class TasksController extends CRUDController {
	public function __construct(Task $model)
	{
		parent::__construct($model);
	}
}
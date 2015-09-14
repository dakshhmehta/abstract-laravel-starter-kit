<?php

namespace Kit\Http\Controllers\Admin;

use App\User;
use Form;
use Illuminate\Http\Request;
use Kit\Http\Controllers\CRUDController;
use Sentinel;

class TasksController extends CRUDController
{
    public function __construct(Task $model)
    {
        parent::__construct($model);

        $this->setForm([
            'groups' => [
                'General' => [
                    [
                        'name' => 'title',
                        'label' => 'Title',
                        'rules' => 'required',
                    ],
                    [
                        'name' => 'user_id',
                        'label' => 'User',
                        'field' => Form::dropdown('user_id', User::all()->lists('first_name', 'id'), $request->get('user_id', '{value}')),
                        'mode' => ['create']
                    ]
                ]
            ]
        ]);

        $this->tableColumns = ['title', 'user_id'];
    }
}

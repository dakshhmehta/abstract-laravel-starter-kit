<?php

namespace Kit\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use View;
use App;
use Illuminate\Validation\Factory as Validator;
use Illuminate\Routing\Redirector;
use URL;

class CRUDController extends BaseController
{
    /**
     * Request Object
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * Support to create operation
     * @var boolean
     */
    protected $create = true;

    /**
     * Form Holder
     * @var string
     */
    private $form = [];

    /**
     * List of columns to be displayed in the table
     * @var array
     */
    protected $tableColumns = [];

    /**
     * Support to edit operation
     * @var boolean
     */
    protected $edit = true;

    /**
     * Support to delete operation
     * @var boolean
     */
    protected $delete = true;

    /**
     * Entity Model
     * @var Illuminate\Database\Eloquent\Model
     */
    private $model = null;

    /**
     * Base path of all views
     * @var null
     */
    protected $viewPath = null;

    /**
     * A friendly name to folder
     * @var [type]
     */
    private $folder;

    public function __construct(Model $model)
    {
        parent::__construct();

        $this->model = $model;

        $this->folder = strtolower(str_plural(last(array_slice(explode('\\', get_class($this->model)), 0))));
        $this->viewPath = 'kit::'.$this->folder;
    }

    /**
     * Displays all the items
     */
    public function getIndex()
    {
        $items = $this->model->get();

        return $this->render('index', compact('items'))->with('columns', $this->tableColumns);
    }

    /**
     * Display the create form
     */
    public function getCreate()
    {
        if ($this->resolve($this->create) !== true) {
            abort(404);
        }

        $item = $this->model->newInstance();
        $mode = 'create';

        return $this->render('form', compact('item', 'mode'))->with('form', $this->getForm($mode));
    }

    /**
     * Saves the form and create a new entry in the database
     */
    public function postCreate(Validator $validator, Redirector $redirect, Request $request)
    {
        $rules = $this->getValidationRules('create');

        $validator = $validator->make($request->all(), $rules);

        if ($validator->fails()) {
            return $redirect->back()->withErrors($validator->errors());
        }

        $item = $this->model->newInstance();

        foreach ($rules as $field => $rules) {
            $item[$field] = $request->get($field);
        }

        if ($item->save()) {
            return $redirect->back()->withSuccess('Item has been saved.');
        }
    }

    /**
     * Display the edit form
     */
    public function getEdit($id)
    {
        if ($this->resolve($this->edit) !== true) {
            abort(404);
        }

        $item = $this->model->findOrFail($id);
        $mode = 'edit';

        return $this->render('form', compact('item', 'mode'))->with('form', $this->getForm($mode));
    }

    /**
     * Save the form and update the existing entry in the database
     */
    public function postEdit($id, Validator $validator, Redirector $redirect, Request $request)
    {
        $rules = $this->getValidationRules('edit');

        $validator = $validator->make($request->all(), $rules);

        if ($validator->fails()) {
            return $redirect->back()->withErrors($validator->errors());
        }

        $item = $this->model->findOrFail($id);

        foreach ($rules as $field => $rules) {
            $item[$field] = $request->get($field);
        }

        if ($item->save()) {
            return $redirect->back()->withSuccess('Item has been saved.');
        }
    }

    /**
     * Delete the entry from the fbsql_database(link_identifier)
     */
    public function getDelete($id, Redirector $redirect)
    {
        if ($this->model->destroy($id)) {
            return $redirect->back()->withSuccess('Item has been deleted successfully');
        }

        abort(500);
    }

    /**
     * Renders the view. This method first checks for
     * controller specific folder if available and
     * created by the designer, otherwise, It uses
     * default CRUD layout.
     *
     * @param  string $path Path of view
     * @param  array  $data Data to be sent to View
     * @return string       Parsed view to the browser
     */
    protected function render($path, $data = array())
    {
        if (! View::exists($this->viewPath.'.'.$path)) {
            $this->viewPath = 'kit::crud';
        }

        $data['slug'] = $this->folder;

        return View::make($this->viewPath.'.'.$path, $data);
    }

    /**
     * Resolve the variable if is invokable Closure
     * @param  mixed $handler Anything to check and resolve
     * @return mixed          Value after resolving the input
     */
    private function resolve($handler)
    {
        if ($handler instanceof Closure) {
            return call_user_func($handler);
        }

        return $handler;
    }

    /**
     * Set the form for rendering
     * @param array $form Form array which is compatible with dakshhmehta/helpers
     */
    public function setForm($form)
    {
        $this->form = $form;
    }

    /**
     * Return the form for specific mode after scanning and filtering
     * @param  [type] $mode [description]
     * @return [type]       [description]
     */
    public function getForm($mode)
    {
        foreach ($this->form['groups'] as $group => $fields) {
            $i = 0;
            foreach ($fields as $field) {
                if (isset($field['mode'])) {
                    if (! in_array($mode, $this->resolve($field['mode']))) {
                        unset($this->form['groups'][$group][$i]);
                    }
                }
                $i++;
            }
        }

        return $this->form;
    }

    protected function getValidationRules($mode)
    {
        $rules = [];

        foreach ($this->getForm($mode)['groups'] as $group => $fields) {
            foreach ($fields as $field) {
                $rules[$field['name']] = (isset($field['rules'])) ? $field['rules'] : '';
            }
        }

        return $rules;
    }
}

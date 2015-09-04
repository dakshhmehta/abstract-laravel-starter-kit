<?php

namespace Kit\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use View;
use App;

class CRUDController extends BaseController {
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
	protected $model = null;

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

		$this->request = App::make('Request');
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

		return $this->render('index', $items);
	}

	/**
	 * Displays the create form
	 */
	public function getCreate()
	{
		if($this->resolve($this->create) !== true)
		{
			abort(404);
		}

		$item = $this->model->newInstance();

		return $this->render('form', compact('item'));
	}

	/**
	 * Displays the create form
	 */
	public function getEdit($id)
	{
		if($this->resolve($this->edit) !== true)
		{
			abort(404);
		}

		$item = $this->model->findOrFail($id);

		return $this->render('form', compact('item'));
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
		if(! View::exists($this->viewPath.'.'.$path))
		{
			$this->viewPath = 'kit::crud';
		}

		$data['slug'] = $this->folder;

		return View::make($this->viewPath.'.'.$path, $data);		
	}

	private function resolve($handler){
		if($handler instanceof Closure)
			return call_user_func($handler);

		return $handler;
	}
}
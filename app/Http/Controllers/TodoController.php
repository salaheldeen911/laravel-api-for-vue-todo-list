<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Http\Requests\StoreTodoRequest;
use App\Services\TodoService as ServicesTodoService;
use Illuminate\Support\Facades\Gate;

class TodoController extends Controller
{
  protected $service;

  /**
   * Constructs a new cart object.
   *
   * @param Illuminate\Session\SessionManager $session
   */
  public function __construct(ServicesTodoService $service)
  {
    $this->service = $service;
    $this->authorizeResource(Todo::class, 'todo');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return $this->service->getTodos();
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StoreTodoRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreTodoRequest $request)
  {
    return $this->service->storeTodo($request);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Models\Todo  $todo
   * @return \Illuminate\Http\Response
   */
  public function done(Todo $todo)
  {
    return $this->service->doneTodo($todo);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\StoreTodoRequest  $request
   * @param  \App\Models\Todo  $todo
   * @return \Illuminate\Http\Response
   */
  public function update(StoreTodoRequest $request, Todo $todo)
  {
    if (!Gate::allows('update-todo', $todo)) {
      abort(403, "Unauthorize");
      return false;
    }
    return $this->service->updateTodo($request, $todo);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Todo  $todo
   * @return \Illuminate\Http\Response
   */
  public function destroy(Todo $todo)
  {
    if (!Gate::allows('delete-todo', $todo)) {
      abort(403, "Unauthorize");
      return false;
    }
    return $this->service->destroyTodo($todo);
  }

  /**
   * Remove allresource from storage.
   *
   * @return \Illuminate\Http\Response
   */
  public function deleteAll()
  {
    return $this->service->deleteAllTodos();
  }
}

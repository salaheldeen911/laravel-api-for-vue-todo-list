<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Resources\TodoResource;
use Carbon\Carbon;

class TodoController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    try {
      $res = Todo::orderBy('id', 'ASC')->get();

      return response()->json(["data" => TodoResource::collection($res)]);
    } catch (\Exception $e) {

      return response()->json(["status" => "Not Good", "data" => $e->getMessage()]);
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StoreTodoRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreTodoRequest $request)
  {
    try {
      Todo::create([
        "body" => $request->body,
        "created_at" => Carbon::now()
      ]);

      return response()->json(["status" => "Created Successfuly", "data" => TodoResource::collection(Todo::orderBy('id', 'ASC')->get())]);
    } catch (\Exception $e) {

      return response()->json(["status" => "Not Good", "data" => $e->getMessage()]);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Models\Todo  $todo
   * @return \Illuminate\Http\Response
   */
  public function done(Todo $todo)
  {
    try {
      $todo->update([
        "done" => !$todo->done
      ]);

      return response()->json(["status" => "Done Successfuly", "data" => new TodoResource(Todo::find($todo->id))]);
    } catch (\Exception $e) {

      return response()->json(["status" => "Not Good", "data" => $e->getMessage()]);
    }
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
    try {
      $todo->update([
        "body" => $request->body,
        "updated_at" => Carbon::now()
      ]);

      return response()->json(["status" => "Done Successfuly", "data" => new TodoResource(Todo::find($todo->id))]);
    } catch (\Exception $e) {

      return response()->json(["status" => "Not Good", "data" => $e->getMessage()]);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Todo  $todo
   * @return \Illuminate\Http\Response
   */
  public function destroy(Todo $todo)
  {
    try {
      $todo->delete();

      return response()->json(["status" => "Deleted Successfuly", "data" => TodoResource::collection(Todo::orderBy('id', 'ASC')->get())]);
    } catch (\Exception $e) {

      return response()->json(["status" => "Not Good", "data" => $e->getMessage()]);
    }
  }

  /**
   * Remove allresource from storage.
   *
   * @return \Illuminate\Http\Response
   */
  public function deleteAll()
  {
    try {
      Todo::truncate();

      return response()->json(["status" => "All Have been Deleted Successfuly", "data" => TodoResource::collection(Todo::orderBy('id', 'ASC')->get())]);
    } catch (\Exception $e) {

      return response()->json(["status" => "Not Good", "data" => $e->getMessage()]);
    }
  }
}

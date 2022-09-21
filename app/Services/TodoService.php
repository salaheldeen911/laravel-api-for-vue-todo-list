<?php

namespace App\Services;

use App\Http\Resources\TodoResource;
use App\Models\Todo;

class TodoService
{
    public function getTodos()
    {
        try {
            $res = Todo::userTodos()->get();

            return response()->json(["status" => true, "data" => TodoResource::collection($res)]);
        } catch (\Exception $e) {

            return response()->json(["status" => false, "message" => "some error occurred"]);
        }
    }

    public function storeTodo($request)
    {
        try {
            Todo::create([
                "body" => $request->body,
                "user_id" => auth()->user()->id
            ]);

            return response()->json(["status" => true]);
        } catch (\Exception $e) {

            return response()->json(["status" => false, "message" => "some error occurred"]);
        }
    }

    public function doneTodo($todo)
    {
        try {
            $todo->update([
                "done" => !$todo->done
            ]);

            return response()->json(["status" => true]);
        } catch (\Exception $e) {

            return response()->json(["status" => false, "message" => "some error occurred"]);
        }
    }

    public function updateTodo($request, $todo)
    {
        try {
            $todo->update([
                "body" => $request->body,
            ]);

            return response()->json(["status" => true, "data" => new TodoResource($todo)]);
        } catch (\Exception $e) {

            return response()->json(["status" => false, "message" => "some error occurred"]);
        }
    }

    public function destroyTodo($todo)
    {
        try {
            $todo->delete();

            return response()->json(["status" => true]);
        } catch (\Exception $e) {

            return response()->json(["status" => false, "message" => "some error occurred"]);
        }
    }

    public function deleteAllTodos()
    {
        try {
            Todo::userTodos()->delete();

            return response()->json(["status" => true]);
        } catch (\Exception $e) {

            return response()->json(["status" => false, "message" => "some error occurred"]);
        }
    }
}

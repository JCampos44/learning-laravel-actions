<?php

namespace App\Http\Controllers\V1;

use App\Enums\V1\TodoStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Todo\CreateTodoRequest;
use App\Http\Resources\V1\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Create a new todo for the authenticated user.
     *
     * Stores a new todo owned by the currently authenticated user. If `status`
     * is not provided, the todo is created with the default `pending` status.
     *
     * @group Todos
     *
     * @header Authorization string required Bearer token. Example: "Bearer {token}"
     *
     * @bodyParam title string required The todo title. Maximum 255 characters. Example: "Buy groceries"
     * @bodyParam description string nullable Optional details about the todo. Example: "Milk, bread, eggs, and coffee"
     * @bodyParam status string optional The todo status. Allowed values: `pending`, `completed`. Defaults to `pending`. Example: "pending"
     * @bodyParam completed_at string nullable Completion date in a valid datetime format. Example: "2026-04-10 15:30:00"
     *
     * @response 201 {
     *  "data": {
     *    "id": 1,
     *    "user_id": 1,
     *    "title": "Buy groceries",
     *    "description": "Milk, bread, eggs, and coffee",
     *    "status": "pending",
     *    "completed_at": null,
     *    "created_at": "2026-04-10T15:30:00.000000Z",
     *    "updated_at": "2026-04-10T15:30:00.000000Z"
     *  }
     * }
     * @response 401 {
     *  "message": "Unauthenticated."
     * }
     * @response 422 {
     *  "message": "The given data was invalid.",
     *  "errors": {
     *    "title": [
     *      "The title field is required."
     *    ]
     *  }
     * }
     */
    public function store(CreateTodoRequest $request)
    {
        $validated = $request->validated();

        $todo = Todo::create([
            'user_id' => auth()->user()->id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'] ?? TodoStatus::Pending,
            'completed_at' => $validated['completed_at'] ?? null,
        ]);

        return (new TodoResource($todo))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\TaskRequest; // Create a request class for validation
use App\Http\Resources\TaskResource;
use App\Models\Task;
use OpenApi\Annotations as OA;

use Illuminate\Http\Request;


/**
 * @OA\Info(
 *     title="Task Management API",
 *     version="1.0.0",
 *     description="API for managing tasks",
 *     @OA\Contact(
 *         email="your-email@example.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * 
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API server"
 * )
 */

/**
 * @OA\Schema(
 *     schema="Task",
 *     type="object",
 *     title="Task",
 *     required={"title"},
 *     @OA\Property(property="id", type="integer", description="Task ID"),
 *     @OA\Property(property="title", type="string", description="Task Title"),
 *     @OA\Property(property="description", type="string", description="Task Description"),
 *     @OA\Property(property="due_date", type="string", format="date", description="Task Due Date"),
 *     @OA\Property(property="assigned_user", type="integer", description="User ID assigned to task"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Created at"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Updated at")
 * )
 */


class TaskController extends Controller
{
    


    /**
     * @OA\Get(
     *     path="/api/tasks2",
     *     tags={"Tasks"},
     *     summary="Get all tasks",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of tasks",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Task"))
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */

     public function index()
    {
        $tasks = Task::with('user')->get();
        return TaskResource::collection($tasks);
    }

    /**
     * @OA\Get(
     *     path="/api/tasks2/{id}",
     *     tags={"Tasks"},
     *     summary="Get a task by ID",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Task details",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(response=404, description="Task not found"),
     * )
     */
    public function show(Task $task)
    {
        return new TaskResource($task->load('user'));
    }


    /**
     * @OA\Post(
     *     path="/api/tasks2",
     *     tags={"Tasks"},
     *     summary="Create a new task",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="due_date", type="string", format="date"),
     *             @OA\Property(property="assigned_user", type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Task created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     */

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $task = Task::create($request->only(['title', 'description', 'due_date', 'assigned_user']));

        return new TaskResource($task);
    }


    /**
     * @OA\Put(
     *     path="/api/tasks2/{id}",
     *     tags={"Tasks"},
     *     summary="Update a task",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="due_date", type="string", format="date"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(response=404, description="Task not found"),
     * )
     */

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $task->update($request->only(['title', 'description', 'due_date']));

        return new TaskResource($task);
    }


    /**
     * @OA\Delete(
     *     path="/api/tasks2/{id}",
     *     tags={"Tasks"},
     *     summary="Delete a task",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Task deleted successfully"),
     *     @OA\Response(response=404, description="Task not found"),
     * )
     */
    public function destroy(Task $task)
    {
        Gate::authorize('delete-task', $task);
        $task->delete();

        return response()->json(null, 204); // No content response
    }
}
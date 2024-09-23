<?php 
namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Logging\CustomLogger;
use App\Events\EventManager;

class TaskController extends Controller
{
    protected $logger;
    protected $eventManager;

    public function __construct(CustomLogger $logger, EventManager $eventManager)
    {
        $this->logger = $logger;
        $this->eventManager = $eventManager;
    }
    // Display a listing of the tasks.
    public function index()
    {
        $taskquery = Task::with('user');
        $user = Auth::user();
        if (!$user->hasRole('admin')) {
            $taskquery->where('assigned_user', $user->id);
        }
        $tasks = $taskquery->get();

        return Inertia::render('Tasks/Index', ['tasks' => $tasks]);
    }

    // Show the form for creating a new task.
    public function create()
    {
        Gate::authorize('assign-task'); // Check if user can assign tasks
        $users = User::all(); 
        return Inertia::render('Tasks/Create', ['users' => $users]);
    }

    // Store a newly created task in the database.
    public function store(Request $request)
    {
       // $this->authorize('create', $task);
       Gate::authorize('assign-task'); // Check if user can assign tasks

        $request->validate([
 
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'due_date' => $request->input('due_date'),
            'assigned_user'=> $request->input('assigned_user'),
        ]);

        $this->logger->log('Task has been created.');

        // Trigger an event
        return redirect()->intended(route('tasks.list'));
    }

    // Show the form for editing the specified task.
    public function edit(Task $task)
    {
        Gate::authorize('update-task', $task); // Check if user can update the task

        return Inertia::render('Tasks/Edit', ['task' => $task]);
    }

    // Update the specified task in the database.
    public function update(Request $request, Task $task)
    {
       // $this->authorize('update', $task);
       Gate::authorize('update-task', $task); // Check if user can update the task

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $task->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'due_date' => $request->input('due_date'),
            'assigned_user'=> $request->input('assigned_user'),
        ]);

        return back()->with("success", 'Task Updated');
    }

    // Remove the specified task from the database.
    public function destroy(Task $task)
    {
        Gate::authorize('delete-task'); // Check if user can delete the task

        // if (Gate::allows('is-admin')) {
        //     // The user is an admin
        // } else {
        //     // The user is not an admin
        // }
        
        // $this->authorize('delete', $task);
        $task->delete();
        return back()->with('success', 'Task deleted successfully.');
    }


}

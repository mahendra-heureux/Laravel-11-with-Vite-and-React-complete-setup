<?php 
namespace App\Http\Controllers;

use App\Models\Task;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Logging\CustomLogger;
use App\Events\EventManager;

class DashboardController extends Controller
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
        // $tasks = Task::with('user')->get(); 
        $taskquery = Task::with('user');
        $user = Auth::user();
        if (!$user->hasRole('admin')) {
            $taskquery->where('assigned_user', $user->id);
        }
        $tasks = $taskquery->get();
        // Retrieve all tasks
        //$tasks = Task::with('users')->get(); // Retrieve all tasks
        // var_dump($tasks);
        return Inertia::render('Dashboard', ['tasks' => $tasks]);
    }
}
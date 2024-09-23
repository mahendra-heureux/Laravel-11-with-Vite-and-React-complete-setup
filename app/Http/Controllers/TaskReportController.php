<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Logging\CustomLogger;
use App\Events\EventManager;


class TaskReportController extends Controller
{
    public function tasksreport()
    {
        $tasks = Task::all();
    
        // Create a CSV file in memory
        $csvFileName = 'tasks_report.csv';
        $handle = fopen('php://memory', 'w');
    
        // Add the header of the CSV file
        fputcsv($handle, ['ID', 'Title', 'Description', 'Created At', 'Updated At']);
    
        // Add the data of the CSV file
        foreach ($tasks as $task) {
            fputcsv($handle, [
                $task->id,
                $task->title,
                $task->description,
                $task->created_at,
                $task->updated_at
            ]);
        }
    
        // Move back to the beginning of the file
        fseek($handle, 0);
    
        // Set headers to download the file rather than display it
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];
    
        // Return the CSV file as a response
        return response()->stream(function() use ($handle) {
            fpassthru($handle);
            fclose($handle); // Ensure the handle is closed after streaming
        }, 200, $headers);
    }
    
}

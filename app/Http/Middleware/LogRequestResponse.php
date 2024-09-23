<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequestResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Log the request
        $startTime = microtime(true);
        $userId = $request->user() ? $request->user()->id : 'guest';
        Log::info('Request:', [
            'time' => now(),
            'user_id' => $userId,
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'request' => $request->all(),
        ]);

        $response = $next($request);

        $status = $response->getStatusCode(); // Get the status code
        $status = $status ?? 200; // Default to 200 if not set
        // Log the response
        Log::info('Response:', [
            'time' => now(),
            'user_id' => $userId,
            'status' => $status,
            'response' => $response->getContent(),
            'duration' => microtime(true) - $startTime,
        ]);

        return $response;
    }
}

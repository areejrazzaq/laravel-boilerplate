<?php
// app/Http/Middleware/LoggerMiddleware.php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;

class LoggerMiddleware
{
    /**
     * Handle an incoming request.
     * Save log in the activity log table
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $contents = json_decode($response->getContent(), true, 512);
        $headers = $request->header();

        $data = [
            'path' => $request->getPathInfo(),
            'method' => $request->getMethod(),
            'ip' => $request->ip(),
            'http_version' => $_SERVER['SERVER_PROTOCOL'],
            'headers' => json_encode([
                // get all the required headers to log
                'user-agent' => $headers['user-agent'],
                'referer' => isset($headers['referer']) ? $headers['referer'] : null,
                'origin' => isset($headers['origin']) ? $headers['origin'] : null,
            ]),
        ];

        // if request if authenticated
        if ($request->user()) {
            $data['user_id'] = $request->user()->id;
        }

        // if you want to log all the request body
        if (count($request->all()) > 0) {
            // keys to skip like password or any sensitive information
            $hiddenKeys = ['password'];

            $data['request'] = json_encode($request->except($hiddenKeys));
        }

        if(!empty($contents)){
            $data['response'] = json_encode($contents);
        }

        // a unique message to log, I prefer to save the path of request for easy debug
        $message = str_replace('/', '_', trim($request->getPathInfo(), '/'));

        // log the gathered information
        ActivityLog::create($data);

        // return the response
        return $response;
    }
}

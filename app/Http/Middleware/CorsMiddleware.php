<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
     // Handle preflight requests
        // if ($request->isMethod('options')) {
        //     return response()->json('OK', 200)
        //         ->header('Access-Control-Allow-Origin', '*') // Use specific origin if possible
        //         ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        //         ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Socket-ID') // Add any other required headers here
        //         ->header('Access-Control-Allow-Credentials', 'true'); // Adjust according to your needs
        // }

        $response = $next($request);

        //Ensure the header is set only once
        if (!$response->headers->has('Access-Control-Allow-Origin')) {
            $response->headers->set('Access-Control-Allow-Origin', '*'); // Use specific origin if possible
        }

        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Socket-ID'); // Include custom headers
        $response->headers->set('Access-Control-Allow-Credentials', 'true'); // Adjust according to your needs

        return $response;
  }
}

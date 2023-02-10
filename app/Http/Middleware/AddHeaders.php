<?php namespace App\Http\Middleware;

use Closure;
// use Illuminate\Contracts\Routing\Middleware; 

// If Laravel >= 5.2 then delete 'use' and 'implements' of deprecated Middleware interface.
class AddHeaders{
    public function handle($request, Closure $next){
        $response = $next($request);
        $response->header('Access-Control-Allow-Origin', '*');

        return $response;
    }
}
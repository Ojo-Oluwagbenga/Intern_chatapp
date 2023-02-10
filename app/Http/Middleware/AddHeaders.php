<?php 
namespace App\Http\Middleware;
use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Applicaion;


class AddHeaders 
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Access-Control-Allow-Headers', 'Access-Control-Allow-Origin, Access-Control-Allow-Headers, Content-Type, Authorization, X-CSRF-TOKEN, Cache-Control, Pragma');
        $response->header('Access-Control-Allow-Methods', '*');
        // $response->header("Content-Type", "application/json");
        //$response->header('another header', 'another value');

        return $response;
    }
}
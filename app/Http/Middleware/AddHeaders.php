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
        //$response->header('another header', 'another value');

        return $response;
    }
}
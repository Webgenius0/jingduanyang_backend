<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Doctor
{
    use ApiResponse;
    
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if(auth()->user()->role == "doctor") {
            return $next($request);
        } else {
            return $this->error([], 'Only Doctor Can Access This API', 401);
        }
        
    }
}

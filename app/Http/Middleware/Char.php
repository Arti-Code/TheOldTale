<?php

namespace App\Http\Middleware;

use Closure;

class Char
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
        if(session('char_id') == null)
        {
            return redirect('home');
        }
        return $next($request);
    }
}

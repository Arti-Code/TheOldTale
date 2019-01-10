<?php

namespace App\Http\Middleware;

use Closure;
use App\Character;
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
        $char = Character::find(session('char_id'));
        if( !$char->dead )
            return $next($request);
        else
            return redirect()->route('character.index')->with('danger', 'Wybrana postac nie żyje...');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class HasInstructorProfile
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
        $user = $request->user();
        if($user->instructor != null){
            return $next($request);
        }
        else{
            return redirect()->route('instructor_create_get');
        }
    }
}

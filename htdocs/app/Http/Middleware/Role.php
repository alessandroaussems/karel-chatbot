<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Role
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $roles = array_slice(func_get_args(), 2);
        $user = Auth::user();
        foreach ($roles as $role)
        {
            // Check if user has the role
            if($user->hasRole($role))
            {
                return $next($request);
            }
        }
        return abort(403);
    }
}

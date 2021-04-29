<?php

namespace App\Http\Middleware;

use App\Utils\CommonUtils;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class checkLockedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check())
        {
            $user = Auth::user();
            if ($user->lock_status == CommonUtils::is_not_active )
            {
                return response()->json(['message' => 'ER0008'], 423);
            }
        }

        return $next($request);
    }
}

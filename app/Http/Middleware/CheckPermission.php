<?php

namespace App\Http\Middleware;

use App\Exceptions\UnsecureException;
use Closure;
use Illuminate\Http\Request;

class CheckPermission
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
        if (getActionName() === "applystatus") {
            if (!checkaccess('isactive', getControllerName()) || !checkaccess('delete', getControllerName())) {
                throw new UnsecureException('The requested page does not permission access.');
            }
        } else {
            if (!checkaccess(getActionName(), getControllerName())) {
                throw new UnsecureException('The requested page does not permission access.');
            }
        }

        return $next($request);
    }
}

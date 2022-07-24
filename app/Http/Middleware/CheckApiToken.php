<?php

namespace App\Http\Middleware;

use App\Models\Api\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class CheckApiToken
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
        // if(!in_array($request->headers->get('accept'), ['application/json', 'Application/Json']))
        // return response()->json(['message' => 'Unauthenticated.'], 401);
        if (empty(trim($request->input('action')))) {
            return response()->json(['status' => 403, 'message' => 'Invalid action'], 403);
        }
        if ($request->headers->get('Authorization')) {
            if (!empty(trim($request->input('auth_key')))) {
                $is_exists = User::where('auth_key', $request->input('auth_key'))->exists();
                if ($is_exists) {
                    return $next($request);
                }
                return response()->json(['message' => 'Unauthenticated.'], 401);
            } else {
                try {
                    // $encryptBearerToken = Crypt::encryptString(config('app.guest_api_key'));
                    $encryptBearerToken = $request->bearerToken();
                    $decrypt = Crypt::decryptString($encryptBearerToken);
                    if ($decrypt === config('app.guest_api_key')) {
                        return $next($request);
                    }
                } catch (DecryptException $e) {
                    return response()->json(['status' => 403, 'message' => 'Invalid Token or Auth Key'], 403);
                }
            }
        } else {
            return response()->json(['status' => 403, 'message' => 'Authorization token required'], 403);
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $user;
    private $signed_in;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            global $user;
            $user = $this->user = Auth::user();
            $this->signed_in = Auth::check();
            $user = $this->user;
            view()->share('signed_in', $this->signed_in);
            view()->share('user', $this->user);

            return $next($request);
        });
    }
}

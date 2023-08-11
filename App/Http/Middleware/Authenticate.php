<?php

namespace App\Http\Middleware;

use App\Main\Helpers\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{

    protected function redirectTo($request)
    {

        if (! $request->expectsJson()) {
            return (new Response)->responseJsonFail("Not authenticated",Response:: HTTP_CODE_UNAUTHORIZED,);
        }

    }
}

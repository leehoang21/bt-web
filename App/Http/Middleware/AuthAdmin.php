<?php

namespace App\Http\Middleware;

use App\Main\Helpers\Response;
use App\Main\Repositories\AdminRepository;
use Closure;
use Illuminate\Http\Request;

class AuthAdmin
{

    public function handle(Request $request, Closure $next)
    {
        $adminRepository = new AdminRepository();

        $userName = auth()->user()->user_name;
        $user = $adminRepository->findOne('user_name', $userName);

        if (empty($user)) {

            return (new Response)->responseJsonFail("Not authenticated",Response:: HTTP_CODE_UNAUTHORIZED,);
        }
        if (! $request->expectsJson()) {

            return (new Response)->responseJsonFail("Not authenticated",Response:: HTTP_CODE_UNAUTHORIZED,);
        }
        return $next($request);
    }
}

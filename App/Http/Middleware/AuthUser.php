<?php

namespace App\Http\Middleware;

use App\Main\Helpers\Response;
use App\Main\Repositories\AdminRepository;
use App\Main\Repositories\UserRepository;
use Closure;
use Illuminate\Http\Request;

class AuthUser
{

    public function handle(Request $request, Closure $next)
    {
        $adminRepository = new UserRepository();

        $email = auth()->user()->email;
        $user = $adminRepository->findOne('email', $email);

        if (empty($user)) {

            return (new Response)->responseJsonFail("Not authenticated",Response:: HTTP_CODE_UNAUTHORIZED,);
        }

        return $next($request);
    }
}

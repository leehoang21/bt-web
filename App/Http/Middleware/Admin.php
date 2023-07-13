<?php

namespace App\Http\Middleware;

use App\Main\Repositories\AdminRepository;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Admin extends Middleware
{
    protected function redirectTo($request)

    {
        $adminRepository = new AdminRepository();
        $userName = $request['user_name'];
        $user = $adminRepository->findOne('user_name', $userName);

        if (empty($user)) {
            return route('login');
        }
        if (! $request->expectsJson()) {
            return route('login');

        }
    }
}

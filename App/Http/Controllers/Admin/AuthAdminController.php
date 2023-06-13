<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Main\Services\AuthService;
use Illuminate\Http\Request;

class AuthAdminController extends Controller
{
    protected $authService;

    public function __construct(
        AuthService $authService
    )
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {

        $userName = $request->user_name;
        $password = $request->password;

        return $this->authService->login($userName, $password);
    }


}

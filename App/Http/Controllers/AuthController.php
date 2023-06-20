<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\SendVerifyRequest;
use App\Http\Requests\VerifyEmailRequest;
use App\Main\Services\AuthService;
use App\Main\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;
    protected  UserService $userService;

    public function __construct(
        AuthService $authService,
        UserService $userService
    )
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    public function login(Request $request)
    {

        $email = $request->email;
        $password = $request->password;

        return $this->authService->loginUser($email, $password);
    }

    public function register(RegisterUserRequest $request)
    {
        $data = [
            'data' =>
                [
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password' => $request['password'],
                    'phone' => $request['phone'],
                ],

        ];
        return $this->userService->save($data);
    }

    public function sendVerify(SendVerifyRequest $request)
    {
        $email = $request->email;
        return $this->authService->sendOtp($email);
    }

    public function verify(Request $request)
    {
        $email = $request->email;
        $otp = $request->otp;
        return $this->authService->verify($email, $otp);
    }

    public function verifyEmail(VerifyEmailRequest $request)
    {
        $error = $this->verify($request);
        if (empty($error)) {
            return $this->authService->verifyEmail($request->email);
        } else {
            return $error;
        }
    }

    public function changePass(ChangePasswordRequest $request)
    {
        $error = $this->verify($request);
        if (empty($error)) {
            return $this->authService->changePass($request->email, $request->password);
        } else {
            return $error;
        }
    }


}

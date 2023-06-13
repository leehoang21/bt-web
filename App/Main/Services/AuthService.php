<?php

namespace App\Main\Services;

use App\Main\Helpers\Response;
use App\Main\Repositories\AdminRepository;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected AdminRepository $adminRepository;
    public function __construct(
        AdminRepository $adminRepository
    )
    {
        $this->adminRepository = $adminRepository;
    }

    public function login($userName, $password) {

        $user = $this->adminRepository->findOne('user_name', $userName);

        if(empty($user)) {
            return (new \App\Main\Helpers\Response)->responseJsonFail('User does not exist', Response::HTTP_CODE_UNAUTHORIZED);
        }
        if(!Hash::check($password, $user->password)) {
            return (new \App\Main\Helpers\Response)->responseJsonFail('Password incorrect', Response::HTTP_CODE_UNAUTHORIZED);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response(
            [
                'status' => Response::RESPONSE_STATUS_SUCCESS,
                'data' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]
            , Response::HTTP_CODE_SUCCESS);
    }
}

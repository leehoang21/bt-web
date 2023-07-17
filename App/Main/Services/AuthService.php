<?php

namespace App\Main\Services;

use App\Main\Helpers\Response;
use App\Main\Repositories\AdminRepository;
use App\Main\Repositories\OtpRepository;
use App\Main\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    protected AdminRepository $adminRepository;
    protected OtpRepository $otpRepository;
    protected  UserRepository $userRepository;

    public function __construct(
        AdminRepository $adminRepository,
        OtpRepository   $otpRepository,
        UserRepository $userRepository
    )
    {
        $this->adminRepository = $adminRepository;
        $this->otpRepository = $otpRepository;
        $this->userRepository = $userRepository;
    }

    public function login($userName, $password)
    {

        $user = $this->adminRepository->findOne('user_name', $userName);

        if (empty($user)) {
            return (new \App\Main\Helpers\Response)->responseJsonFail('User does not exist', Response::HTTP_CODE_UNAUTHORIZED);
        }
        if (!Hash::check($password, $user->password)) {
            return (new \App\Main\Helpers\Response)->responseJsonFail('Password incorrect', Response::HTTP_CODE_UNAUTHORIZED);
        }

        $token = $user->createToken('authToken')->plainTextToken;


        return response(
            [
                'status' => Response::RESPONSE_STATUS_SUCCESS,
                'data' => [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user'=>$user,

                ],

            ]
            , Response::HTTP_CODE_SUCCESS);
    }

    public function loginUser($email, $password)
    {

        $user = $this->userRepository->findOne('email', $email);

        if (empty($user)) {
            return (new \App\Main\Helpers\Response)->responseJsonFail('User does not exist', Response::HTTP_CODE_UNAUTHORIZED);
        }
        if (!Hash::check($password, $user->password)) {
            return (new \App\Main\Helpers\Response)->responseJsonFail('Password incorrect', Response::HTTP_CODE_UNAUTHORIZED);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response(
            [
                'status' => Response::RESPONSE_STATUS_SUCCESS,
                'data' => [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user'=>$user,

                ],

            ]
            , Response::HTTP_CODE_SUCCESS);
    }


    public function sendOtp($email)
    {
        $otp = $this->generateOtp();
        $data = [
            'email' => $email,
            'otp' => $otp,
            'is_used' => false
        ];
        $this->otpRepository->delete('email', $email);
        $this->otpRepository->create($data);

        Mail::raw((string)$otp, function ($message) use ($email) {
            $message->to($email)->subject('Verify OTP');

        });
        return (new \App\Main\Helpers\Response)->responseJsonSuccess('Send email success', Response::HTTP_CODE_SUCCESS);

    }

    public function verify($email, $_otp)
    {
        $otp = $this->otpRepository->findOneLast('email', $email);
        if (empty($otp)) {
            return (new \App\Main\Helpers\Response)->responseJsonFail('Email does not exist', Response::HTTP_CODE_UNAUTHORIZED);
        }
        if ($otp->is_used) {
            return (new \App\Main\Helpers\Response)->responseJsonFail('OTP has been used', Response::HTTP_CODE_UNAUTHORIZED);
        }
        if ($otp->created_at->addMinutes(5) < now()) {
            return (new \App\Main\Helpers\Response)->responseJsonFail('OTP has expired', Response::HTTP_CODE_UNAUTHORIZED);
        }

        if ($otp->otp != $_otp) {
            return (new \App\Main\Helpers\Response)->responseJsonFail('OTP incorrect', Response::HTTP_CODE_UNAUTHORIZED);
        }
        $otp->is_used = true;
        $otp->save();
        return '';
    }

    public function verifyEmail($email)
    {
        $user = $this->userRepository->findOne('email', $email);
        if (empty($user)) {
            return (new \App\Main\Helpers\Response)->responseJsonFail('Email does not exist', Response::HTTP_CODE_UNAUTHORIZED);
        }
        $user->status = 1;
        $user->save();
        return (new \App\Main\Helpers\Response)->responseJsonSuccess('Verify email success', Response::HTTP_CODE_SUCCESS);
    }

    public function changePass($email,$pass,$newPass)
    {
        $user = $this->userRepository->findOne('email', $email);
        if (empty($user)) {
            return (new \App\Main\Helpers\Response)->responseJsonFail('User does not exist', Response::HTTP_CODE_UNAUTHORIZED);
        }
        if (!Hash::check($pass, $user->password)) {
            return (new \App\Main\Helpers\Response)->responseJsonFail('Password incorrect', Response::HTTP_CODE_UNAUTHORIZED);
        }
        $user->password = Hash::make($newPass);
        $user->save();
        return (new \App\Main\Helpers\Response)->responseJsonSuccess('Change password success', Response::HTTP_CODE_SUCCESS);
    }

    private function generateOtp()
    {
        return rand(100000, 999999);
    }


}

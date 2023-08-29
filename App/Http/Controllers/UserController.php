<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserFormRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Main\Helpers\Common;
use App\Main\Services\UserService;
use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    protected  UserService $userService;


    public function __construct(
        UserService $userService,
    )
    {

        $this->userService = $userService;
    }


    public function store(UserUpdateRequest $request)
    {
        $password = Hash::make($request['password']);

        $data = [
            'data' =>
                [
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'phone' => $request['phone'],
                    'status'=>null,
                ],
            'id' => auth()->user()->id,
        ];

        return $this->userService->save($data);
    }

    public function show()
    {
        return $this->userService->getById(
            auth()->user()->id
        );
    }

}

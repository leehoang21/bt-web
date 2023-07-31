<?php

namespace App\Http\Controllers;
use App\Http\Requests\AddressFormRequest;
use App\Main\Services\AddressService;
use function PHPUnit\Framework\isEmpty;

class AddressController extends Controller
{
    protected  AddressService $userService;


    public function __construct(
        AddressService $userService,
    )
    {

        $this->userService = $userService;
    }


    public function store(AddressFormRequest $request)
    {
        $data = [
            'data' =>
                [
                    'address' => $request->address,
                    'id_user' => auth()->user()->id,
                ],

        ];

        return $this->userService->save($data);
    }

    public function update(AddressFormRequest $request)
    {
        $data = [
            'data' =>
                [
                    'address' => $request->address,
                    'id_user' => auth()->user()->id,
                ],
            'old_address' => "'".$request->old_address."'",
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

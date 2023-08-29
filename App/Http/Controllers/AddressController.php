<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressFormRequest;
use App\Main\Services\AddressService;
use function PHPUnit\Framework\isEmpty;

class AddressController extends Controller
{
    protected AddressService $userService;


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
                    'phone' => $request->phone,
                    'full_name' => $request['full_name'],

                ],

        ];

        return $this->userService->save($data);
    }

    public function index()
    {
        $idUser = auth()->user()->id;
        $data = [
            'id_user' => $idUser,
        ];
        return $this->userService->getAll($data);
    }

    public function update(AddressFormRequest $request, int $id)
    {

        $data = [
            'data' =>
                [
                    'address' => $request->address,
                    'id_user' => auth()->user()->id,
                    'phone' => $request->phone,
                    'full_name' => $request['full_name'],

                ],
            'id' => $id,
        ];

        return $this->userService->save($data);
    }

    public function show()
    {
        return $this->userService->getById(
            auth()->user()->id
        );
    }

    public function destroy($id)
    {
        $result = $this->userService->delete($id);
        return $result;
    }

}

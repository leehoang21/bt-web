<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Http\Requests\FavoriteRequest;
use App\Main\Services\FavoriteService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    protected FavoriteService $service;

    public function __construct(
        FavoriteService $service
    )
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $idUser = auth()->user()->id;
        $data = [
            'id_user' => $idUser,
        ];
        return $this->service->getAll($data);
    }

    public function destroy($id)
    {
        $favorite = [
            'id_user' => auth()->user()->id,
            'id_product' => $id,

        ];

        $result = $this->service->delete($favorite);
        return $result;
    }

    public function store(FavoriteRequest $request)
    {

        $cart = [
            'id_user' => auth()->user()->id,
            'id_product' => $request->id_product,

        ];

        return $this->service->save($cart);
    }

    public function update(FavoriteRequest $request, int $id)
    {

        $cart = [

        ];
        $data = [
            'data' => $cart,
            'id' => $id,

        ];
        return $this->service->save($data);
    }


}

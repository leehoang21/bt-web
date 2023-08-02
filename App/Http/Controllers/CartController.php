<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Main\Services\CartService;
use App\Main\Services\OrderService;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class CartController extends Controller
{
    protected CartService $service;

    public function __construct(
        CartService $service
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
        $result = $this->service->delete($id);
        return $result;
    }

    public function store(CartRequest $request)
    {

        $cart = [
            'id_user' => auth()->user()->id,
            'id_product' =>     $request->id_product,
            'quantity' => $request->total,
        ];
        $data = [
            'data' => $cart,

        ];
        return $this->service->save($data);
    }


}

<?php

namespace App\Http\Requests;

class CartRequest extends BaseRequest
{

    /**
     * Get the validation ac that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
                "id_product" => "required|exists:products,id",
                "total" =>  "required|integer",
        ];
    }

}

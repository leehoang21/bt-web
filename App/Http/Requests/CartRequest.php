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
        $id_product = $this->method() == 'POST' ? 'required|exists:products,id' : '';
        return [
                "id_product" => $id_product,
                "total" =>  "required|integer",
        ];
    }

}

<?php

namespace App\Http\Requests;
use Illuminate\Support\Str;

class CreateOderRequest extends BaseRequest
{

    /**
     * Get the validation ac that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'orders' => 'required|array',
            'orders.*.id_product' => 'required|integer',
            'orders.*.total' => 'required|integer',
            'address' => 'required|string',
        ];
    }

    public function messages()
    {
        return [

        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([



        ]);
    }
}

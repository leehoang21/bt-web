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
            'id_product' => 'required',
            'total' => 'required',
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

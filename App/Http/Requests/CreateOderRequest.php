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
            'products' => 'required|array',
            'array_total' => 'required|array',
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

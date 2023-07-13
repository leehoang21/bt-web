<?php

namespace App\Http\Requests;

class CreateOderAdminRequest extends BaseRequest
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
            'id_user' => 'id_user',
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

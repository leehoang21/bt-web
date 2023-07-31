<?php

namespace App\Http\Requests;
use Illuminate\Support\Str;

class AddressFormRequest extends BaseRequest
{

    /**
     * Get the validation ac that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $old_address = $this->method() == 'POST' ? 'nullable|string' : 'required|string';
        return [
            'address'=> 'required|string',
            'old_address' => $old_address,

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

            'slug' => Str::slug($this->slug),

        ]);
    }
}

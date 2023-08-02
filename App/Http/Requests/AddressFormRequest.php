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
        $address = $this->method() == 'POST' ? 'nullable|string' : 'required|string';
        $phone = $this->method() == 'POST' ? 'nullable|string' : 'required|string';
        $full_name = $this->method() == 'POST' ? 'nullable|string' : 'required|string';
        return [
            'address'=> $address,
            'phone' =>$phone,
            'full_name'=>$full_name,
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

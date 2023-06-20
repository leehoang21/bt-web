<?php

namespace App\Http\Requests;
use Illuminate\Support\Str;

class AdvisoryRequest extends BaseRequest
{

    /**
     * Get the validation ac that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'phone'=> 'required',
            'name' => 'required|string',
            'email' => 'required|email',
            'content' => 'required|string',
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

<?php

namespace App\Http\Requests;
use Illuminate\Support\Str;

class TagFormRequest extends BaseRequest
{

    /**
     * Get the validation ac that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $slug = $this->method() == 'POST' ? 'required|unique:tags,slug' : 'required';

        return [
           'slug' => $slug,
            'content' => 'required',
            'name' => 'required|string',

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

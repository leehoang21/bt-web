<?php

namespace App\Http\Requests;
use Illuminate\Support\Str;

class CategoryFormRequest extends BaseRequest
{

    /**
     * Get the validation ac that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $slug = $this->method() == 'POST' ? 'required|string|unique:categories' : 'required|string';

        return [
            'color' => 'required|string',
            'name' => 'required|string',
            'slug' => $slug,
            'images' => 'array',
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

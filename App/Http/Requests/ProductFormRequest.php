<?php

namespace App\Http\Requests;
use Illuminate\Support\Str;

class ProductFormRequest extends BaseRequest
{

    /**
     * Get the validation ac that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $slug = $this->method() == 'POST' ? 'required|unique:products,slug' : 'required';
        return [
            'slug' => $slug,
            'name' => 'required|string',
            'description' => 'required|string',
            'short_description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'id_category' => 'required|exists:categories,id|nullable',
            'images' => 'array',
            'tags' => 'array',
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

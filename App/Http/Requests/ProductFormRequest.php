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
        $slug = 'required|unique:products,slug';
        if($this->isMethod('put')){
            $id = $this->product;
            $slug .= ','.$id.',id';
        }
        return [
            'slug' => $slug,
            'name' => 'required|string',
            'description' => 'required|string',
            'short_description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id|nullable',
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

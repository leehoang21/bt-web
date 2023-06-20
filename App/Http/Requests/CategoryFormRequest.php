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
        $slug = 'required|unique:products,slug';
        if($this->isMethod('put')){
            $id = $this->product;
            $slug .= ','.$id.',id';
        }
        return [

            'name' => 'required|string',
            'slug' => $slug,
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

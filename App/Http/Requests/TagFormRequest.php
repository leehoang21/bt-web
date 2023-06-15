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
        $slug = 'required|unique:products,slug';
        if($this->isMethod('put')){
            $id = $this->product;
            $slug .= ','.$id.',id';
        }
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

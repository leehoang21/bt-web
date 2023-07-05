<?php

namespace App\Http\Requests;
use Illuminate\Support\Str;

class PostFormRequest extends BaseRequest
{

    /**
     * Get the validation ac that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $slug = $this->method() == 'POST' ? 'required|unique:posts,slug' : 'required';
        return [
            'slug' => $slug,
            'content' => 'required|string',
            'title' => 'required|string',
            'image' => 'array',
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

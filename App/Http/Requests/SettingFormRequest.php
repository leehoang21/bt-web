<?php

namespace App\Http\Requests;
use Illuminate\Support\Str;

class SettingFormRequest extends BaseRequest
{

    /**
     * Get the validation ac that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'type'=> 'required',
            'content' => 'required|string',
        ];
    }
}

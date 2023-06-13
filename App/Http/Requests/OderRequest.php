<?php

namespace App\Http\Requests;
use Illuminate\Support\Str;

class OderRequest extends BaseRequest
{

    /**
     * Get the validation ac that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $status = 'required,status';
        return [
            'status' => $status,
        ];
    }

}

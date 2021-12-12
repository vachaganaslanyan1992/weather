<?php

namespace App\Http\Requests\Weather;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'max:100',
            'lat' => 'max:20',
            'long' => 'max:20',
        ];
    }

    /**
     * @param $validator
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $code = $this->input('code');
            $lat = $this->input('lat');
            $long = $this->input('long');
            if ($validator->errors()->isEmpty() && empty($code) && (empty($lat) || empty($long))) {
                $validator->errors()->add('code', "Please select country");
            }
        });
    }
}

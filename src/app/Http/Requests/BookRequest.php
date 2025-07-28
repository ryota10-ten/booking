<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'date' => 'required',
            'time' => 'required',
            'headcount' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '予約日を入力してください',
            'time.required' => '予約時間を入力してください',
            'headcount.required' => '人数を入力してください'
        ];
    }
}

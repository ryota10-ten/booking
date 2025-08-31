<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

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
            'headcount' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '予約日を入力してください',
            'headcount.integer' => '人数は数字で入力してください',
            'time.required' => '予約時間を入力してください',
            'headcount.required' => '人数を入力してください',
            'headcount.min' => ':min人以上を指定してください',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $date = $this->input('date');
            $time = $this->input('time');

            if ($date && $time) {
                try {
                    $inputDateTime = Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $time);
                    $now = Carbon::now();

                    if ($inputDateTime->lt($now)) {
                        $validator->errors()->add('date', '過去の日時は指定できません');
                    }
                } catch (\Exception $e) {
                    $validator->errors()->add('date', '日時の形式が不正です');
                }
            }
        });
    }
}

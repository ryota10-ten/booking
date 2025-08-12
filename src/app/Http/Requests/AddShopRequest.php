<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddShopRequest extends FormRequest
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
            'name'     => 'required|string|max:255',
            'area_id'  => 'required|exists:areas,id',
            'genre_id' => 'required|exists:genres,id',
            'detail'   => 'required|string|max:1000',
            'image'    => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => '店舗名は必須です。',
            'area_id.required'  => '地域を選択してください。',
            'genre_id.required' => 'ジャンルを選択してください。',
            'detail.required'   => '店舗概要を入力してください。',
            'img.required'      => '画像を選択してください。',
            'image.image'       => '画像ファイルを選択してください。',
            'image.mimes'       => '画像は jpeg, png, jpg, gif のいずれかの形式でアップロードしてください。',
            'image.max'         => '画像は2MB以下でアップロードしてください。',
        ];
    }
}

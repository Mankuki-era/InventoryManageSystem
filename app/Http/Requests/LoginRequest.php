<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'number' => 'required|integer',
            'password' => 'required|min:8',
        ];
    }

    //[ *3.追加：Validationメッセージを設定（省略可） ]
    //function名は必ず「messages」となります。
    public function messages(){
        return [
            'number.required' => '職番を入力してください.',
            'number.integer'  => '職番は数字で入力してください.',
            'password.required'=> 'パスワードを入力してください.',
            'password.min'=> '8文字以上で入力してください.',
        ];
    }
}

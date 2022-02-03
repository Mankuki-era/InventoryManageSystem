<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformationRequest extends FormRequest
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
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    //[ *3.追加：Validationメッセージを設定（省略可） ]
    //function名は必ず「messages」となります。
    public function messages(){
        return [
            'current_password.required'=> '現在のパスワードを入力してください.',
            'password.required'=> '新規パスワードを入力してください.',
            'password.min'=> '8文字以上で入力してください.',
            'password.confirmed'=> 'パスワードが一致しません.',
            'password_confirmation.required'=> '確認用パスワードを入力してください.',
        ];
    }
}

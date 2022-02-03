<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'familyName' => 'required|string',
            'givenName' => 'required|string',
            'number' => 'required|integer|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
            'role' => 'required',
            'admin' => 'required',
        ];
    }

    //[ *3.追加：Validationメッセージを設定（省略可） ]
    //function名は必ず「messages」となります。
    public function messages(){
        return [
            'familyName.required'  => '苗字を入力してください.',
            'firstName.string'  => '文字を入力してください.',
            'givenName.required'   => '名前を入力してください.',
            'givenName.string'  => '文字を入力してください.',
            'number.required' => '職番を入力してください.',
            'number.integer'  => '職番は数字で入力してください.',
            'number.unique'  => '入力した職番は既に登録されています.',
            'email.required' => 'メールアドレスを入力してください.',
            'email.email'  => '有効なメールアドレスを入力してください.',
            'email.unique'  => '入力したメールアドレスは既に登録されています.',
            'password.required'=> 'パスワードを入力してください.',
            'password.min'=> '8文字以上で入力してください.',
            'password.confirmed'=> 'パスワードが一致しません.',
            'password_confirmation.required'=> '確認用パスワードを入力してください.',
            'role.required' => '勤務体系を選択してください.',
            'admin.required' => '権限を選択してください.',
        ];
    }
}

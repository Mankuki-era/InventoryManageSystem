<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'name' => 'required|string',
            'url' => 'url',
            'price' => 'required|integer',
            'stocks' => 'required|integer',
            'first_category' => 'required|string',
            'second_category' => 'required|string',
            'third_category' => 'required|string',
        ];
    }

    //[ *3.追加：Validationメッセージを設定（省略可） ]
    //function名は必ず「messages」となります。
    public function messages(){
        return [
            'name.required'  => '製品名を入力してください.',
            'name.string'  => '製品名は文字で入力してください.',
            'url.url'   => '有効なURLを入力してください.',
            'price.required' => '単価を入力してください.',
            'price.integer'  => '単価は数字で入力してください.',
            'stocks.required'=> '在庫数を入力してください.',
            'stocks.integer' => '在庫数は数字で入力してください.',
        ];
    }
}

<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest; 
use Illuminate\Support\Facades\Validator;
class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(){
        return [
            'product_name' => 'required|max:255',
            'company_name' => 'required|max:255',
            'price' => 'required|integer|numeric',
            'stock' => 'required|integer|numeric',
            'comment' => 'nullable|max:10000',
        ];
    }
    public function attributes(){
        return [
            'product_name' => '商品名',
            'company_name' => 'メーカー名',
            'price' => '価格',
            'stock' => '在庫数',
            'comment' => 'コメント'
        ];
    }
    public function messages(){
        return [
            'product_name.required' => ':attributeは必須項目です。',
            'product_name.max' => ':attributeは:max字以内で入力してください。',
            'company_name.required' => ':attributeは必須項目です。',
            'company_name.max' => ':attributeは:max字以内で入力してください。',
            'price.required' => ':attributeは必須項目です。',
            'price.integer' => ':attributeは整数で入力してください。',
            'stock.required' => ':attributeは必須項目です。',
            'stock.integer' => ':attributeは整数で入力してください。',
            'comment.max' => ':attributeは:max字以内で入力してください。',
        ];
    }
}

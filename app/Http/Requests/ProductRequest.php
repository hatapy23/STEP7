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
            'product_name' => ['required', 'max:255'],
            'company_name' => ['required', 'max:255'],
            'price' => ['required', 'numeric', 'min:0', 'half_width_numeric'],
            'stock' => ['required', 'integer', 'min:0', 'half_width_numeric'],
            'comment' => 'nullable|max:10000',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
    public function attributes(){
        return [
            'product_name' => '商品名',
            'company_name' => 'メーカー名',
            'price' => '価格',
            'stock' => '在庫数',
            'comment' => 'コメント',
            'img_path' => '商品画像',
        ];
    }
    public function messages(){
        return [
            'product_name.required' => ':attributeは必須項目です。',
            'product_name.max' => ':attributeは:max字以内で入力してください。',
            'company_name.required' => ':attributeは必須項目です。',
            'company_name.max' => ':attributeは:max字以内で入力してください。',
            'price.required' => ':attributeは必須項目です。',
            'price.numeric' => ':attributeは数値で入力してください。',
            'price.min' => ':attributeは0以上で入力してください。',
            'price.half_width_numeric' => ':attributeは半角数字のみで入力してください。',
            'stock.required' => ':attributeは必須項目です。',
            'stock.integer' => ':attributeは整数で入力してください。',
            'stock.min' => ':attributeは0以上で入力してください。',
            'stock.half_width_numeric' => ':attributeは半角数字のみで入力してください。',
            'comment.max' => ':attributeは:max字以内で入力してください。',
            'img_path' => ':attributeは:max以下のものをアップロードしてください。'
        ];
    }
}

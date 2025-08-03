<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Product extends Model{
  public static function getList($keyword, $company_name) 
  {
    $query = Product::query()
    ->join('companies', 'products.company_id', '=', 'companies.id')
    ->select('products.*', 'companies.company_name');

  // キーワード検索
  if (!empty($keyword)) {
    $query->where(function ($query) use ($keyword) {
    $query->where('products.product_name','like', '%' . $keyword . '%')
      ->orWhere('companies.company_name', 'like', '%' . $keyword . '%');
      });
    }

  // メーカー名で絞り込み
  if (!empty($company_name)) {
    $query->where('companies.company_name', $company_name);
  }
  // データ取得
    return $query->get();
  }
  public static function getProduct(int $id)
  {
    $product = Product::join('companies', 'products.company_id', '=', 'companies.id')
    ->select('products.*', 'companies.company_name')
    ->where('products.id', $id)
    ->first();  
    return $product;
  }
    //登録画面で送信したフォームデータをDBに保存
    protected $fillable = [
        'product_name',
        'company_id',
        'price',
        'stock',
        'comment',
        'img_path'
    ];
    /**
     * Companyモデルとのリレーション定義
     * ProductはCompanyに属する (多対一)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model{
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

    /**
     * 指定されたIDの商品詳細と関連する会社情報を取得する
     *
     * @param int $id
     * @return \App\Models\Product|null
     */
    public static function getProductDetailWithCompany(int $id): ?Product
    {
        // with('company') を使用することで、Productを取得する際にCompany情報もEager Loadingされる
        // これにより、N+1問題を回避し、効率的にデータを取得できる
        return self::with('company')->find($id);
    }

    /**
     * (オプション) もしjoinを使って特定のカラムだけを取得したい場合
     * このメソッドは、`with('company')` を使う方法よりも柔軟性が低いことが多いですが、
     * 特定の要件（例えば、リレーションシップではなく明示的なJOINが必要な場合など）には有用です。
     *
     * @param int $id
     * @return \App\Models\Product|null
     */
    public static function getProductDetailWithCompanyNameUsingJoin(int $id): ?Product
    {
        return self::join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name')
            ->where('products.id', $id)
            ->first();
    }
    public static function getList($keyword, $company_name) {
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
}

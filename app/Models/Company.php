<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Company extends Model{
    //DBからテーブルのデータを取得
    public function getList() {
        $companies = DB::table('companies')
        ->join('products', 'company_id', '=', 'companies.id')
        ->select('products.*', 'companies.company_name')
        ->get();
        return $companies;
    }
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany; 

class Company extends Model{
    //DBからテーブルのデータを取得
    public function getList() {
        protected $fillable = [
            'company_name',
            // 'address', 'phone_number' など、companiesテーブルに存在するカラムを記述
        ];
        $companies = DB::table('companies')
        ->join('products', 'company_id', '=', 'companies.id')
        ->select('products.*', 'companies.company_name')
        ->get();
        return $companies;
    }
}

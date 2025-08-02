<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany; 

class Company extends Model{
    protected $fillable = [
        'company_name',
        'address',
        'phone_number'
    ];
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductRequest;
class ProductController extends Controller 
{
//商品一覧画面：データ削除
public function deleteList($id){
  $delete_product = Product::findorFail($id); 
  $delete_product->delete();
  return redirect('products_list')->with('success', '商品を削除しました。');
}

//商品一覧画面：データを表示
public function showList(){
  $keyword = request()->input('keyword');
  $company_name = request()->input('company_name');
  
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
  $products = $query->get();
  $companies = Company::all();
  return view('products_list',compact('products', 'companies', 'keyword', 'company_name'));
}

//商品情報登録画面：画面を表示
public function showForm(){
  $companies = Company::all();
  return view('products_register',compact('companies'));
}

//商品情報登録画面：情報登録
public function sendForm(ProductRequest $request){
  DB::beginTransaction();
  try {
      $company = Company::where('company_name', $request->company_name)->first();

      if (!$company) {
          return redirect()->back()->withErrors(['error' => '指定されたメーカーが見つかりません。']);
      }

      $data = $request->only(['product_name', 'price', 'stock', 'comment']);
      $data['company_id'] = $company->id;

      // 画像処理
      if ($request->hasFile('img_path')) {
          $image = $request->file('img_path');
          $file_name = $image->getClientOriginalName();
          $image->storeAs('public/images', $file_name);
          $data['img_path'] = 'storage/images/' . $file_name;
      }

      Product::create($data);
      DB::commit();
      return redirect()->route('show.form')->with('success', '商品が登録されました。');

  } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->withErrors(['error' => '登録に失敗しました。']);
  }
}

  //詳細画面の表示
  public function showDetail($id) {
    $product = Product::join('companies', 'products.company_id', '=', 'companies.id')
      ->select('products.*', 'companies.company_name')
      ->where('products.id', $id)
      ->first();
      $companies = Company::all();
    return view ('products_detail', compact('product','companies'));
  }

  //編集画面：データを表示
  public function editList($id) {
    $product = Product::join('companies', 'products.company_id', '=', 'companies.id')
    ->select('products.*', 'companies.company_name')
    ->where('products.id', $id)
    ->first();
    $companies = Company::all();
    return view('products_editor', compact('product','companies'));
  }
  //編集画面：データを編集
  public function updateList(ProductRequest $request, $id){
    $data = request();
    // 画像処理
    $img_path = null;
    if ($data->hasFile('img_path')) {//'image'に変更
        $image = $data->file('img_path');
        $file_name = $image->getClientOriginalName();
        $image->storeAs('public/images', $file_name);
        $img_path = 'storage/images/' . $file_name;
    }

    try {
        DB::table('products')
            ->where('id', $id)
            ->update([
                'product_name' => $data->input('product_name'),
                'price' => $data->input('price'),
                'stock' => $data->input('stock'),
                'comment' => $data->input('comment'),
                'img_path' => $img_path,
            ]);

        DB::table('companies')
            ->where('id', $id)
            ->update([
                'company_name' => $data->input('company_name')
            ]);

        return redirect()->route('edit.list', $id)->with('success', '商品情報が更新されました');
        
    } catch (\Exception $e) {
        \Log::error('更新エラー: '.$e->getMessage());
        return redirect()->back()->with('error', '更新中にエラーが発生しました');
    }
}
}

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
  $products = Product::getList($keyword, $company_name);
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
          if ($image->storeAs('public/images', $file_name)) {
          $data['img_path'] = 'storage/images/' . $file_name;
        } else {
          // 保存に失敗した場合のエラーメッセージをセット
          return redirect()->back()->withErrors(['image_error' => '画像のアップロードに失敗しました。']);
      }}

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
    $product = Product::getProduct($id);  
    $companies = Company::all();  
    return view ('products_detail', compact('product','companies'));
  }

  //編集画面：データを表示
  public function editList($id) {
    $product = Product::getProduct($id);
    $companies = Company::all();
    return view('products_editor', compact('product','companies'));
  }

  //編集画面：データを編集
  public function updateList(ProductRequest $request, $id){
    $data = $request;

    // メーカー名から company_id を取得
    $company = Company::where('company_name', $data->input('company_name'))->first();

    if (!$company) {
        return redirect()->back()->withErrors(['error' => '指定されたメーカーが見つかりません。']);
    }

    // 画像処理
    $img_path = null;
    if ($data->hasFile('img_path')) {
        $image = $data->file('img_path');
        $file_name = $image->getClientOriginalName();
        $image->storeAs('public/images', $file_name);
        $img_path = 'storage/images/' . $file_name;
    }

    try {
        $updateData = [
            'product_name' => $data->input('product_name'),
            'price' => $data->input('price'),
            'stock' => $data->input('stock'),
            'comment' => $data->input('comment'),
            'company_id' => $company->id,
        ];

        if ($img_path) {
            $updateData['img_path'] = $img_path;
        }

        DB::table('products')->where('id', $id)->update($updateData);

        return redirect()->route('edit.list', $id)->with('success', '商品情報が更新されました');
        
    } catch (\Exception $e) {
        \Log::error('更新エラー: '.$e->getMessage());
        return redirect()->back()->with('error', '更新中にエラーが発生しました');
    }
}
}

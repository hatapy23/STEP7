<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
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
  $deleteProduct = Product::findOrFail($id); 
  if (!$deleteProduct) {
    return response()->json(['error' => '商品が見つかりません'], 404);
  }
  $deleteProduct->delete();
    return response()->json(['message' => '商品を削除しました']);
}

//商品一覧画面：データを表示
public function showList(Request $request){
    $keyword = $request->input('keyword');
    $companyName = $request->input('company_name');
    $minPrice = $request->input('min_price');
    $maxPrice = $request->input('max_price');
    $minStock = $request->input('min_stock');
    $maxStock = $request->input('max_stock');

    $query = Product::with('company');
    if (!empty($keyword)) {
        $query->where('product_name', 'like', "%{$keyword}%");
    }
    if (!empty($companyName)) {
        $query->whereHas('company', function ($q) use ($companyName) {
            $q->where('company_name', $companyName);
        });
    }

    if (!empty($minPrice)) {
        $query->where('price', '>=', $minPrice);
    }
    if (!empty($maxPrice)) {
        $query->where('price', '<=', $maxPrice);
    }
    
    if (!empty($minStock)) {
        $query->where('stock', '>=', $minStock);
    }
    if (!empty($maxStock)) {
        $query->where('stock', '<=', $maxStock);
    }
    $products = $query->get();
    $companies = Company::all();

    // Ajaxリクエストなら、ビューの一部だけを返す
    if ($request->ajax()) {
        $html = view('products_partials', compact('products'))->render();
        return response()->json(['html' => $html]);
    }
    // Ajaxでなければ通常のビューを返す
    return view('products_list', compact('products', 'companies', 'keyword', 'companyName'));
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

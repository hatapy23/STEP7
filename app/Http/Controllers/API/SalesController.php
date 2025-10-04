<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Sales;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\API\SalesController;

class SalesController extends Controller{
    /**
     * 商品の購入処理を行う
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function purchase(Request $request){
        // 購入数量をリクエストから取得
        $quantity = $request->input('quantity', 1); // 数量が指定されなければデフォルトは1
        $productId = $request->input('product_id');

        // バリデーション
        if (!$productId || $quantity <= 0) {
            return response()->json([
                'result' => false,
                'error' => ['messages' => ['商品IDと数量を正しく指定してください。']]
            ], 400); // Bad Request
        }

        DB::beginTransaction();

        try {
            // ① productsテーブルから商品を取得し、在庫をロックする
            $product = Product::where('id', $productId)->lockForUpdate()->first();

            // 在庫チェック
            if (!$product || $product->stock < $quantity) {
                DB::rollBack();
                // 在庫が0または不足している場合、エラーを返す
                return response()->json([
                    'result' => false,
                    'error' => ['messages' => ['在庫が不足しています。']]
                ], 400); // Bad Request
            }

            // ② salesテーブルにレコードを追加
            // 購入数量もsalesテーブルに保存したい場合は、ここにカラムを追加してください
            $sale = new Sales();
            $sale->product_id = $productId;
            $sale->save();

            // ③ productsテーブルの在庫数を減算
            $product->stock -= $quantity; // 購入数量分を減算
            $product->save();

            DB::commit();

            return response()->json([
                'result' => true,
                'message' => '商品を購入しました。'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('購入処理エラー: ' . $e->getMessage());

            return response()->json([
                'result' => false,
                'error' => ['messages' => ['購入処理中にエラーが発生しました。']]
            ], 500); // Internal Server Error
        }
    }
}

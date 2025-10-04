@extends('layouts.app')
@section('title','商品一覧画面')
@section('content')
<div class="container">
<h2>商品一覧画面</h2>
  <div class="col-10 row mb-3 ">
    <form action="{{ route('show.list') }}" method="get" class="d-flex gap-3 align-items-center">
      <input type="text" name="keyword" class="form-control" placeholder="キーワードを入力">
      <select name="company_name" class="form-select">
        <option value="">メーカー名</option>
        @foreach ($companies as $company)
            <option value="{{ $company->company_name }}" {{ isset($company_name) && $company_name == $company->company_name ? 'selected' : '' }}>
                {{ $company->company_name }}
            </option>
        @endforeach
      </select>
       <input type="text" name="min_price" class="form-control" placeholder="価格：〜円以上">
       <input type="text" name="max_price" class="form-control" placeholder="価格：〜円以下">
       <input type="text" name="min_stock" class="form-control" placeholder="在庫：〜以上">
       <input type="text" name="max_stock" class="form-control" placeholder="在庫：〜以下">
      <button type="submit" class="btn btn-primary search-btn ">検索</button>
    </form>
  </div>

 <div class="col-10 row mb-3 align-items-center">
  <table class="table table-bordered border-secondary text-left" id="product_table">
    <thead>
      <tr>
      <div class="d-flex gap-2 justify-content-center">
        <th>ID</th>
        <th>商品画像</th>
        <th>商品名</th>
        <th>価格</th>
        <th>在庫数</th>
        <th>メーカー名</th>
        <th>
          <form action="{{ route('show.form') }}" method="get">
           <button type="submit" class="btn btn-warning">新規登録</button>
          </form>
        </th>
      </div> 
      </tr>
    </thead>
    <tbody>
      <form action="{{ route('show.list') }}" method="get" enctype="multipart/form-data">
      @foreach ($products as $product)
        <tr>
          <td>{{ $product->id }}</td>
          <td><img src="{{ asset($product->img_path) }}" alt="商品画像" class="product_img" width="50px"></td>
          <td>{{ $product->product_name }}</td>
          <td>{{ $product->price }}円</td>
          <td>{{ $product->stock }}</td>
          <td>{{ $product->company->company_name }}</td>
          <td class = "action-button">
            <div class="d-flex gap-2 justify-content-center">
              <a href="{{ route('show.detail', $product->id) }}" class="btn btn-info d-inline-block">詳細</a>
              <form action="{{ route('delete.list', $product->id) }}" method="post" class="d-inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger delete-btn" data-id="{{ $product->id }}">削除</button>
              </form>
            </div>
          </td>
        </tr>
      @endforeach
      </form>
    </tbody>
  </table>
 </div>
</div>
@endsection
@section('scripts')
<script>

$(document).ready(function() {
  $('#product_table').tablesorter();
    // 検索フォームの送信をAjaxで処理する
    $('.search-btn').on('click', function(e) {
        e.preventDefault(); // フォームの通常の送信を止める

        var keyword = $('input[name="keyword"]').val();
        var companyName = $('select[name="company_name"]').val();
        var minPrice = $('input[name="min_price"]').val();
        var maxPrice = $('input[name="max_price"]').val();
        
        var stockRange = $('input[name="stock_range"]').val();
        var minStock = $('input[name="min_stock"]').val();
        var maxStock = $('input[name="max_stock"]').val();
        
        // サーバーに処理を送信
        $.ajax({
            url: "{{ route('show.list') }}",
            type: "GET",
            data: {
                keyword: keyword,
                company_name: companyName,
                min_price: minPrice,
                max_price: maxPrice,
                min_stock: minStock,
                max_stock: maxStock
            },
            success: function(response) {
                // 成功したら、返ってきたデータでテーブルを更新
                $('#product_table tbody').html(response.html);
                //Tablesorter
                $('#product_table').trigger('update');
            },
            error: function(error) {
                console.log(error);
                alert('検索できませんでした。やり直してください。');
              }
        });
    });
    //削除機能のAjax処理
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault(); 

        if (confirm('本当にこの商品を削除しますか？')) {
            var productId = $(this).data('id');
            var row = $(this).closest('tr');
            // サーバーに処理を送信
            $.ajax({
                url: "{{ url('/products_list') }}" + '/' + productId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                // 成功したら、テーブルからその行を消す
                success: function(response) {
                    row.remove();
                    alert('商品を削除しました。');
                },
            });
        }
    });
});
</script>
@endsection
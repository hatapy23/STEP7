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
      <button type="submit" class="btn btn-primary search-btn">検索</button>
    </form>
  </div>

 <div class="col-10 row mb-3 align-items-center">
  <table class="table table-bordered border-secondary text-left">
    <thead>
      <tr>
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
        </tr>
    </thead>
    <tbody>
      <form action="{{ route('show.list') }}" method="get" enctype="multipart/form-data">
      @foreach ($products as $product)
        <tr>
          <td>{{ $product->id }}</td>
          <td><img src="{{ asset($product->img_path) }}" alt="商品画像" class="product_img"></td>
          <td>{{ $product->product_name }}</td>
          <td>{{ $product->price }}円</td>
          <td>{{ $product->stock }}</td>
          <td>{{ $product->company_name }}</td>
          <td class = action-button>
            <a href="{{ route('show.detail', $product->id) }}" class="btn btn-info d-inline-block">詳細</a>
            <form action="{{ route('delete.list', $product->id) }}" method="post">
              @csrf
              @method('DELETE')
             <button type="submit" class="btn btn-danger d-inline-block" onclick="return confirm('本当に削除しますか？')">削除</button>
            </form>
          </td>
        </tr>
      @endforeach
      </form>
    </tbody>
  </table>
 </div>
</div>
@endsection

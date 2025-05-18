@extends('layouts.app')
@section('title','商品情報詳細画面')
@section('content')
<div class="container">
  <h2>商品情報詳細画面</h2>

  <div class="row mb-3 align-items-center text-md-end">
    <label class="col-sm-2 col-form-label fw-bold">商品ID</label>
    <div class="col-sm-6 text-md-start">{{ $product->id }}</div>
  </div>

  <div class="row mb-3 align-items-center text-md-end">
    <label class="col-sm-2 col-form-label fw-bold product-img">商品画像</label>
    <div class="col-sm-6">
      <img src="{{ asset($product->img_path) }}" alt="商品画像" width="50px">
    </div>
  </div>

  <div class="row mb-3 align-items-center text-md-end">
    <label class="col-sm-2 col-form-label fw-bold">商品名</label>
    <div class="col-sm-6 text-md-start">{{ $product->product_name }}</div>
  </div>

  <div class="row mb-3 align-items-center text-md-end">
    <label class="col-sm-2 col-form-label fw-bold">メーカー</label>
    <div class="col-sm-6 text-md-start">{{ $product->company_name }}</div>
  </div>

  <div class="row mb-3 align-items-center text-md-end">
    <label class="col-sm-2 col-form-label fw-bold">価格</label>
    <div class="col-sm-6 text-md-start">{{ $product->price }}円</div>
  </div>

  <div class="row mb-3 align-items-center text-md-end">
    <label class="col-sm-2 col-form-label fw-bold">在庫数</label>
    <div class="col-sm-6 text-md-start">{{ $product->stock }}</div>
  </div>

  <div class="row mb-3 align-items-center text-md-end">
    <label class="col-sm-2 col-form-label fw-bold">コメント</label>
    <div class="col-sm-6 text-md-start">{{ $product->comment }}</div>
  </div>

  <div class="d-flex gap-3 mt-4 text-md-end">
    <form action="{{ route('edit.list', $product->id) }}" method="get">
      <button class="btn btn-info" type="submit">編集</button>
    </form>
    <form action="{{ route('show.list') }}" method="get">
      <button class="btn btn-warning" type="submit">戻る</button>
    </form>
  </div>
</div>
@endsection

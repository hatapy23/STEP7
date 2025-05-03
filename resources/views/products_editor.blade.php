@extends('layouts.app')
@section('title','商品情報編集画面')
@section('content')
<div class="container">
  <h2>商品情報編集画面</h2>
  <form action="{{ route('edit.list', ['id' => $product->id]) }}" name = editor method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row mb-3 align-items-center text-md-end">
      <label for="id" class="col-sm-2 col-form-label">商品ID </label>
      <div class="col-sm-6 text-md-start">{{ $product->id }}</div>
    </div>

    <div class="row mb-3 align-items-center text-md-end">
      <label for="product_name" class="col-sm-2 col-form-label">商品名 <span class="text-danger">*</span></label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product->product_name }}" required>
      </div>
    </div>

    <div class="row mb-3 align-items-center text-md-end">
      <label for="company_name" class="col-sm-2 col-form-label">メーカー名 <span class="text-danger">*</span></label>
      <div class="col-sm-6">
        <select name="company_name" class="form-select" required>
          <option value="">メーカー名</option>
          @foreach ($companies as $company)
            <option value="{{ $company->company_name }}" {{ $product->company_name == $company->company_name ? 'selected' : '' }}>
              {{ $company->company_name }}
            </option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="row mb-3 align-items-center text-md-end">
      <label for="price" class="col-sm-2 col-form-label">価格 <span class="text-danger">*</span></label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
      </div>
    </div>

    <div class="row mb-3 align-items-center text-md-end">
      <label for="stock" class="col-sm-2 col-form-label">在庫数 <span class="text-danger">*</span></label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="stock" name="stock" value="{{ $product->stock }}" required>
      </div>
    </div>

    <div class="row mb-3 align-items-center text-md-end">
      <label for="comment" class="col-sm-2 col-form-label">コメント</label>
      <div class="col-sm-6">
        <textarea id="comment" name="comment" class="form-control" rows="4">{{ $product->comment }}</textarea>
      </div>
    </div>

    <div class="row mb-3 align-items-center text-md-end">
      <label for="image" class="col-sm-2 col-form-label text-md-end">商品画像</label>
      <div class="col-sm-6">
        <input type="file" id="image" name="image" class="form-control" accept="image/*">
      </div>
    </div>

    <div class="d-flex gap-3">
      <button action="{{ route('update.list', $product->id) }}" type="submit" class="btn btn-info">更新</button>
      <button type="button" class="btn btn-warning" onclick="window.location.href='{{ route('show.detail', $product->id) }}'">戻る</button>
    </div>
  </form>
</div>
@endsection

@extends('layouts.app')
@section('title','商品新規登録画面')
@section('content')
<div class="container">
  <h2>商品新規登録画面</h2>
  <form action="{{ route('send.form') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row mb-3 align-items-center text-md-end">
      <label for="product_name" class="col-sm-2 col-form-label">商品名 <span class="text-danger">*</span></label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="product_name" name="product_name" required>
      </div>
    </div>

    <div class="row mb-3 align-items-center text-md-end">
      <label for="company_name" class="col-sm-2 col-form-label">メーカー名 <span class="text-danger">*</span></label>
      <div class="col-sm-6">
        <select name="company_name" class="form-select" required>
          <option value="">メーカー名</option>
          @foreach ($companies as $company)
            <option value="{{ $company->company_name }}" >
              {{ $company->company_name }}
            </option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="row mb-3 align-items-center text-md-end">
      <label for="price" class="col-sm-2 col-form-label">価格 <span class="text-danger">*</span></label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="price" name="price" required>
      </div>
    </div>

    <div class="row mb-3 align-items-center text-md-end">
      <label for="stock" class="col-sm-2 col-form-label">在庫数 <span class="text-danger">*</span></label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="stock" name="stock" required>
      </div>
    </div>

    <div class="row mb-3 align-items-center text-md-end">
      <label for="comment" class="col-sm-2 col-form-label">コメント</label>
      <div class="col-sm-6">
        <textarea id="comment" name="comment" class="form-control" rows="4"></textarea>
      </div>
    </div>

    <div class="row mb-3 align-items-center text-md-end">
      <label for="img_path" class="col-sm-2 col-form-label">商品画像</label>
      <div class="col-sm-6">
        <input type="file" id="img_path" name="img_path" class="form-control" accept="image/*">
        @if ($product->img_path)
        <img src="{{ asset($product->img_path) }}" alt="商品画像" width="200">
        @else
        画像はありません
        @endif
     </div>
    </div>

    <div class="d-flex gap-3">
      <button type="submit" class="btn btn-info">更新</button>
      <button type="button" class="btn btn-warning" onclick="window.location.href='{{ route('show.list')}}'">戻る</button>
    </div>
  </form>
</div>
@endsection

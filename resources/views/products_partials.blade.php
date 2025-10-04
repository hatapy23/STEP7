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
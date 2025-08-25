@extends('layouts.app')

@section('title', '商品編集')

@section('content')
<div class="container">
    <h1>商品編集</h1>

    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        {{-- ID（表示のみ） --}}
        <div class="mb-3">
            <label class="form-label">ID</label>
            <input type="text" class="form-control" value="{{ $product->id }}" disabled>
        </div>

        {{-- 商品画像 --}}
        <div class="mb-3">
            <label for="image" class="form-label">商品画像</label><br>
            @if ($product->img_path)
            <img src="{{ asset('storage/' . $product->img_path) }}" alt="商品画像" width="200" class="mb-2"><br>
            @endif
            <input type="file" class="form-control" id="image" name="image">
        </div>

        {{-- 商品名 --}}
        <div class="mb-3">
            <label for="product_name" class="form-label">商品名</label>
            <input type="text" class="form-control" id="product_name" name="product_name"
                value="{{ old('product_name', $product->product_name) }}" required>
        </div>

        {{-- メーカー --}}
        <div class="mb-3">
            <label for="company_id" class="form-label">メーカー</label>
            <select class="form-select" id="company_id" name="company_id" required>
                <option value="">選択してください</option>
                @foreach ($companies as $company)
                <option value="{{ $company->id }}"
                    {{ $product->company_id == $company->id ? 'selected' : '' }}>
                    {{ $company->company_name }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- 価格 --}}
        <div class="mb-3">
            <label for="price" class="form-label">価格</label>
            <input type="number" class="form-control" id="price" name="price"
                value="{{ old('price', $product->price) }}" required>
        </div>

        {{-- 在庫数 --}}
        <div class="mb-3">
            <label for="stock" class="form-label">在庫数</label>
            <input type="number" class="form-control" id="stock" name="stock"
                value="{{ old('stock', $product->stock) }}" required>
        </div>

        {{-- コメント --}}
        <div class="mb-3">
            <label for="comment" class="form-label">コメント</label>
            <textarea class="form-control" id="comment" name="comment" rows="3">{{ old('comment', $product->comment) }}</textarea>
        </div>

        {{-- ボタン --}}
        <button type="submit" class="btn btn-primary">更新</button>
        <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary">戻る</a>
    </form>
</div>
@endsection
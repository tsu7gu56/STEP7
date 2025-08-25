@extends('layouts.app')

@section('title', '商品詳細')

@section('content')
<div class="container">
    <h1>商品詳細</h1>

    <div class="card p-4 shadow">
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>ID:</strong> {{ $product->id }}</li>
            <li class="list-group-item">
                <strong>商品画像:</strong><br>
                @if ($product->img_path)
                    <img src="{{ asset('storage/' . $product->img_path) }}" alt="商品画像" width="200">
                @else
                    <span>画像なし</span>
                @endif
            </li>
            <li class="list-group-item"><strong>商品名:</strong> {{ $product->product_name }}</li>
            <li class="list-group-item"><strong>メーカー:</strong> {{ $product->company->company_name ?? '不明' }}</li>
            <li class="list-group-item"><strong>価格:</strong> {{ $product->price }} 円</li>
            <li class="list-group-item"><strong>在庫数:</strong> {{ $product->stock }}</li>
            <li class="list-group-item"><strong>コメント:</strong><br>{{ $product->comment }}</li>
        </ul>
    </div>

    <div class="mt-4">
        {{-- 編集ボタン --}}
        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">編集</a>

        {{-- 戻るボタン --}}
        <a href="{{ route('page1') }}" class="btn btn-secondary">戻る</a>
    </div>
</div>
@endsection
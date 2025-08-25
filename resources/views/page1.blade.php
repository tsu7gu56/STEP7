@extends('layouts.app')

@section('title', 'Page1')

@section('content')
<div class="container">
    <h1>商品一覧画面</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form method="GET" action="{{ route('page1') }}" class="mb-4 d-flex gap-3">
        {{-- 商品名キーワード検索 --}}
        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="商品名で検索" class="form-control w-25">

        {{-- メーカープルダウン --}}
        <select name="company_id" class="form-select w-25">
            <option value="">メーカーを選択</option>
            @foreach ($companies as $company)
            <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                {{ $company->company_name }}
            </option>
            @endforeach
        </select>
        {{-- 検索ボタン --}}
        <button type="submit" class="btn btn-primary">検索</button>

        {{-- リセットボタン --}}
        <a href="{{ route('page1') }}" class="btn btn-secondary">リセット</a>

    </form>


    {{-- 商品一覧表示 --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー名</th>
                <th>
                    <div class="mb-3 text-end">
                        <a href="{{ route('products.create') }}" class="btn btn-success">新規作成</a>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>{{ $product->id }}</td>

            <td>
                @if ($product->img_path)
                    <img src="{{ asset('storage/' . $product->img_path) }}" alt="商品画像" width="80">
                @else
                    <span>画像なし</span>
                @endif
            </td>

                <td>{{ $product->product_name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->company->company_name ?? '不明' }}</td>

                <td>
                    {{-- 詳細ボタン --}}
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info">詳細</a>

                    {{-- 削除ボタン --}}
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">削除</button>
                    </form>
                </td>

            </tr>

            @empty
            <tr>
                <td colspan="4">商品が見つかりませんでした。</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ページネーション --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $products->appends(request()->query())->links() }}
    </div>

</div>
@endsection
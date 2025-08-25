<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Company;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function page1(Request $request)
    {
        // 検索キーワード取得
        $keyword = $request->input('keyword');

        $query = Products::with('company'); // ← リレーションも読み込む

        // 検索条件

        if (!empty($keyword)) {
            $query->where('product_name', 'like', '%' . $keyword . '%');
        }

         // 会社IDによる絞り込み（プルダウン検索用）
    if ($request->filled('company_id')) {
        $query->where('company_id', $request->company_id);
    }

        // 結果取得
    //  ページネーションを適用（1ページ10件）
    $products = $query->paginate(10);
            $companies = Company::all();

        return view('page1', compact('products', 'keyword','companies'));
    }

    public function index(Request $request)
{
    $query = Products::with('company');

    // 商品名検索（部分一致）
    if ($request->filled('keyword')) {
        $query->where('product_name', 'like', '%' . $request->keyword . '%');
    }

    // メーカー検索
    if ($request->filled('company_id')) {
        $query->where('company_id', $request->company_id);
    }

    $products = $query->get();
    $companies = Company::all();

    return view('page1', compact('products', 'companies'));
}

// フォーム表示
public function create()
{
    // company 一覧も渡す
    $companies = \App\Models\Company::all();
    return view('product_create', compact('companies'));
}

// 登録処理
public function store(Request $request)
{
    // バリデーション
    $request->validate([
        'product_name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'company_id' => 'required|exists:companies,id',
        'comment' => 'nullable|string|max:1000',
        'image' => 'nullable|image|max:2048', // 画像サイズ制限（2MB）
    ]);

  $img_Path = null;

    if ($request->hasFile('image')) {
        $img_Path = $request->file('image')->store('images', 'public');
    }

    Products::create([
        'product_name' => $request->product_name,
        'price' => $request->price,
        'stock' => $request->stock,
        'company_id' => $request->company_id,
        'comment' => $request->comment,
        'img_path' => $img_Path,
    ]);

    // 新規登録画面へリダイレクト（再表示）
    return redirect()->route('products.create')->with('success', '商品を登録しました！');
}

    // 詳細ページ表示
public function show($id)
{
    $product = \App\Models\Products::with('company')->findOrFail($id);
    return view('product_detail', compact('product'));
}

// 編集フォーム表示
public function edit($id)
{
    $product = \App\Models\Products::with('company')->findOrFail($id);
    $companies = \App\Models\Company::all(); // プルダウン用
    return view('product_edit', compact('product', 'companies'));
}

// 更新処理
public function update(Request $request, $id)
{
    $request->validate([
        'product_name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'company_id' => 'required|exists:companies,id',
        'comment' => 'nullable|string|max:1000',
        'image' => 'nullable|image|max:2048', // 画像は任意・2MB制限
    ]);

    $product = \App\Models\Products::findOrFail($id);

    // 画像更新処理
    if ($request->hasFile('image')) {
        $img_path = $request->file('image')->store('images', 'public');
        $product->img_path = $img_path;
    }

    // 他の項目を更新
    $product->product_name = $request->product_name;
    $product->price = $request->price;
    $product->stock = $request->stock;
    $product->company_id = $request->company_id;
    $product->comment = $request->comment;

    $product->save();

    return redirect()->route('products.edit', $product->id)
                     ->with('success', '商品を更新しました！');
}


// 削除処理
public function destroy($id)
{
    Products::destroy($id);
    return redirect()->route('page1')->with('success', '商品を削除しました');
}
}

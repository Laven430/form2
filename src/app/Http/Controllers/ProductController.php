<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }
        if ($request->filled('sort')) {
            $sort = $request->input('sort');
            switch ($sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(6);
        $currentSearch = $request->input('search');
        $currentSort = $request->input('sort');

        return view('products.index', compact('products', 'currentSearch', 'currentSort'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function create()
    {
        $seasons = ['春', '夏', '秋', '冬'];
        return view('products.create', compact('seasons'));
    }

    public function store(ProductCreateRequest $request)
    {
        $validated = $request->validated();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image_path'] = $imagePath;
        }

        if (isset($validated['seasons'])) {
            $validated['seasons'] = implode(',', (array)$validated['seasons']);
        } else {
            $validated['seasons'] = null;
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', '商品を登録しました！');
    }

    public function edit(Product $product)
    {
        $seasons = ['春', '夏', '秋', '冬'];
        $productSeasons = $product->seasons;

        return view('products.edit', compact('product', 'seasons', 'productSeasons'));
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        \Log::info('Update method called. Request method: ' . request()->method());
        $validated = $request->validated();
        $product->update($validated);
        $updatedProduct = Product::find($product->id);
        return redirect()->route('products.index')->with('success', '商品を更新しました！');
    }

    public function destroy(Product $product)
    {
        \Log::info('Destroy method called. Request method: ' . request()->method());
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', '商品を削除しました。');
    }
}
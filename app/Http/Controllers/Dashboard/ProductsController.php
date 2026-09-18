<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $request = request();
        $query = Product::query()->with(['store', 'category']);
        $name = $request->query('name');
        $status = $request->query('status');
        $categoryId = $request->query('category_id');
        $storeId = $request->query('store_id');
        if ($name) {
            $query->where('name', 'like', "%$name%");
        }
        if ($status) {
            $query->where('status', $status);
        }
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        if ($storeId) {
            $query->where('store_id', $storeId);
        }
        return view('dashboard.pages.products.index', [
            'products' => $query->with('category', 'store')->get(),
            'categories' => Category::pluck('name', 'id'),
            'stores' => Store::pluck('name', 'id'),
        ]);
    }

    public function create()
    {
        return view('dashboard.pages.products.create', [
            'product' => new Product(),
            'categories' => Category::pluck('name', 'id'),
            'stores' => Store::pluck('name', 'id'),
        ]);
    }

    public function show(Product $product)
    {
        return view('dashboard.pages.products.show', compact('product'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255','unique:products,name,except:id'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'store_id' => ['required', 'exists:stores,id'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        Product::create($request->all());

        return redirect()->route('dashboard.products.index')->with('success', 'تم إضافة المنتج بنجاح.');
    }
    public function edit(Product $product)
    {
        return view('dashboard.pages.products.edit', [
            'product' => $product,
            'categories' => Category::pluck('name', 'id'),
            'stores' => Store::pluck('name', 'id'),
        ]);
    }
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'store_id' => ['required', 'exists:stores,id'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $product->update($request->all());

        return redirect()->route('dashboard.products.index')->with('success', 'تم تحديث المنتج بنجاح.');
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('dashboard.products.index')->with('success', 'تم حذف المنتج بنجاح.');
    }
}

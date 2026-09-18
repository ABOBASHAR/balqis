<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class CategoriesController extends Controller
{
    public function index()
    {
        // Filtering and searching categories based on query parameters
        $request = request();
        $query = Category::query();
        $name = $request->query('name');
        $status = $request->query('status');
        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }
        if ($status) {
            $query->where('status', $status);
        }
        $categories = $query->withCount('products')->get();
        // $categories = Category::all();
        // The above line is commented out because we are using the filtered query instead
        return view('dashboard.pages.categories.index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return view('dashboard.pages.categories.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,except:id'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        // Create a new category using the validated data
        Category::create($request->all());
        return redirect()->route('dashboard.categories.index')->with('success', 'تم إضافة الفئة بنجاح.');
    }

    public function show(Category $category)
    {
        // $category = Category::findOrFail($id);
        return view('dashboard.pages.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        // $category = Category::findOrFail($id);
        return view('dashboard.pages.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        // Validate the request data
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories', 'name')->ignore($category->id)],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ]);
        $category->update($request->all());
        return redirect()->route('dashboard.categories.index')->with('success', 'تم تحديث الفئة بنجاح.');
    }

    public function destroy(Category $category)  // (Route model binding) can be used here instead of $id
    {
        // $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('dashboard.categories.index')->with('success', 'تم حذف الفئة بنجاح.');
    }

    public function showProducts(Category $category)
    {
        // Get the products associated with the category
        $products = $category->products()->with('store')->paginate(10);  // Paginate the products, 10 per page
        return view('dashboard.pages.categories.products', [
            'category' => $category,
            'products' => $products,
        ]);
    }
}

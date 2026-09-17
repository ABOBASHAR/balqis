<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        //Filtering and searching categories based on query parameters
        $request=request();
        $query=Category::query();
        $categories = Category::all();
        $name=$request->query('name');
        $status=$request->query('status');
        if($name){
            $query->where('name','like','%'.$name.'%');
        }
        if($status){
            $query->where('status',$status);
        }
        return view('dashboard.pages.categories.index',[
            'categories' => $query->get(),
        ]);
    }
    public function create()
    {
        return view('dashboard.pages.categories.create');
    }
    public function store(Request $request)
    {
        // Validate the request data
        $request -> validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        // Create a new category using the validated data
        Category::create($request->all());
        return redirect()->route('dashboard.categories.index')->with('success', 'Category created successfully.');
    }
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('dashboard.pages.categories.show', compact('category'));
    }
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('dashboard.pages.categories.edit', compact('category'));
    }
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        // Find the category by ID and update it with the validated data
        $category = Category::findOrFail($id);
        $category->update($request->all());
        return redirect()->route('dashboard.categories.index')->with('success', 'Category updated successfully.');
    }
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('dashboard.categories.index')->with('success', 'Category deleted successfully.');
    }
}

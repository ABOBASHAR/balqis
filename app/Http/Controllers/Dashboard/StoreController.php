<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreController extends Controller
{
    public function index()
    {
        $request = request();
        $query = Store::query();
        $name = $request->query('name');
        $status = $request->query('status');
        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }
        if ($status) {
            $query->where('status', $status);
        }
        $stores = $query->get();
        // $stores = Store::all();
        // The above line is commented out because we are using the filtered query instead
        return view('dashboard.pages.stores.index', [
            'stores' => $stores,
        ]);
    }

    public function create()
    {
        $store = new Store();

        return view('dashboard.pages.stores.create', [
            'store' => $store,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100','unique:stores,name,except:id'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ]);
        Store::create($request->all());
        return redirect()->route('dashboard.stores.index')->with('success', 'تم إنشاء المتجر بنجاح.');
    }
    public function show(Store $store) // (Route model binding) can be used here instead of $id
    {
        return view('dashboard.pages.stores.show', compact('store'));
    }
    public function edit(Store $store)
    {
        return view('dashboard.pages.stores.edit', compact('store'));
    }
    public function update(Request $request, Store $store) // (Route model binding) can be used here instead of $id
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100',Rule::unique('stores','name')->ignore($store->id)],
            'description' => ['nullable', 'string', 'max:255','min:5'],
            'status' => ['required', 'in:active,inactive'],
        ]);
        $store->update($request->all());
        return redirect()->route('dashboard.stores.index')->with('success', 'تم تحديث المتجر بنجاح.');
    }
    public function destroy(Store $store)
    {
        // $store = Store::findOrFail($id);
        $store->delete();
        return redirect()->route('dashboard.stores.index')->with('success', 'تم حذف المتجر بنجاح.');
    }
}

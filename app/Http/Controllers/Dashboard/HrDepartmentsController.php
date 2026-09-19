<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HrDepartment;
use Illuminate\Http\Request;

class HrDepartmentsController extends Controller
{
    public function index()
    {
        $request = request();
        $query = HrDepartment::query();
        $name = $request->query('name');
        $status = $request->query('status');
        if ($name) {
            $query->where('name', 'like', "%$name%");
        }
        if ($status) {
            $query->where('status', $status);
        }
        return view('dashboard.pages.hr.departments.index', [
            'departments' => $query->get(),
        ]);
    }

    public function create()
    {
        return view('dashboard.pages.hr.departments.create', [
            'department' => new HrDepartment,
        ]);
    }

    protected function validated(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);
    }

    public function store(Request $request)
    {
        HrDepartment::create($this->validated($request));
        return redirect()->route('dashboard.hr.departments.index')->with('success', 'تم إنشاء القسم بنجاح');
    }

    public function show(HrDepartment $department)
    {
        return view('dashboard.pages.hr.departments.show', compact('department'));
    }
    public function edit(HrDepartment $department)
    {
        return view('dashboard.pages.hr.departments.edit', [
            'department' => $department,
        ]);
    }

    public function update(Request $request, HrDepartment $department)
    {
        $department->update($this->validated($request));
        return redirect()->route('dashboard.hr.departments.index')->with('success', 'تم تحديث القسم بنجاح');
    }
}

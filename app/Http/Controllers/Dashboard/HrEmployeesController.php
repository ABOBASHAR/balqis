<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HrEmployee;
use Illuminate\Http\Request;
use App\Models\HrDepartment;

class HrEmployeesController extends Controller
{
    public function index()
    {

        return view('dashboard.pages.hr.employees.index', [
            'employees' => HrEmployee::all(),
        ]);
    }

    protected function departmentOptions()
    {
        return HrDepartment::pluck('name', 'id');
    }
    public function create()
    {
        return view('dashboard.pages.hr.employees.create', [
            'employee' => new HrEmployee,
            'departments' => $this->departmentOptions(),
        ]);
    }

    protected function validated(Request $request , HrEmployee $employee)
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:50', 'min:3'],
            'email' => ['required', 'email', 'unique:hr_employees,email,' . $employee->id],
            'phone' => ['nullable', 'numeric', 'max_digits:10'],
            'department_id' => ['nullable', 'exists:hr_departments,id'],
            'job_title' => ['nullable', 'string', 'max:50', 'min:3'],
            'hire_date' => ['nullable', 'date'],
            'salary' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,on_leave,terminated,inactive'],
            'address' => ['nullable', 'string', 'max:500'],
            'notes' => ['nullable', 'string'],
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validated($request, new HrEmployee());

        HrEmployee::create($validatedData);

        return redirect()->route('dashboard.hr.employees.index')->with('success', 'تم إنشاء الموظف بنجاح');
    }
    public function show(HrEmployee $employee)
    {
        return view('dashboard.pages.hr.employees.show', compact('employee'));
    }
    public function edit(HrEmployee $employee)
    {
        return view('dashboard.pages.hr.employees.edit', [
            'employee' => $employee,
            'departments' => $this->departmentOptions(),
        ]);
    }
    public function update(Request $request, HrEmployee $employee)
    {
        $validatedData = $this->validated($request, $employee);

        $employee->update($validatedData);

        return redirect()->route('dashboard.hr.employees.index')->with('success', 'تم تحديث الموظف بنجاح');
    }
    public function destroy(HrEmployee $employee)
    {
        $employee->delete();

        return redirect()->route('dashboard.hr.employees.index')->with('success', 'تم حذف الموظف بنجاح');
    }
}

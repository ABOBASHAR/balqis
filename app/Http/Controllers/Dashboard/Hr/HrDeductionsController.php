<?php

namespace App\Http\Controllers\Dashboard\Hr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HrDeduction;
use App\Models\HrEmployee;

class HrDeductionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request = request();
        $query = HrDeduction::query();
        $employeeId = $request->query('employee_id');
        $type = $request->query('type');
        $amount = $request->query('amount');
        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }
        if ($type) {
            $query->where('type', $type);
        }
        if ($amount) {
            $query->where('amount', $amount);
        }
        return view('dashboard.pages.hr.deductions.index',[
            'deductions' => $query->get(),
            'employees' => $this->employeeOptions(),
        ]);
    }
    protected function employeeOptions()
    {
        return HrEmployee::orderBy('name')->pluck('name', 'id');
    }    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pages.hr.deductions.create',[
            'deductions' => new HrDeduction(),
            'employees' => $this->employeeOptions(),
        ]);
    }

    public function validate(Request $request)
    {
        return $request->validate([
            'employee_id' => ['required', 'exists:hr_employees,id'],
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:late,absent,loan,penalty,tax,other'],
            'amount' => ['required', 'numeric', 'min:0'],
            'date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validate($request);
        HrDeduction::create($validated);
        return redirect()->route('dashboard.hr.deductions.index')->with('success', 'تم إضافة الخصم بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(HrDeduction $deduction,)
    {
        return view('dashboard.pages.hr.deductions.show', [
            'deduction' => $deduction,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HrDeduction $deduction)
    {
        return view('dashboard.pages.hr.deductions.edit', [
            'deduction' => $deduction,
            'employees' => $this->employeeOptions(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HrDeduction $deduction)
    {
        $validated = $this->validate($request);
        $deduction->update($validated);
        return redirect()->route('dashboard.hr.deductions.index')->with('success', 'تم تحديث الخصم بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HrDeduction $deduction)
    {
        $deduction->delete();
        return redirect()->route('dashboard.hr.deductions.index')->with('success', 'تم حذف الخصم بنجاح');
    }
}

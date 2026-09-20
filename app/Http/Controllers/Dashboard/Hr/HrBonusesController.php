<?php

namespace App\Http\Controllers\Dashboard\Hr;

use App\Http\Controllers\Controller;
use App\Models\HrBonus;
use App\Models\HrEmployee;
use Illuminate\Http\Request;

class HrBonusesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request = request();
        $query = HrBonus::query();
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
        return view('dashboard.pages.hr.bonuses.index', [
            'bonuses' => $query->get(),
            'employees' => $this->employeeOptions(),
        ]);
    }

    protected function employeeOptions()
    {
        return HrEmployee::orderBy('name')->pluck('name', 'id');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pages.hr.bonuses.create', [
            'employees' => $this->employeeOptions(),
            'bonuses' => HrBonus::all(),
        ]);
    }

    protected function validate(Request $request)
    {
        return $request->validate([
            'employee_id' => ['required', 'exists:hr_employees,id'],
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:performance,overtime,holiday,commission,other'],
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
        HrBonus::create($this->validate($request));
        return redirect()->route('dashboard.hr.bonuses.index')->with('success', 'تم إضافة المكافأة بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HrBonus $bonus)
    {
        return view('dashboard.pages.hr.bonuses.show', [
            'bonus' => $bonus,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HrBonus $bonus)
    {
        return view('dashboard.pages.hr.bonuses.edit', [
            'bonus' => $bonus,
            'employees' => $this->employeeOptions(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HrBonus $bonus)
    {
        $bonus->update($this->validate($request));
        return redirect()->route('dashboard.hr.bonuses.index')->with('success', 'تم تحديث المكافأة بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HrBonus $bonus)
    {
        $bonus->delete();
        return redirect()->route('dashboard.hr.bonuses.index')->with('success', 'تم حذف المكافأة بنجاح.');
    }
}

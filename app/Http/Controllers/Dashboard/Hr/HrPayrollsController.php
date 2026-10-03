<?php

namespace App\Http\Controllers\Dashboard\Hr;

use App\Http\Controllers\Controller;
use App\Models\HrEmployee;
use App\Models\HrPayroll;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HrPayrollsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pages.hr.payrolls.index', [
            'payrolls' => HrPayroll::latest()->paginate(10),
            'employees' => $this->employeeOptions(),
        ]);
    }

    protected function employeeOptions()
    {
        return HrEmployee::orderBy('name')->pluck('name', 'id');
    }

    protected function splitPeriod(string $period)
    {
        if (!$period) {
            return [null, null];
        }
        [$year, $month] = explode('-', $period);
        return [$year, $month];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pages.hr.payrolls.create', [
            'payroll' => new HrPayroll(),
            'employees' => $this->employeeOptions(),
        ]);
    }

    protected function validate(Request $request, ?HrPayroll $payroll=null)
    {
        $period = $request->input('period');
        [$year, $month] = $this->splitPeriod($period);
        return $request->validate([
            'employee_id' => ['required', 'exists:hr_employees,id',
                Rule::unique('hr_payrolls', 'employee_id')
                    ->ignore($payroll?->id)
                    ->where(fn($query) => $query->where('year', $year)->where('month', $month))],
            'period' => ['required',],
            'base_salary' => [ 'numeric', 'min:0'],
            'net_salary' => [ 'numeric', 'min:0'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, new HrPayroll());
        [$year , $month] = $this->splitPeriod($data['period']);
        $employee = HrEmployee::findOrFail($data['employee_id']);
        $totals = HrPayroll::totalsFor($employee, $year, $month);
        HrPayroll::create([
            'employee_id' => $data['employee_id'],
            'year' => $year,
            'month' => $month,
            'notes' => $data['notes'] ?? null,
            ...$totals,
            'status' => 'draft',
        ]);
        return redirect()
            ->route('dashboard.hr.payrolls.index')
            ->with('success', 'تم إنشاء الراتب بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HrPayroll $payroll)
    {
        return view('dashboard.pages.hr.payrolls.show', [
            'payroll' => $payroll,
            'employee' => $this->employeeOptions(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HrPayroll $payroll)
    {
        return view('dashboard.pages.hr.payrolls.edit', [
            'payroll' => $payroll,
            'employees' => $this->employeeOptions(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HrPayroll $payroll)
    {
        $data = $this->validate($request, $payroll);
        [$year , $month] = $this->splitPeriod($data['period']);
        $employee = HrEmployee::findOrFail($data['employee_id']);
        $totals = HrPayroll::totalsFor($employee, $year, $month);
        $payroll->update([
            'employee_id' => $data['employee_id'],
            'year' => $year,
            'month' => $month,
            'notes' => $data['notes'] ?? null,
            ...$totals,
        ]);
        return redirect()
            ->route('dashboard.hr.payrolls.index')
            ->with('success', 'تم تعديل الراتب بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HrPayroll $payroll)
    {
        $payroll->delete();
        return redirect()
            ->route('dashboard.hr.payrolls.index')
            ->with('success', 'تم حذف الراتب بنجاح.');
    }
}

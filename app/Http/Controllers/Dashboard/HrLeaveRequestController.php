<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HrLeaveRequest;
use Illuminate\Http\Request;
use App\Models\HrEmployee;

class HrLeaveRequestController extends Controller
{
    public function index()
    {
        $request = request();
        $query = HrLeaveRequest::query();
        $employeeId = $request->query('employee_id');
        $type = $request->query('type');
        $status = $request->query('status');
        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }
        if ($type) {
            $query->where('type', $type);
        }
        if ($status) {
            $query->where('status', $status);
        }
        return view('dashboard.pages.hr.leaves.index', [
            'leaves' => $query->with('employee')->get(),
            'employees' => $this->employeeOptions(),
        ]);
    }

    protected function employeeOptions() {
        return HrEmployee::orderBy('name')->pluck('name', 'id');
    }

    public function create()
    {
        return view('dashboard.pages.hr.leaves.create', [
            'leave' => new HrLeaveRequest,
            'employees' => $this->employeeOptions(),
        ]);
    }

    public function show(HrLeaveRequest $leave)
    {
        return view('dashboard.pages.hr.leaves.show', [
            'leave' => $leave,
            'employee' => $leave->employee,
            'employees' => $this->employeeOptions(),
        ]);
    }
    protected function validate(Request $request)
    {
        return $request->validate([
            'employee_id' => ['required', 'exists:hr_employees,id'],
            'type' => ['required', 'in:annual,sick,unpaid,emergency'],
            'status' => ['nullable', 'in:pending,approved,rejected'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['nullable', 'string'],
            'days' => ['nullable', 'integer', 'min:1'],
            'reviewed_at' => ['nullable', 'date'],
            'review_notes' => ['nullable', 'string'],
        ]);
    }
    public function store(Request $request)
    {
        $data = $this->validate($request);
        $data['days'] = HrLeaveRequest::calculateDays($data['start_date'], $data['end_date']);
        $data['status'] = 'pending'; // Set default status to pending
        HrLeaveRequest::create($data);
        return redirect()->route('dashboard.hr.leaves.index')->with('success', 'تم إنشاء طلب الإجازة بنجاح');
    }
    public function edit(HrLeaveRequest $leave)
    {
        return view('dashboard.pages.hr.leaves.edit', [
            'leave' => $leave,
            'employees' => $this->employeeOptions(),
        ]);
    }
    public function update(Request $request, HrLeaveRequest $leave)
    {
        $data = $this->validate($request);
        $data['days'] = HrLeaveRequest::calculateDays($data['start_date'], $data['end_date']);
        $leave->update($data);
        return redirect()->route('dashboard.hr.leaves.index')->with('success', 'تم تحديث طلب الإجازة بنجاح');
    }
    public function destroy(HrLeaveRequest $leave)
    {
        $leave->delete();
        return redirect()->route('dashboard.hr.leaves.index')->with('success', 'تم حذف طلب الإجازة بنجاح');
    }
    public function approve(HrLeaveRequest $leave)
    {
        $leave->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'review_notes' => request('review_notes'),
        ]);
        return redirect()->route('dashboard.hr.leaves.index')->with('success', 'تمت الموافقة على طلب الإجازة بنجاح');
    }
    public function reject(HrLeaveRequest $leave)
    {
        $leave->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
            'review_notes' => request('review_notes'),
        ]);
        return redirect()->route('dashboard.hr.leaves.index')->with('success', 'تم رفض طلب الإجازة بنجاح');
    }
}

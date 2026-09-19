<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HrDepartment;

class HrController extends Controller
{
    public function index()
    {
        $stats = [
            'departments_count' => HrDepartment::count(),
            // 'employees_count' => \App\Models\HrEmployee::count(),
            // 'active_employees_count' => \App\Models\HrEmployee::where('status', 'active')->count(),
            // 'inactive_employees_count' => \App\Models\HrEmployee::where('status', 'inactive')->count(),
        ];
        return view('dashboard.pages.hr.index',[
            'stats' => $stats,
        ]);
    }
}

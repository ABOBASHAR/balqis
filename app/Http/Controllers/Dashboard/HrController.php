<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HrDepartment;
use App\Models\HrEmployee;

class HrController extends Controller
{
    // This controller is responsible for just handling the HR dashboard and statistics
    // and nothing else, so we will just have an index method here to show the HR dashboard
    public function index()
    {
        $stats = [
            'departments_count' => HrDepartment::count(),
            'active_departments' => HrDepartment::where('status', 'active')->count(),
            'inactive_departments' => HrDepartment::where('status', 'inactive')->count(),
            'employees_count' => HrEmployee::count(),

        ];
        return view('dashboard.pages.hr.index',[
            'stats' => $stats,
        ]);
    }
}

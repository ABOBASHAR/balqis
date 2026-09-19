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
        ];
        return view('dashboard.pages.hr.index',[
            'stats' => $stats,
        ]);
    }
}

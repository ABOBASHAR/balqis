<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HrDepartment;

class HrController extends Controller
{
    // This controller is responsible for just handling the HR dashboard and statistics
    // and nothing else, so we will just have an index method here to show the HR dashboard
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

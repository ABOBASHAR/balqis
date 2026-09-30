<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Models\HrEmployee;

class HrEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HrEmployee::create([
            'name' => 'محمد عيدو',
            'email' => 'mohammededo188@gmail.com',
            'phone' => '0957220264',
            'department_id' => 1,
            'job_title' => 'مهندس برمجيات',
            'hire_date' => now()->toDateString(),
            'salary' => 1000,
            'status' => 'active',
            'address' => 'Idlib - Ariha',
        ]);
    }
}

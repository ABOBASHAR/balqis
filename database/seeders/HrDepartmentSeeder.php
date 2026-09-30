<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Models\HrDepartment;

class HrDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HrDepartment::create([
            'name' => 'DevOps',
            'description' => 'DevOps department',
        ]);
    }
}

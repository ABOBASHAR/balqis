<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Store::create([
            'name' => 'متجر الأمل',
            'description' => 'وصف متجر الأمل',
            'status' => 'Active',
        ]);
        Store::create([
            'name' => 'متجر النجاح',
            'description' => 'وصف متجر النجاح',
            'status' => 'Inactive',
        ]);
    }
}

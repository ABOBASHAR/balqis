<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'كهربائيات',
            'description' => 'منتجات كهربائية متنوعة',
            'status' => 'active',
        ]);
        Category::create([
            'name' => 'أثاث',
            'description' => 'منتجات أثاث متنوعة',
            'status' => 'inactive',
        ]);
        Category::create([
            'name' => 'ملابس',
            'description' => 'منتجات ملابس متنوعة',
            'status' => 'active',
        ]);
    }
}

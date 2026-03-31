<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Teknologi', 'slug' => 'teknologi'],
            ['name' => 'Pendidikan', 'slug' => 'pendidikan'],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

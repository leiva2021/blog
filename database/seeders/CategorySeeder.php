<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Tecnología', 'slug' => 'tecnologia'],
            ['name' => 'Deportes', 'slug' => 'deportes'],
            ['name' => 'Política', 'slug' => 'politica'],
            ['name' => 'Entretenimiento', 'slug' => 'entretenimiento'],
            ['name' => 'Salud', 'slug' => 'salud']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

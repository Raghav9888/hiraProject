<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Reiki',
            'Yoga',
            'Nutritional Support',
            'Energy Healing'
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
                'slug' => Str::slug($category),
                'description' => null,
                'created_by' => null, // Adjust if needed
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
    }
}

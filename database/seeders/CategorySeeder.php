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
            'category_1'=> [
                'name' => 'Reiki' ,
                'description' => null],
            'category_2'=> [
                'name' => 'Yoga' ,
                'description' => null],
            'category_3'=> [
                'name' => 'Nutritional Support' ,
                'description' => null],
            'category_4'=> [
                'name' => 'Energy Healing' ,
                'description' => null],
            'category_5'=> [
                'name' => 'Women’s Health and Hormonal Wellness' ,
                'description' => 'Services focusing on women’s health issues, including menopause support,
                    hormonal balancing, and reproductive health.'],
            'category_6'=> [
                'name' => 'Mindset and Transformational Coaching' ,
                'description' => 'Services aimed at personal development, confidence building, and overcoming limiting beliefs.'
            ],
            'category_7'=> [
                'name' => 'Energy Healing and Spiritual Guidance' ,
                'description' => 'Modalities like Reiki, shamanic healing, and intuitive readings to promote spiritual well-being.'
            ],
            'category_8'=> [
                'name' => 'Holistic Nutrition and Lifestyle Coaching' ,
                'description' => 'Dietary guidance, lifestyle adjustments, and overall wellness strategies.'
            ],
            'category_9' =>[
                'name' => 'Movement and Mindfulness Practices',
                'description' => 'Physical activity and mindfulness services, such as exercise, yoga, meditation, and somatic therapies.',
            ],
            'category_10' =>[
                'name' => 'Expressive Arts and Creative Therapies',
                'description' => 'Therapeutic practices using art, music, and other creative outlets for healing and self-expression.'

            ],
            'category_11' =>[
                'name' => 'Ecological and Nature-Based Healing',
                'description' => 'Therapies connecting individuals with nature to promote healing and ecological awareness.'
            ],

        ];


        foreach ($categories as $key => $category) {

            DB::table('categories')->insert([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'created_by' => null,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}

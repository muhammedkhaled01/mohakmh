<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            // main categories
            [
                "name" => "الاحكام الشكلية",
                "parent_id" => null,
                "image" => 'uploads/category-image/1696522200-5714-mony.jpg',
                "note" => 'يحتوي هذا القسم على كل الملفات المتعلقة ب الاحكام الشكلية',
                "status" => 'active',
            ],
            [
                "name" => "القضايا التجارية",
                "parent_id" => null,
                "image" => 'uploads/category-image/1696522200-5714-mony.jpg',
                "note" => 'يحتوي هذا القسم على كل الملفات المتعلقة ب القضايا التجارية ',
                "status" => 'active',
            ],
            [
                "name" => "قضايا الأوراق التجارية",
                "parent_id" => null,
                "image" => 'uploads/category-image/1696522200-5714-mony.jpg',
                "note" => 'يحتوي هذا القسم على كل الملفات المتعلقة ب قضايا الأوراق التجارية ',
                "status" => 'active',
            ],
            [
                "name" => "قضايا المقاولات",
                "parent_id" => null,
                "image" => 'uploads/category-image/1696522200-5714-mony.jpg',
                "note" => 'يحتوي هذا القسم على كل الملفات المتعلقة ب قضايا المقاولات ',
                "status" => 'active',
            ],
        ]);
    }
}

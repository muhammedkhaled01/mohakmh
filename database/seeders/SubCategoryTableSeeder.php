<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            // sub categories
            // CAT = 1
            [
                "name" => "عنوان فرعي الاحكام الشكلية 1",
                "parent_id" => 33,
                "image" => 'uploads/category-image/1696522200-5714-mony.jpg',
                "note" => 'يحتوي هذا القسم على كل الملفات المتعلقة ب عنوان فرعي الاحكام الشكلية  ',
                "status" => 'active',
            ],
            [
                "name" => "عنوان فرعي الاحكام الشكلية 2",
                "parent_id" => 33,
                "image" => 'uploads/category-image/1696522200-5714-mony.jpg',
                "note" => 'يحتوي هذا القسم على كل الملفات المتعلقة ب عنوان فرعي الاحكام الشكلية  ',
                "status" => 'active',
            ],
            [
                "name" => "عنوان فرعي الاحكام الشكلية 3",
                "parent_id" => 33,
                "image" => 'uploads/category-image/1696522200-5714-mony.jpg',
                "note" => 'يحتوي هذا القسم على كل الملفات المتعلقة ب عنوان فرعي الاحكام الشكلية  ',
                "status" => 'active',
            ],
            [
                "name" => "عنوان فرعي الاحكام الشكلية 4",
                "parent_id" => 33,
                "image" => 'uploads/category-image/1696522200-5714-mony.jpg',
                "note" => 'يحتوي هذا القسم على كل الملفات المتعلقة ب عنوان فرعي الاحكام الشكلية  ',
                "status" => 'active',
            ],

            // CAT = 2
            [
                "name" => "عنوان فرعي قضايا المقاولات 5",
                "parent_id" => 34,
                "image" => 'uploads/category-image/1696522200-5714-mony.jpg',
                "note" => 'يحتوي هذا القسم على كل الملفات المتعلقة ب عنوان فرعي قضايا المقاولات  ',
                "status" => 'active',
            ],
            [
                "name" => "عنوان فرعي قضايا المقاولات 6",
                "parent_id" => 34,
                "image" => 'uploads/category-image/1696522200-5714-mony.jpg',
                "note" => 'يحتوي هذا القسم على كل الملفات المتعلقة ب عنوان فرعي قضايا المقاولات  ',
                "status" => 'active',
            ],
            [
                "name" => "عنوان فرعي قضايا المقاولات 7",
                "parent_id" => 34,
                "image" => 'uploads/category-image/1696522200-5714-mony.jpg',
                "note" => 'يحتوي هذا القسم على كل الملفات المتعلقة ب عنوان فرعي قضايا المقاولات  ',
                "status" => 'active',
            ],
            [
                "name" => "عنوان فرعي قضايا المقاولات 8",
                "parent_id" => 34,
                "image" => 'uploads/category-image/1696522200-5714-mony.jpg',
                "note" => 'يحتوي هذا القسم على كل الملفات المتعلقة ب عنوان فرعي قضايا المقاولات  ',
                "status" => 'active',
            ],

            // CAT = 3
            [
                "name" => "عنوان فرعي قضايا الأوراق التجارية 9",
                "parent_id" => 35,
                "image" => 'uploads/category-image/1696522200-5714-mony.jpg',
                "note" => 'يحتوي هذا القسم على كل الملفات المتعلقة ب عنوان فرعي قضايا الأوراق التجارية  ',
                "status" => 'active',
            ],
            [
                "name" => "عنوان فرعي قضايا الأوراق التجارية 10",
                "parent_id" => 35,
                "image" => 'uploads/category-image/1696522200-5714-mony.jpg',
                "note" => 'يحتوي هذا القسم على كل الملفات المتعلقة ب عنوان فرعي قضايا الأوراق التجارية  ',
                "status" => 'active',
            ],
            [
                "name" => "عنوان فرعي قضايا الأوراق التجارية 11",
                "parent_id" => 35,
                "image" => 'uploads/category-image/1696522200-5714-mony.jpg',
                "note" => 'يحتوي هذا القسم على كل الملفات المتعلقة ب عنوان فرعي قضايا الأوراق التجارية  ',
                "status" => 'active',
            ],
            [
                "name" => "عنوان فرعي قضايا الأوراق التجارية 12",
                "parent_id" => 35,
                "image" => 'uploads/category-image/1696522200-5714-mony.jpg',
                "note" => 'يحتوي هذا القسم على كل الملفات المتعلقة ب عنوان فرعي قضايا الأوراق التجارية  ',
                "status" => 'active',
            ],

            // CAT = 4
            [
                "name" => "عنوان فرعي القضايا التجارية 13",
                "parent_id" => 36,
                "image" => 'uploads/category-image/1696522200-5714-mony.jpg',
                "note" => 'يحتوي هذا القسم على كل الملفات المتعلقة ب عنوان فرعي القضايا التجارية  ',
                "status" => 'active',
            ],
            [
                "name" => "عنوان فرعي القضايا التجارية 14",
                "parent_id" => 36,
                "image" => 'uploads/category-image/1696522200-5714-mony.jpg',
                "note" => 'يحتوي هذا القسم على كل الملفات المتعلقة ب عنوان فرعي القضايا التجارية  ',
                "status" => 'active',
            ],
            [
                "name" => "عنوان فرعي القضايا التجارية 15",
                "parent_id" => 36,
                "image" => 'uploads/category-image/1696522200-5714-mony.jpg',
                "note" => 'يحتوي هذا القسم على كل الملفات المتعلقة ب عنوان فرعي القضايا التجارية  ',
                "status" => 'active',
            ],
            [
                "name" => "عنوان فرعي القضايا التجارية 16",
                "parent_id" => 36,
                "image" => 'uploads/category-image/1696522200-5714-mony.jpg',
                "note" => 'يحتوي هذا القسم على كل الملفات المتعلقة ب عنوان فرعي القضايا التجارية  ',
                "status" => 'active',
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::insert([
            [
                'name' => 'اسم الكتاب 1',
                'category_id' => 70,
                'paid' => 1,
                'description' => 'وصف الكتاب',
                'note' => 'ملاحظات الكتاب',
                'file' => 'uploads/books/pdf-test/1698332794-2692-pdf-test.pdf',
                'status' => 'converting',
            ],
            [
                'name' => 'اسم الكتاب 2',
                'category_id' => 70,
                'paid' => 0,
                'description' => 'وصف الكتاب',
                'note' => 'ملاحظات الكتاب',
                'file' => 'uploads/books/upper-level-vocabulary-25/1698333549-8150-upper-level-vocabulary-25.pdf',
                'status' => 'converting',
            ],
            [
                'name' => 'اسم الكتاب 3',
                'category_id' => 72,
                'paid' => 1,
                'description' => 'وصف الكتاب',
                'note' => 'ملاحظات الكتاب',
                'file' => 'uploads/books/pdf-test/1698332794-2692-pdf-test.pdf',
                'status' => 'converting',
            ],
            [
                'name' => 'اسم الكتاب 4',
                'category_id' => 72,
                'paid' => 0,
                'description' => 'وصف الكتاب',
                'note' => 'ملاحظات الكتاب',
                'file' => 'uploads/books/upper-level-vocabulary-25/1698333549-8150-upper-level-vocabulary-25.pdf',
                'status' => 'converting',
            ],
            [
                'name' => 'اسم الكتاب 5',
                'category_id' => 75,
                'paid' => 1,
                'description' => 'وصف الكتاب',
                'note' => 'ملاحظات الكتاب',
                'file' => 'uploads/books/pdf-test/1698332794-2692-pdf-test.pdf',
                'status' => 'converting',
            ],
            [
                'name' => 'اسم الكتاب 6',
                'category_id' => 75,
                'paid' => 0,
                'description' => 'وصف الكتاب',
                'note' => 'ملاحظات الكتاب',
                'file' => 'uploads/books/upper-level-vocabulary-25/1698333549-8150-upper-level-vocabulary-25.pdf',
                'status' => 'converting',
            ],
            [
                'name' => 'اسم الكتاب 7',
                'category_id' => 75,
                'paid' => 0,
                'description' => 'وصف الكتاب',
                'note' => 'ملاحظات الكتاب',
                'file' => 'uploads/books/upper-level-vocabulary-25/1698333549-8150-upper-level-vocabulary-25.pdf',
                'status' => 'converting',
            ],
            [
                'name' => 'اسم الكتاب 8',
                'category_id' => 80,
                'paid' => 1,
                'description' => 'وصف الكتاب',
                'note' => 'ملاحظات الكتاب',
                'file' => 'uploads/books/pdf-test/1698332794-2692-pdf-test.pdf',
                'status' => 'converting',
            ],
            [
                'name' => 'اسم الكتاب 9',
                'category_id' => 80,
                'paid' => 0,
                'description' => 'وصف الكتاب',
                'note' => 'ملاحظات الكتاب',
                'file' => 'uploads/books/upper-level-vocabulary-25/1698333549-8150-upper-level-vocabulary-25.pdf',
                'status' => 'converting',
            ],
            [
                'name' => 'اسم الكتاب 10',
                'category_id' => 80,
                'paid' => 0,
                'description' => 'وصف الكتاب',
                'note' => 'ملاحظات الكتاب',
                'file' => 'uploads/books/upper-level-vocabulary-25/1698333549-8150-upper-level-vocabulary-25.pdf',
                'status' => 'converting',
            ],
        ]);
    }
}

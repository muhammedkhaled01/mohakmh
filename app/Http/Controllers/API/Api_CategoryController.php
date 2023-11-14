<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class Api_CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function categories(Request $request)
    {
        $categories = Category::where('parent_id', null)->with(['children'])->get();
        $response = [
            'status' => true,
            'message' => 'you have all categories details',
            'data' => $categories,
        ];
        return response()->json($response, 200);
    }
    public function category($category)
    {
        $category = Category::find($category);

        if ($category) {

            $subcategories = $category->children;

            $data = [];
            foreach ($subcategories as $key => $subcategory) {
                $data[] = [
                    'name_subcategory' => $subcategory->name,
                    'books' => $subcategory->books()->with('bookimages')->get(),
                ];
            }
            $response = [
                'status' => true,
                'message' => 'you have one category',
                'data' => $data,
            ];
        } else {

            $response = [
                'status' => false,
                'message' => 'not found category id:' . $category,
                'data' => [],
            ];
        }

        return response()->json($response);
    }

    public function mainCategory(Category $category, $id)
    {
        // يتم جلب القسم الرءيسي مع اقسامه الفرعية حسب رقم القسم القادم
        $mainCategory = Category::where('id', $id)->with('children')->first();

        if (!$mainCategory) {
            $response = [
                'status' => true,
                'message' => "dose not exist category id: $id",
            ];
            return response()->json($response);
        }

        $usbCategoryBooks = collect();
        // هنا لوب ليتم جلب الكتب التابعة لكل قسم فرعي
        // تخزن في كوليكشن
        foreach ($mainCategory->children as $subcateygory) {
            $books = Book::where('category_id', $subcateygory->id)->with('firstImage')->select('id', 'name', 'category_id', 'paid', 'description', 'note', 'status')->get();
            // $usbCategoryBooks = array_merge($usbCategoryBooks, $books);
            $usbCategoryBooks = $usbCategoryBooks->merge($books);
        }
        //return response()->json($usbCategoryBooks);

        // اذا الكوليكشن فارغ فش كتب
        if ($usbCategoryBooks->isEmpty()) {
            $response = [
                'status' => true,
                'message' => "there is no books for category id: $id",
                'data' => $usbCategoryBooks,
            ];
            return response()->json($response);
        }

        $response = [
            'status' => true,
            'message' => "you have all book for category id: $id",
            'data' => $usbCategoryBooks,
        ];
        return response()->json($response);
    }
}

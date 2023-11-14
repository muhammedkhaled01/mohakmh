<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advantage;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Message;
use Illuminate\Http\Request;

class IntroductionPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ideas = Idea::all();
        $messages = Message::all();
        $advantages = Advantage::all();
        return view('admin.introductionpages.index', compact('ideas', 'messages', 'advantages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = new Category();
        $parents = Category::all();
        return view('admin.categories.create', compact('category', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $clean_data فيها البيانات التي فحصت بنجاح فقط
        $clean_data = $request->validate(Category::rules(), [
            'unique' => 'هذا  (:attribute) موجود بالفعل!',
            'required' => 'هذا الحقل مطلوب',
        ]);
        $category = Category::create($request->all());
        return Redirect()->route('dashboard.categories.index')->with('success', 'تم انشاء قسم جديد بنجاح'); // redirect will return object that have method route
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        try {
            $category = Category::findOrFail($category->id);
        } catch (\Throwable $th) {
            //abort(404);
            return redirect()->route('admin.categories.index')->with('info', 'هذا القسم غير موجود');
        }

        $parents = Category::where('id', '<>', $category->id)
            ->where(function ($quary) use ($category) {
                $quary->whereNull('parent_id')->orWhere('parent_id', '<>', $category->id);
            })->get();
        return view('admin.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate(Category::rules($category->id));
        try {
            $category = Category::findOrFail($category->id);
        } catch (\Throwable $th) {
            //abort(404);
            return redirect()->route('admin.categories.index')->with('info', 'هذا القسم غير موجود');
        }
        //$category->fill($request->all())->save();
        $category->update($request->all());
        return Redirect()->route('dashboard.categories.index')->with('success', 'تم حديث القسم بنجاح!'); // redirect will return object that have method route
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // way 1
        $category = Category::findOrFail($category->id);
        $category->delete();
        return Redirect()->route('dashboard.categories.index')->with('danger', 'تم حذف القسم بنجاح!');
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->orderByDesc('deleted_at')->paginate();
        return view('admin.categories.trash', compact('categories'));
    }
    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('dashboard.categories.trash')->with('success', 'تم استعادة القسم بنجاح');
    }
    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        return redirect()->route('dashboard.categories.trash')->with('danger', 'تم حذف القسم بنجاح');
    }
}

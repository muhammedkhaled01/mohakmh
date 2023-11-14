<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orderBy = 'id';
        $direction = 'ASC';

        $itemsPerPage = $request->input('itemsPerPage', 10);
        if ($itemsPerPage <= 0 || $itemsPerPage > 50) {
            $itemsPerPage = 10;
        }
        if ($request->query('orderBy')) {
            $orderBy = $request->query('orderBy');
        }
        if ($request->query('direction')) {
            $direction = $request->query('direction');
        }
        // this is relation in model way to get parent name
        $categories = Category::with('parent')
            ->filter($request->query())
            ->orderBy($orderBy, $direction)
            ->paginate($itemsPerPage); // Return collection object work like array

        return view('admin.categories.index', compact('categories'));
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

        // اضافة الصورة
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request);
        }

        $category = Category::create($data);
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

        // تحديث الصورة
        $old_file = $category->image;
        $data = $request->except('image');

        // file upload
        if ($request->hasFile('image')) {
            $file = $this->uploadFile($request);
            $data['image'] = $file;
            if ($old_file) {
                Storage::disk('public')->delete($old_file);
            }
        }

        //$category->fill($request->all())->save();
        $category->update($data);
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

    protected function uploadFile(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }
        $file = $request->file('image');
        $file_name = time() . '-' . rand(5, 100) . rand(5, 100) .  '-' . $file->getClientOriginalName();
        $path = $file->move(public_path('storage/uploads/category-image'), $file_name);
        $file_name = 'uploads/category-image/' . $file_name;
        // $path = $file->storeAs('uploads/category-image', $file_name, 'public');
        return $file_name;
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

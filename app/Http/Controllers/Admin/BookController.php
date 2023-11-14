<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use Normalizer;
use Carbon\Carbon;
use App\Models\Book;
use App\Models\Category;
use App\Models\BookImage;
use Spatie\PdfToImage\Pdf;
use App\Jobs\PdfConvertJob;
use App\Jobs\PdfConvertJob1;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
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
        $books = Book::filter($request->query())
            ->orderBy($orderBy, $direction)
            ->paginate($itemsPerPage); // Return collection object work like array
        $bookImages = BookImage::all();

        return view('admin.books.index', compact('books', 'bookImages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $book = new Book();
        $categories = Category::where("parent_id" , null)->get()->all();
//        $categoryIds = $categories->pluck('id')->toArray();
//        $categoryIds = $categories['id'];
//        dd($categoryIds);

        $subCategories = Category::get();
//        dd($subCategories);
        return view('admin.books.create', compact('book', 'categories' , 'subCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $clean_data فيها البيانات التي فحصت بنجاح فقط
        $clean_data = $request->validate(Book::rules());

        // استخراج الاسم للملف
        $file_name = $request->file->getClientOriginalName();
        $file_name_with_underscores = str_replace(' ', '_', $file_name);
        $file_name_without_extension = pathinfo($file_name_with_underscores, PATHINFO_FILENAME);
        // return $file_name_without_extension;

        // انشاء المجلد
        $folderPath = public_path('storage/uploads/books/' . $file_name_without_extension); // Replace with the desired folder path
        File::makeDirectory($folderPath, 0775, true, true);

        // اضافة الملف
        $data = $request->except('file');
        $data['status'] = 'converting';

        if ($request->hasFile('file')) {
            $data['file'] = $this->uploadFile($request, $file_name_without_extension);
        }

        $book = Book::create($data);

        // $pdf = new Pdf(public_path('storage/' . $data['file']));

        // $pdf = new Pdf(public_path('storage/' . 'uploads/books/pdf-test/pdf-test.pdf'));
        // $pdf->setOutputFormat('png')->saveAllPagesAsImages(public_path("storage/uploads/books/$file_name_without_extension"), null, $book->id);

        dispatch(new PdfConvertJob1($data['file'], $file_name_without_extension, $book->id));
        // dispatch(new PdfConvertJob1($data['file'], $file_name_without_extension, $book->id))->onQueue('pdf_convert');
        // dispatch(new PdfConvertJob1($data['file'], $file_name_without_extension, $book->id));
        // dispatch(new PdfConvertJob($data['file'], $file_name_without_extension, '2-'))->onQueue('pdf_convert-2');
        // dispatch(new PdfConvertJob($data['file'], $file_name_without_extension, '3-'))->onQueue('pdf_convert-3');
        // dispatch(new PdfConvertJob($data['file'], $file_name_without_extension, '4-'))->onQueue('pdf_convert-4');
        // dispatch(new PdfConvertJob($data['file'], $file_name_without_extension, '5-'))->onQueue('pdf_convert-5');

        return Redirect()->route('dashboard.books.index')->with('success', 'جاري تحضير الكتاب'); // redirect will return object that have method route
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {

        try {
            $book = Book::where('id', $book->id)->first();
            if (!$book) {
                return redirect()->route('dashboard.books.index')->with('info', 'هذا الكتاب غير موجود');
            }
            if ($book->status === 'converting') {
                return redirect()->route('dashboard.books.index')->with('info', "لا يمكن التعديل على كتاب $book->name حاليا برقم $book->id");
            }
        } catch (Throwable $th) {
            return redirect()->route('dashboard.books.index')->with('info', 'هذا الكتاب غير موجود');
        }

        $categories = Category::all();
        $pdf_name = basename(public_path('storage/' . $book->file));
        //return $pdf_name;
        return view('admin.books.edit', compact('book', 'categories', 'pdf_name'));
    }

    // يعرض الملفات
    public function view(Book $book)
    {
        return response()->file(public_path('storage/' . $book->file), ['content-type' => 'application/pdf']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $request->validate(Book::rules($book->id));
        try {
            $book = Book::findOrFail($book->id);
        } catch (\Throwable $th) {
            //abort(404);
            return redirect()->route('dashboard.books.index')->with('info', 'هذا الكتاب غير موجود');
        }

        // تحديث الملف
        $old_file = $book->file;
        $data = $request->except('file');

        if ($request->hasFile('file')) {

            // استخراج الاسم للملف
            $file_name = $request->file->getClientOriginalName();
            $file_name_with_underscores = str_replace(' ', '_', $file_name);
            $file_name_without_extension = pathinfo($file_name_with_underscores, PATHINFO_FILENAME);
            // return $file_name_without_extension;

            // انشاء المجلد
            $folderPath = public_path('storage/uploads/books/' . $file_name_without_extension); // Replace with the desired folder path
            File::makeDirectory($folderPath, 0775, true, true);

            // اضافة الملف
            $data = $request->except('file');
            if ($request->hasFile('file')) {
                $data['file'] = $this->uploadFile($request, $file_name_without_extension);
            }

            $bookimages = BookImage::where('book_id', $book->id)->get();
            if (!$bookimages->isEmpty()) {
                foreach ($bookimages as $bookImage) {
                    $bookImage->delete();
                }
            }

            dispatch(new PdfConvertJob1($data['file'], $file_name_without_extension, $book->id))->onQueue('pdf_convert');
        }


        $book->update($data);
        return Redirect()->route('dashboard.books.index')->with('success', 'تم حديث القسم بنجاح!'); // redirect will return object that have method route
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // way 1
        $book = Book::findOrFail($book->id);
        $book->delete();
        return Redirect()->route('dashboard.books.index')->with('danger', 'تم حذف الكتاب بنجاح!');
    }

    protected function uploadFile(Request $request, $folder)
    {
        if (!$request->hasFile('file')) {
            return;
        }
        $file = $request->file('file');
        $file_name = time() . '-' . rand(5, 100) . rand(5, 100) .  '-' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads/books/' . $folder, $file_name, 'public');
        $file->move(public_path('storage/uploads/books/' . $folder), $file_name);
        /* $path = $file_name->store('uploads/books', [
            'disk' => 'public'
        ]); */
        return $path;
    }

    public function trash()
    {
        $books = Book::onlyTrashed()->orderByDesc('deleted_at')->paginate();
        return view('admin.books.trash', compact('books'));
    }
    public function restore(Request $request, $id)
    {
        $book = Book::onlyTrashed()->findOrFail($id);
        $book->restore();
        return redirect()->route('dashboard.books.trash')->with('success', 'تم استعادة الكتاب بنجاح');
    }
    public function forceDelete($id)
    {
        $book = Book::onlyTrashed()->findOrFail($id);
        $book->forceDelete();
        return redirect()->route('dashboard.books.trash')->with('danger', 'تم حذف الكتاب بنجاح');
    }
}

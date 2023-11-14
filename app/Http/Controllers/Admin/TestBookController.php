<?php

namespace App\Http\Controllers\Admin;

use Normalizer;
use Carbon\Carbon;
use App\Models\Book;
//use Spatie\PdfToImage\Pdf;
use App\Models\Category;
//use Ottosmops\Pdftotext\Extract;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use Ottosmops\Pdftotext\Extract;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use Spatie\PdfToImage\Pdf;
use Org_heigl\Ghostscript\Ghostscript;
use PHPUnit\Framework\Constraint\FileExists;
use Spatie\PdfToImage\Imagick;

use function PHPUnit\Framework\directoryExists;

//use Imagick;

///////////////////////////////////////////////////////////////////////////////// test page
///////////////////////////////////////////////////////////////////////////////// test page
///////////////////////////////////////////////////////////////////////////////// test page
///////////////////////////////////////////////////////////////////////////////// test page
///////////////////////////////////////////////////////////////////////////////// test page

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orderBy = 'id';
        $direction = 'ASC';

        $itemsPerPage = $request->input('itemsPerPage', 5);
        if ($itemsPerPage <= 0 || $itemsPerPage > 50) {
            $itemsPerPage = 5;
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

        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $book = new Book();
        $categories = Category::all();
        return view('admin.books.create', compact('book', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /* if (extension_loaded('imagick')) {
            return 'Imagick extension is installed.';
        } else {
            return 'Imagick extension is not installed.';
        } */

        // استخراج الاسم للملف
        // $file_name = $request->file->getClientOriginalName();
        // $file_name_with_underscores = str_replace(' ', '_', $file_name);
        // $file_name_without_extension = pathinfo($file_name_with_underscores, PATHINFO_FILENAME);
        // return $file_name_without_extension;

        //return $request;
        // $clean_data فيها البيانات التي فحصت بنجاح فقط
        $clean_data = $request->validate(Book::rules());

        // انشاء المجلد
        // $folderPath = public_path('bookImages/' . $file_name_without_extension); // Replace with the desired folder path
        // File::makeDirectory($folderPath, 0775, true, true);

        // فحص الاذونات
        /* $folderPath = public_path('bookImages/' . $file_name_without_extension);
        // Get the permissions as an octal number
        $permissions = fileperms($folderPath);
        // Convert the octal number to a string representation
        $permissionsString = substr(sprintf('%o', $permissions), -4);
        return $permissionsString; */

        // اضافة الملف
        $data = $request->except('file');
        if ($request->hasFile('file')) {
            $data['file'] = $this->uploadFile($request);
        }

        // error here
        $pdf = new Pdf(public_path('bookImages/1695295250-8438-Flutter Cheatsheet.pdf'));
        $pdf->saveAllPagesAsImages(public_path('bookImages'));
        return 'true';

        $book = Book::create($data);
        return Redirect()->route('dashboard.books.index')->with('success', 'تم اضافة كتاب جديد بنجاح'); // redirect will return object that have method route
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
            $book = Book::findOrFail($book->id);
        } catch (\Throwable $th) {
            //abort(404);
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

        // file upload
        if ($request->hasFile('file')) {
            $file = $this->uploadFile($request);
            $data['file'] = $file;
            Storage::disk('public')->delete($old_file);
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

    protected function uploadFile(Request $request)
    {
        if (!$request->hasFile('file')) {
            return;
        }
        // ازالة المسار و الامتداد ليتبقي الاسم فقط 
        $file_name = $request->file->getClientOriginalName();
        $file_name_with_underscores = str_replace(' ', '_', $file_name);
        $file_name_without_extension = pathinfo($file_name_with_underscores, PATHINFO_FILENAME);

        $currentYear = Carbon::now()->year;
        $file = $request->file('file');
        $file_name = time() . '-' . rand(5, 100) . rand(5, 100) .  '-' . $file->getClientOriginalName();
        // $path = $file->storeAs('uploads/books/' . $file_name_without_extension, $file_name, 'public');
        $path = $file->move(public_path('bookImages/' . $file_name_without_extension), $file_name);
        /* $path = $file_name->store('uploads/books', [
            'disk' => 'public'
        ]); */
        return $path;
    }

    /* protected function uploadFileBookImage(Request $request)
    {
        if (!$request->hasFile('file')) {
            return;
        }
        $currentYear = Carbon::now()->year;
        $file = $request->file('file');
        $file_name = time() . '-' . rand(5, 100) . rand(5, 100) .  '-' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads/book_images', $file_name, 'public');
        return $path;
    } */

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

    // public function convertpdf()
    // {
    //     // using parser library
    //     // Parse PDF file and build necessary objects.
    //     // $parser = new Parser();
    //     // $pdf = $parser->parseFile(public_path('storage/uploads/books/oXblizkMFiBSFvpiFnUDao65Ic2o0zc9vZ1dL7h4.pdf'));
    //     // $text = $pdf->getText();

    //     // //Remove any whitespace or non-Arabic characters
    //     // $text = preg_replace('/[^اأبتثجحخدذرزسشصضطظعغفقكلمنهويى]/u', '', $text);
    //     // //Convert to UTF-8 encoding
    //     // $text = mb_convert_encoding($text, 'UTF-8', 'auto');
    //     // echo $text;


    //     // Normalize the text to remove diacritics and format characters
    //     // $normalizedText = Normalizer::normalize($text, Normalizer::FORM_C);

    //     // echo $normalizedText;
    //     // Remove any non-Arabic characters
    //     // $cleanedText = preg_replace('/[^اأبتثجحخدذرزسشصضطظعغفقكلمنهويى\s]+/u', '', $text);

    //     // echo $cleanedText;

    //     /* $text = "يبيرجت ";

    //     // Remove any non-Arabic characters
    //     $cleanedText = preg_replace('/[^اأبتثجحخدذرزسشصضطظعغفقكلمنهويى\s]+/u', '', $text);

    //     // Convert to UTF-8 encoding
    //     $utf8Text = iconv(mb_detect_encoding($cleanedText, mb_detect_order(), true), 'utf8mb4_general_ci', $cleanedText);

    //     echo $utf8Text; */


    //     //using pdftotext library
    //     // $text = (new Extract())->pdf(public_path('storage/uploads/oXblizkMFiBSFvpiFnUDao65Ic2o0zc9vZ1dL7h4.pdf'))->text();
    //     // echo $text;

    //     $pdfFilePath = public_path('storage/uploads/books/zsKAmmi5MKKk0AnPgOOrIaX9zg1qEEUrGHW5UXig.pdf');

    //     // // Execute pdftotext and capture the output
    //     $output = shell_exec("pdftotext -enc UTF-8 \"$pdfFilePath\" -");

    //     // Output the extracted text
    //     echo $output;
    // }

    // public function converttoimage()
    // {
    //     // Define the path to your PDF file
    //     $pdfFilePath = public_path('storage/uploads/books/zsKAmmi5MKKk0AnPgOOrIaX9zg1qEEUrGHW5UXig.pdf');

    //     // Convert the PDF page to a JPEG image
    //     $pdf = new Pdf($pdfFilePath);
    //     $imagePath = public_path('storage/uploads/books/page_image.jpg'); // Define the image path with .jpg extension
    //     $pdf->setOutputFormat('jpeg')->saveImage($imagePath);

    //     // Output the path to the extracted image
    //     echo 'Image saved at: ' . $imagePath;

    //     // Extract text from the PDF
    //     $text = shell_exec("pdftotext -enc UTF-8 \"$pdfFilePath\" -");

    //     // Output the extracted text
    //     echo $text;
    // }

    // public function convertToImages()
    // {
    //     // Path to the PDF file
    //     $pdfPath = public_path('storage/uploads/books/1694956803-6888-ملف تجريبي.pdf'); // Replace with the actual path to your PDF file

    //     // Output directory for images
    //     $outputPath = public_path('storage/uploads/books/images'); // Replace with the desired output path

    //     $pdf = new Pdf($pdfPath);
    //     $pdf->saveImage($outputPath);

    //     /* Ghostscript::setGsPath("C:\Program Files\gs\gs10.02.0\bin\gswin64.exe");

    //     $pdf = new Pdf($pdfPath);

    //     $pdf->setOutputFormat('png')->saveImage($outputPath);
    //     */

    //     // $imagePaths = [];

    //     // // Convert each page of the PDF to an image
    //     // for ($i = 1; $i <= $pdf->getNumberOfPages(); $i++) {
    //     //     $imagePath = $outputPath . 'page_' . $i . '.png';
    //     //     $pdf->setPage($i)->saveImage($imagePath);
    //     //     $imagePaths[] = asset('storage/images/page_' . $i . '.png'); // Adjust the path as needed
    //     // }

    //     // return response()->json(['image_paths' => $imagePaths]);
    // }
}

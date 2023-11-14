<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Report;
use ArPHP\I18N\Arabic;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Package;
use App\Models\Subscription;
use Illuminate\Support\Facades\Storage;


class ReportController extends Controller
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
        $reports = Report::filter($request->query())
            ->orderBy($orderBy, $direction)
            ->paginate($itemsPerPage);

        return view('admin.reports.index', compact('reports'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        // way 1
        $report = Report::findOrFail($report->id);
        $report->delete();
        return Redirect()->route('dashboard.reports.index')->with('danger', 'تم حذف التقرير بنجاح!');
    }

    public function trash()
    {
        $reports = Report::onlyTrashed()->orderByDesc('deleted_at')->paginate();
        return view('admin.reports.trash', compact('reports'));
    }
    public function restore(Request $request, $id)
    {
        $report = Report::onlyTrashed()->findOrFail($id);
        $report->restore();
        return redirect()->route('dashboard.reports.trash')->with('success', 'تم استعادة التقرير بنجاح');
    }
    public function forceDelete($id)
    {
        $report = Report::onlyTrashed()->findOrFail($id);
        Storage::disk('public')->delete($report->name);
        $report->forceDelete();
        return redirect()->route('dashboard.reports.trash')->with('danger', 'تم حذف التقرير بنجاح');
    }


    public function generateGeneralReport()
    {

        $users = User::select(['id', 'name', 'email', 'phone_number', 'image', 'job', 'package_id', 'role'])->get();
        $deleted_users = User::withTrashed()->where('deleted_at', '<>', null)->select(['id', 'name', 'email', 'phone_number', 'image', 'job', 'package_id', 'role'])->get();
        $packages = Package::all();
        $subscribtions = Subscription::all();

        //return $deleted_users;

        $html = view('admin.reports.general', compact('users', 'deleted_users', 'packages', 'subscribtions'))->render();

        $Arabic = new Arabic();
        $p = $Arabic->arIdentify($html);
        for ($i = count($p) - 1; $i >= 0; $i -= 2) {
            $utf8ar = $Arabic->utf8Glyphs(substr($html, $p[$i - 1], $p[$i] - $p[$i - 1]));
            $html = substr_replace($html, $utf8ar, $p[$i - 1], $p[$i] - $p[$i - 1]);
        }

        $pdf = Pdf::loadHTML($html);
        $directory = public_path('storage/uploads/reports');

        // Ensure the directory exists; create it if it doesn't
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Generate a unique file name for the PDF with the .pdf extension
        $currentDate = Carbon::now();
        $file_name = 'التقرير العام' . '-' . $currentDate->format('Y-m-d') . '.pdf';

        // Save the PDF content to the file
        $pdf->save($directory . '/' . $file_name);

        $file = Report::create([
            'name' => "uploads/reports/$file_name",
            'note' => null,
        ]);
        // Return the file path (including directory)
        return redirect()->route('dashboard.reports.index');
    }

    // convert html to pdf
    public function generateUserReport()
    {
        // جلب كل المستخدمين الجدد لاخر 7 ايام
        // $users = User::whereDate('created_at', now()->subDays(7))->get();
        $startDate = now()->subDays(7)->startOfDay();  // Start of 7 days ago
        $endDate = now()->startOfDay();  // Start of the current day

        $users = User::where('created_at', '>=', $startDate)
            ->where('created_at', '<', $endDate)
            ->select(['id', 'name', 'email', 'phone_number', 'image', 'job', 'package_id', 'role'])
            ->get();
        $deleted_users = User::withTrashed()->where('deleted_at', '<>', null)->select(['id', 'name', 'email', 'phone_number', 'image', 'job', 'package_id', 'role'])->get();
        // return $users;

        $html = view('admin.reports.users', compact('users', 'deleted_users'))->render();

        $Arabic = new Arabic();
        $p = $Arabic->arIdentify($html);
        for ($i = count($p) - 1; $i >= 0; $i -= 2) {
            $utf8ar = $Arabic->utf8Glyphs(substr($html, $p[$i - 1], $p[$i] - $p[$i - 1]));
            $html = substr_replace($html, $utf8ar, $p[$i - 1], $p[$i] - $p[$i - 1]);
        }

        $pdf = Pdf::loadHTML($html);
        $directory = public_path('storage/uploads/reports');

        // Ensure the directory exists; create it if it doesn't
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Generate a unique file name for the PDF with the .pdf extension
        $currentDate = Carbon::now();
        $file_name = 'التقرير الأسبوعي للمستخدمين' . '-' . $currentDate->format('Y-m-d') . '.pdf';

        // Save the PDF content to the file
        $pdf->save($directory . '/' . $file_name);

        $file = Report::create([
            'name' => "uploads/reports/$file_name",
            'note' => null,
        ]);
        // Return the file path (including directory)
        return redirect()->route('dashboard.reports.index');
    }

    // convert html to pdf
    public function generatePackageReport()
    {
        $packages = Package::select(['id', 'name', 'price', 'new_price', 'duration', 'free_duration', 'subscribers'])
            ->with(['users', 'advantages'])
            ->get();

        $html = view('admin.reports.packages', compact('packages'))->render();

        $Arabic = new Arabic();
        $p = $Arabic->arIdentify($html);
        for ($i = count($p) - 1; $i >= 0; $i -= 2) {
            $utf8ar = $Arabic->utf8Glyphs(substr($html, $p[$i - 1], $p[$i] - $p[$i - 1]));
            $html = substr_replace($html, $utf8ar, $p[$i - 1], $p[$i] - $p[$i - 1]);
        }

        $pdf = Pdf::loadHTML($html);
        $directory = public_path('storage/uploads/reports');

        // Ensure the directory exists; create it if it doesn't
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Generate a unique file name for the PDF with the .pdf extension
        $currentDate = Carbon::now();
        $file_name = 'التقرير الأسبوعي للباقات' . '-' . $currentDate->format('Y-m-d') . '.pdf';

        // Save the PDF content to the file
        $pdf->save($directory . '/' . $file_name);

        $file = Report::create([
            'name' => "uploads/reports/$file_name",
            'note' => null,
        ]);
        // Return the file path (including directory)
        return redirect()->route('dashboard.reports.index');
    }

    public function generateSubscriptionReport()
    {
        $subscribtions = Subscription::select(['id', 'user_id', 'package_id', 'start_at', 'end_at'])
            ->with(['user', 'package'])
            ->get();

        $html = view('admin.reports.subscribtions', compact('subscribtions'))->render();

        $Arabic = new Arabic();
        $p = $Arabic->arIdentify($html);
        for ($i = count($p) - 1; $i >= 0; $i -= 2) {
            $utf8ar = $Arabic->utf8Glyphs(substr($html, $p[$i - 1], $p[$i] - $p[$i - 1]));
            $html = substr_replace($html, $utf8ar, $p[$i - 1], $p[$i] - $p[$i - 1]);
        }

        $pdf = Pdf::loadHTML($html);
        $directory = public_path('storage/uploads/reports');

        // Ensure the directory exists; create it if it doesn't
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Generate a unique file name for the PDF with the .pdf extension
        $currentDate = Carbon::now();
        $file_name = 'التقرير الأسبوعي للاشتراكات' . '-' . $currentDate->format('Y-m-d') . '.pdf';

        // Save the PDF content to the file
        $pdf->save($directory . '/' . $file_name);

        $file = Report::create([
            'name' => "uploads/reports/$file_name",
            'note' => null,
        ]);
        // Return the file path (including directory)
        return redirect()->route('dashboard.reports.index');
    }

    // يعرض الملفات
    public function view(Report $report)
    {
        return response()->file(public_path('storage/' . $report->name), ['content-type' => 'application/pdf']);
    }
    // تنزيل الملف
    public function download(Report $report)
    {
        $report = Report::where('id', $report->id)->first();

        // الاسم هو المسار الكامل
        $filePath = 'public/' . $report->name;

        // Check if the file exists in the storage directory.
        if (Storage::exists($filePath)) {
            return response()->download(storage_path('app/' . $filePath));
        }
        abort(404, 'File not found');
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Package;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Report;
use ArPHP\I18N\Arabic;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Console\Command;

class GenerateWeeklyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly-report:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate reports for every week';

    /**
     * Execute the console command.
     */
    /* public function handle()
    {
        // Generate the PDF content
        $pdf = PDF::loadView('admin.reports.template', [$type = 'يومي', $category = 'مستخدمين']);

        // Define the directory where you want to save the PDF file
        $directory = public_path('storage/uploads/reports');

        // Ensure the directory exists; create it if it doesn't
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Generate a unique file name for the PDF with the .pdf extension
        $currentDate = Carbon::now();
        $file_name = 'تقرير' . $type . '-' . $category . '-' . $currentDate->format('Y-m-d') . '.pdf';

        // Save the PDF content to the file
        $pdf->save($directory . '/' . $file_name);

        $file = Report::create([
            'name' => "uploads/reports/$file_name",
            'type' => $type,
            'note' => null,
        ]);
        // // Return the file path (including directory)
        // return 'uploads/reports/' . $file_name;
    } */

    public function handle()
    {
        // User Report 

        // convert html to pdf
        // جلب كل المستخدمين الجدد لاخر 7 ايام
        $startDate = now()->subDays(7)->startOfDay();  // Start of 7 days ago
        $endDate = now()->startOfDay();  // Start of the current day
        $users = User::where('created_at', '>=', $startDate)
            ->where('created_at', '<', $endDate)
            ->select(['id', 'name', 'email', 'phone_number', 'image', 'job', 'package_id', 'role'])
            ->get();

        $deleted_users = User::withTrashed()->where('deleted_at', '<>', null)->select(['id', 'name', 'email', 'phone_number', 'image', 'job', 'package_id', 'role'])->get();

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


        // Package Report

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



        // Subscription Report

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
    }
}

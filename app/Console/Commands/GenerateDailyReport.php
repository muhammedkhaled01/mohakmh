<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Report;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Console\Command;

class GenerateDailyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily-report:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate report for every day';

    /**
     * Execute the console command.
     */
    public function handle()
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
    }
}

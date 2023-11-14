<?php

namespace App\Jobs;

use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\PdfToImage\Pdf;

class PdfConvertJob1 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $path, protected $folder, protected $book_id)
    {
        $this->path = $path;
        $this->folder = $folder;
        $this->book_id = $book_id;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $pdf = new Pdf(public_path('storage/' . $this->path));

        // $pdf = new Pdf(public_path('storage/' . 'uploads/books/pdf-test/pdf-test.pdf'));
        $pdf->setOutputFormat('jpeg')->saveAllPagesAsImages(public_path("storage/uploads/books/$this->folder"), null, $this->book_id);
    }
}

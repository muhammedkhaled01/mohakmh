@extends('master')
@section('title', 'تعديل كتاب | ' . env('APP_NAME'))

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">تعديل كتاب</h1>
        <a href="{{ route('dashboard.books.index') }}" class="btn btn-success px-5">كل الكتب</a>
    </div>
    {{-- @include('errors') --}}
    <form action="{{ route('dashboard.books.update', $book->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.books._form', [
            'button_label' => 'Update',
            'book_id' => $book->id,
        ])
    </form>

@endsection

{{-- @section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.js"></script>
    <script>
        // URL to the PDF file
        var pdfUrl = $existfile;

        // Get the PDF container element
        var container = document.getElementById('pdf-container');

        // Load and render the PDF
        pdfjsLib.getDocument(pdfUrl).then(function(pdf) {
            pdf.getPage(1).then(function(page) {
                var viewport = page.getViewport({
                    scale: 1.5
                }); // Adjust the scale as needed
                var canvas = document.createElement('canvas');
                var context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                container.appendChild(canvas);

                page.render({
                    canvasContext: context,
                    viewport: viewport
                });
            });
        });
    </script>

@endsection --}}

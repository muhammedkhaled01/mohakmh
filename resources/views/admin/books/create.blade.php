@extends('master')
@section('title', 'اضافة كتاب | ' . env('APP_NAME'))

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">أضف كتاب جديد</h1>
        <a href="{{ route('dashboard.books.index') }}" class="btn btn-success px-5">كل الكتب</a>
    </div>
    {{-- @include('admin.errors') --}}
    <form action="{{ route('dashboard.books.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('admin.books._form', [
            'book_id' => '',
        ])
    </form>
@endsection

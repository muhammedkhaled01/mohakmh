@extends('master')
@section('title', 'كل الأقسام | ' . env('APP_NAME'))

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">أضف قسم جديد</h1>
        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-success px-5">كل الأقسام</a>
    </div>
    {{-- @include('admin.errors') --}}
    <form action="{{ route('dashboard.categories.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('admin.categories._form')
    </form>
@endsection

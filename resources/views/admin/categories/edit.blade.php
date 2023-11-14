@extends('master')
@section('title', 'تعديل قسم | ' . env('APP_NAME'))

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">تعديل قسم</h1>
        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-success px-5">كل الأقسام</a>
    </div>
    {{-- @include('errors') --}}
    <form action="{{ route('dashboard.categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.categories._form', [
            'button_label' => 'Update',
        ])
    </form>
@endsection

@extends('master')
@section('title', 'كل الرسائل | ' . env('APP_NAME'))

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">تحديث الرسالة</h1>
        <a href="{{ route('dashboard.forms.index') }}" class="btn btn-success px-5">كل الرسائل</a>
    </div>
    {{-- @include('admin.errors') --}}
    <form action="{{ route('dashboard.forms.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('admin.forms._form')
    </form>
@endsection

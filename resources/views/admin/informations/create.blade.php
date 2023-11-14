@extends('master')
@section('title', 'كل المعلومات | ' . env('APP_NAME'))

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">أضف معلومات جديدة</h1>
        <a href="{{ route('dashboard.informations.index') }}" class="btn btn-success px-5">كل المعلومات</a>
    </div>
    {{-- @include('admin.errors') --}}
    <form action="{{ route('dashboard.informations.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('admin.informations._form')
    </form>
@endsection

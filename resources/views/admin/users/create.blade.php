@extends('master')
@section('title', 'اضافة مستخدم | ' . env('APP_NAME'))

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">أضف مستخدم جديد</h1>
        <a href="{{ route('dashboard.users.index') }}" class="btn btn-success px-5">كل المستخدمين</a>
    </div>
    {{-- @include('admin.errors') --}}
    <form action="{{ route('dashboard.users.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('admin.users._form', ['action' => 'create'])
    </form>
@endsection

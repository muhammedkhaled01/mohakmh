@extends('master')
@section('title', 'اضافة باقة | ' . env('APP_NAME'))

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">أضف باقة جديدة</h1>
        <a href="{{ route('dashboard.packages.index') }}" class="btn btn-success px-5">كل الباقات</a>
    </div>
    {{-- @include('admin.errors') --}}
    <form action="{{ route('dashboard.packages.store') }}" method="post">
        @csrf
        @include('admin.packages._form', ['action' => 'create'])
    </form>
@endsection

@extends('master')
@section('title', 'تعديل باقة | ' . env('APP_NAME'))

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">تعديل باقة</h1>
        <a href="{{ route('dashboard.packages.index') }}" class="btn btn-success px-5">كل الباقات</a>
    </div>
    <x-alert type="danger" />
    <x-alert type="success" />
    <x-alert type="info" />
    <form action="{{ route('dashboard.packages.update', $package->id) }}" method="post">
        @csrf
        @method('PUT')
        @include('admin.packages._form', [
            'button_label' => 'Update',
            'action' => 'update',
        ])
    </form>

@endsection

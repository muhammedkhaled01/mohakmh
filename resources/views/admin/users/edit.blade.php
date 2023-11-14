@extends('master')
@section('title', 'تعديل مستخدم | ' . env('APP_NAME'))

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">تعديل مستخدم</h1>
        <a href="{{ route('dashboard.users.index') }}" class="btn btn-success px-5">كل المستخدمين</a>
    </div>
    {{-- @include('errors') --}}
    <form action="{{ route('dashboard.users.update', $user->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.users._form', [
            'button_label' => 'Update',
            'action' => 'update',
        ])
    </form>
@endsection

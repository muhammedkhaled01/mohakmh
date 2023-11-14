@extends('master')
@section('title', 'تعديل معلومات التواصل | ' . env('APP_NAME'))

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">تعديل معلومات</h1>
        <a href="{{ route('dashboard.informations.index') }}" class="btn btn-success px-5">كل المعلومات</a>
    </div>
    {{-- @include('errors') --}}
    <form action="{{ route('dashboard.informations.update', $information->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.informations._form', [
            'button_label' => 'Update',
        ])
    </form>
@endsection

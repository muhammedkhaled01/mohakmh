@extends('master')
@section('title', 'تعديل رسالة | ' . env('APP_NAME'))

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">تعديل رسالة</h1>
        <a href="{{ route('dashboard.forms.index') }}" class="btn btn-success px-5">كل الرسائل</a>
    </div>
    {{-- @include('errors') --}}
    <form action="{{ route('dashboard.forms.update', $form->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.forms._form', [
            'button_label' => 'Update',
        ])
    </form>
@endsection

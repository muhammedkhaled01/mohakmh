@extends('master')
@section('title', 'المعاملات البنكية | ' . env('APP_NAME'))

@section('content')
    <!-- Page Heading -->
    <form action="{{route("save-local-transactions")}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="number" name="price" required placeholder="enter price">
        </div>
        <div class="form-group">
            <input type="text" name="bank_transferred" required placeholder="enter bank transferred">
        </div>
        <div class="form-group">
            <input type="text" name="name" required placeholder="enter name">
        </div>
        <div class="form-group">
            <input type="number" name="tax" required placeholder="enter name">
        </div>
        <div class="form-group">
            <input type="file" name="image" required>
        </div>
        <input type="submit" value="حفظ">
    </form>
@endsection

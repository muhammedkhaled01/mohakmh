@extends('master')
@section('title', 'المعاملات البنكية المحلية | ' . env('APP_NAME'))
<style>
    .show-image-transaction {
        transition: all .3s ease-in-out;
    }

    .show-image-transaction:hover {
        transform: scale(1.5);
    }
</style>
@section('content')
    <x-alert type="danger"/>
    <x-alert type="success"/>
    <x-alert type="info"/>
    <div class="show-image-transaction text-center">
        <img class="img-fluid" width="400" height="100"
             src="../images/transactions/{{ $transactions->image }}"/>

    </div>
    <div class="form-group mt-5">
        <input type="text" readonly value="{{$transactions->name}}" disabled class="form-control">
    </div>
    <div class="form-group mt-5">
        <input type="text" readonly value="{{$transactions->price}}" disabled class="form-control">
    </div>
    <div class="form-group mt-5">
        <input type="text" readonly value="{{$transactions->bank_transferred}}" disabled class="form-control">
    </div>
    <form action="{{route("update-local-transactions" , $transactions->id)}}" method="post">
        @csrf
        <div class="form-group mt-5">
            <select name="status" id="" class="form-control">
                @foreach($statuses as $status)

                    <option value="{{$status}}" {{ $transactions->status == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="text-center mt-3">
            <button class="btn btn-success w-50" type="submit">تحديث</button>

        </div>
    </form>

@endsection

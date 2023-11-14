@extends('master')


@section('title', 'الكتب المحذوفة')

@section('pageName', 'صفحة الكتب المحذوفة')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">الكتب المحذوفة</h1>
        <div>
            <a href="{{ route('dashboard.books.index') }}" class="btn btn-sm btn-outline-primary">عودة</a>
        </div>
    </div>


    <x-alert type="danger" />
    <x-alert type="info" />
    <x-alert type="success" />

    {{-- search form --}}
    {{-- <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
        <x-form.input name='name' placeholder='Name' class="mx-2" :value="request('name')" />
        <x-form.select name='status' class="mx-2" array="yes" :options="['all' => 'all', 'active' => 'Active', 'archived' => 'Archived']" :oldvalue="request('status')" />
        <x-form.button btntype='dark'>{{ 'Filter' }}</x-form.button>

    </form> --}}
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr class="bg-dark text-white">
                <th>ID</th>
                <th>الاسم</th>
                <th>القسم</th>
                <th>الملف</th>
                <th>الملاحظات</th>
                <th>الحالة</th>
                <th>العمليات</th>
            </tr>
        </thead>
        <tbody>
            {{-- @if ($categories->count(0)) --}}
            @forelse ($books as $book)
                <tr>
                    <td>{{ $book->id }}</td>
                    <td>{{ $book->name }}</td>
                    <td>{{ $book->category->name }}</td>
                    <td>{{ $book->file }}</td>

                    <td>{{ $book->note }}</td>
                    <td>{{ $book->status }}</td>
                    <td>
                        <div class="row justify-content-around">
                            <form action="{{ route('dashboard.books.restore', [$book->id]) }}" method="post">
                                @csrf
                                @method('put')
                                <button type="submit" class="btn btn-sm btn-outline-info">استعادة</button>
                            </form>
                            <form action="{{ route('dashboard.books.forceDelete', [$book->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">حذف نهائي</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center"> لا يوجد كتب هنا .</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $books->withQueryString()->links() }}

@endsection

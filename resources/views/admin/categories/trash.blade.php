@extends('master')


@section('title', 'الأقسام المحذوفة')

@section('pageName', 'صفحة الأقسام المحذوفة')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">الأقسام المحذوفة</h1>
        <div>
            <a href="{{ route('dashboard.categories.index') }}" class="btn btn-sm btn-outline-primary">عودة</a>
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
                <th>القسم الأب</th>
                <th>ملاحظات</th>
                <th>الحالة</th>
                <th>العمليات</th>
            </tr>
        </thead>
        <tbody>
            {{-- @if ($categories->count(0)) --}}
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->parent->name }}</td>
                    <td>{{ $category->note }}</td>
                    <td>{{ $category->status }}</td>
                    <td>
                        <div class="row justify-content-around">
                            <form action="{{ route('dashboard.categories.restore', [$category->id]) }}" method="post">
                                @csrf
                                @method('put')
                                <button type="submit" class="btn btn-sm btn-outline-info">استعادة</button>
                            </form>
                            <form action="{{ route('dashboard.categories.forceDelete', [$category->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">حذف نهائي</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center"> لا يوجد أقسام هنا .</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $categories->withQueryString()->links() }}

@endsection

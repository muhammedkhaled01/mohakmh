@extends('master')


@section('title', 'الباقات المحذوفة')

@section('pageName', 'صفحة الباقات المحذوفة')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">الباقات المحذوفة</h1>
        <div>
            <a href="{{ route('dashboard.packages.index') }}" class="btn btn-sm btn-outline-primary">عودة</a>
        </div>
    </div>

    <x-alert type="danger" />
    <x-alert type="info" />
    <x-alert type="success" />

    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr class="bg-dark text-white">
                <th>ID</th>
                <th>الاسم</th>
                <th>السعر</th>
                <th>المدة / شهريا</th>
                <th>المزايا</th>
                <th>الملاحظات</th>
                <th>الحالة</th>
                <th>العمليات</th>
            </tr>
        </thead>
        <tbody>
            {{-- @if ($categories->count(0)) --}}
            @forelse ($packages as $package)
                <tr>
                    <td>{{ $package->id }}</td>
                    <td>{{ $package->name }}</td>
                    <td>{{ $package->price }}</td>
                    <td>{{ $package->duration }}</td>
                    <td>{{ $package->advantages }}</td>
                    <td>{{ $package->note }}</td>
                    <td>{{ $package->status }}</td>
                    <td>
                        <div class="row justify-content-around">
                            <form action="{{ route('dashboard.packages.restore', [$package->id]) }}" method="post">
                                @csrf
                                @method('put')
                                <button type="submit" class="btn btn-sm btn-outline-info">استعادة</button>
                            </form>
                            <form action="{{ route('dashboard.packages.forceDelete', [$package->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">حذف نهائي</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center"> لا يوجد باقات هنا .</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $packages->withQueryString()->links() }}

@endsection

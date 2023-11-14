@extends('master')


@section('title', 'التقارير المحذوفة')

@section('pageName', 'صفحة التقارير المحذوفة')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">التقارير المحذوفة</h1>
        <div>
            <a href="{{ route('dashboard.reports.index') }}" class="btn btn-sm btn-outline-primary">عودة</a>
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
                <th>الملاحظات</th>
                <th>العمليات</th>
            </tr>
        </thead>
        <tbody>
            {{-- @if ($categories->count(0)) --}}
            @forelse ($reports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>{{ $report->name }}</td>
                    <td>{{ $report->note }}</td>
                    <td>
                        <div class="row justify-content-around">
                            <form action="{{ route('dashboard.reports.restore', [$report->id]) }}" method="post">
                                @csrf
                                @method('put')
                                <button type="submit" class="btn btn-sm btn-outline-info">استعادة</button>
                            </form>
                            <form action="{{ route('dashboard.reports.forceDelete', [$report->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">حذف نهائي</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center"> لا يوجد تقارير هنا .</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $reports->withQueryString()->links() }}

@endsection

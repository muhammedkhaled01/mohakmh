@extends('master')
@section('title', 'التقارير | ' . env('APP_NAME'))

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">التقارير</h1>
        <div>
            <a href="{{ route('dashboard.reports.trash') }}" class="btn btn-outline-dark">المحذوفة</a>
            <a href="{{ route('dashboard.reports.generate') }}" class="btn btn-outline-dark">انشاء تقرير عام</a>
        </div>
    </div>
    <x-alert type="danger" />
    <x-alert type="success" />
    <x-alert type="info" />

    <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-around mb-4">
        <x-form.label id="name">{{ 'الاسم' }}</x-form.label>
        <x-form.input name='name' placeholder='الاسم' class="mx-2" :value="request('name')" />
        <x-form.label id="orderBy" style="width: 32ch;">{{ 'ترتيب حسب' }}</x-form.label>
        <x-form.select name="orderBy" :options="[
            'id' => 'id',
            'name' => 'name',
            'created_at' => 'created_at',
        ]" array='yes' class="mr-2" :oldvalue="request('orderBy')" />
        <x-form.select name='direction' class="mx-2" array="yes" :options="['ASC' => 'asc', 'DESC' => 'desc']" :oldvalue="request('direction')" />
        <x-form.input type="hidden" name='itemsPerPage' :value="request('itemsPerPage')" />
        <x-form.button btntype='dark'>{{ 'Filter' }}</x-form.button>
    </form>

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
            @forelse ($reports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>
                        <a href="{{ route('dashboard.reports.view', $report->id) }}" target="_blank"
                            rel="noopener noreferrer">{{ basename($report->name) }}</a>
                    </td>
                    <td>{{ $report->note ?? '---' }}</td>
                    <td>
                        <div class="row justify-content-around">
                            <a href="{{ route('dashboard.reports.download', $report->id) }}"
                                class="btn btn-sm btn-primary"><i class="fas fa-download"></i></a>
                            <form action="{{ route('dashboard.reports.destroy', $report->id) }}" method="post">
                                @csrf
                                {{-- Form Method Spoofing --}}
                                <input type="hidden" name="_method" value="delete">
                                {{-- @method('delete') --}}
                                <button type="submit" class="btn btn-sm btn-danger btn-delete"><i
                                        class="fas fa-times"></i></button>
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
    <form action="{{ URL::current() }}" method="get" class="d-flex pb-5">
        <x-form.input type="hidden" name='name' :value="request('name')" />
        <x-form.input type="hidden" name='orderBy' :value="request('orderBy')" />
        <x-form.input type="hidden" name='direction' :value="request('direction')" />
        @if ($reports->count() > 5)
            <label for="" class="mr-2">عدد التقارير لكل صفحة :</label>
            <x-form.select name="itemsPerPage" :options="['10' => '10', '20' => '20', '50' => '50']" array='yes' class="mr-2" style="width: 8ch"
                :oldvalue="request('itemsPerPage')" />
            <x-form.button btntype="info">{{ 'Update' }}</x-form.button>
        @endif
    </form>
    {{-- @endif --}}
@endsection

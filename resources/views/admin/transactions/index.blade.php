@extends('master')
@section('title', 'المعاملات البنكية | ' . env('APP_NAME'))

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">المعاملات البنكية</h1>
        <div>
            <a href="{{ route('dashboard.transactions.trash') }}" class="btn btn-outline-dark">المحذوفة</a>
            <a href="{{ route('dashboard.transactions.create') }}" class="btn btn-success px-5">أضف جديد</a>
        </div>
    </div>
    <x-alert type="danger" />
    <x-alert type="success" />
    <x-alert type="info" />

    <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
        <x-form.label id="name">{{ 'الاسم' }}</x-form.label>
        <x-form.input name='name' placeholder='الاسم' class="mx-2" :value="request('name')" />

        <x-form.label id="status">{{ 'الحالة' }}</x-form.label>
        <x-form.select name='status' class="mx-2" array="yes" :options="['all' => 'all', 'active' => 'Active', 'archived' => 'Archived']" :oldvalue="request('status')" />


        <x-form.label id="orderBy" style="width: 25ch;">{{ 'ترتيب حسب' }}</x-form.label>
        <x-form.select name="orderBy" :options="[
            'id' => 'id',
            'name' => 'name',
            'package_id' => 'package_id',
            'status' => 'status',
            'created_at' => 'created_at',
        ]" array='yes' class="mr-2" style="width: 8ch"
            :oldvalue="request('orderBy')" />
        <x-form.select name='direction' class="mx-2" style="width: 8ch" array="yes" :options="['ASC' => 'asc', 'DESC' => 'desc']"
            :oldvalue="request('direction')" />
        <x-form.input type="hidden" name='itemsPerPage' :value="request('itemsPerPage')" />
        <x-form.button btntype='dark'>{{ 'Filter' }}</x-form.button>
    </form>

    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr class="bg-dark text-white">
                <th>ID</th>
                <th>السعر</th>
                <th>اسم البنك</th>
                <th>اسم العميل</th>
                <th>الحالة</th>
                <th>العمليات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->price }}</td>
                    <td>{{ $transaction->bank_name }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>{{ $transaction->status }}</td>
                    <td>
                        <div class="row justify-content-around">
                            <form action="{{ route('dashboard.transactions.destroy', [$transaction->id]) }}"
                                method="post">
                                @csrf
                                {{-- Form Method Spoofing --}}
                                <input type="hidden" name="_method" value="delete">
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-danger btn-delete"><i
                                        class="fas fa-times"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center"> لا يوجد معاملات بنكية هنا .</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $transactions->withQueryString()->links() }}

    {{-- @if ($show === 'yes') --}}
    <form action="{{ URL::current() }}" method="get" class="d-flex pb-5">
        <x-form.input type="hidden" name='name' :value="request('name')" />
        <x-form.input type="hidden" name='status' :value="request('status')" />
        <x-form.input type="hidden" name='orderBy' :value="request('orderBy')" />
        <x-form.input type="hidden" name='direction' :value="request('direction')" />
        <label for="" class="mr-2">عدد الكتب لكل صفحة :</label>
        <x-form.select name="itemsPerPage" :options="['10' => '10', '20' => '20', '50' => '50']" array='yes' class="mr-2" style="width: 8ch"
            :oldvalue="request('itemsPerPage')" />
        <x-form.button btntype='info'>{{ 'Update' }}</x-form.button>
    </form>
    {{-- @endif --}}
@endsection

@extends('master')
@section('title', 'الباقات | ' . env('APP_NAME'))

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">الباقات</h1>
        <div>
            <a href="{{ route('dashboard.packages.trash') }}" class="btn btn-outline-dark">المحذوفة</a>
            <a href="{{ route('dashboard.packages.create') }}" class="btn btn-success px-5">أضف جديد</a>
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
            'duration' => 'duration',
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
                <th>الاسم</th>
                <th>السعر</th>
                <th>السعر الحديد</th>
                <th>المدة / شهر</th>
                <th>مدة الخصم</th>
                <th>المزايا</th>
                <th>عدد المشتركين</th>
                <th>الملاحظات</th>
                <th>الحالة</th>
                <th>العمليات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($packages as $package)
                <tr>
                    <td>{{ $package->id }}</td>
                    <td>{{ $package->name }}</td>
                    <td>{{ $package->price }}</td>
                    <td>{{ $package->new_price }}</td>
                    <td>{{ $package->duration }}</td>
                    <td>{{ $package->free_duration }}</td>
                    <td>
                        @foreach ($package->advantages as $advantages)
                            @if ($advantages->text)
                                {{ $advantages->text }}
                                <br>
                            @endif
                        @endforeach

                    </td>
                    <td>{{ $package->users()->count() }}</td>
                    <td>{{ $package->note }}</td>
                    <td>{{ $package->status }}</td>
                    <td>
                        <div class="row justify-content-around">
                            <a href="{{ route('dashboard.packages.edit', $package->id) }}"
                                class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('dashboard.packages.destroy', [$package->id]) }}" method="post">
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
                    <td colspan="12" class="text-center"> لا يوجد باقات هنا .</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $packages->withQueryString()->links() }}

    {{-- @if ($show === 'yes') --}}
    <form action="{{ URL::current() }}" method="get" class="d-flex pb-5">
        <x-form.input type="hidden" name='name' :value="request('name')" />
        <x-form.input type="hidden" name='status' :value="request('status')" />
        <x-form.input type="hidden" name='orderBy' :value="request('orderBy')" />
        <x-form.input type="hidden" name='direction' :value="request('direction')" />
        <label for="" class="mr-2">عدد الباقات لكل صفحة :</label>
        <x-form.select name="itemsPerPage" :options="['10' => '10', '20' => '20', '50' => '50']" array='yes' class="mr-2" style="width: 8ch"
            :oldvalue="request('itemsPerPage')" />
        <x-form.button btntype='info'>{{ 'Update' }}</x-form.button>
    </form>
    {{-- @endif --}}
@endsection

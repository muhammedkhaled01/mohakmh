@extends('master')
@section('title', 'الأقسام | ' . env('APP_NAME'))

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">الأقسام</h1>
        <div>
            <a href="{{ route('dashboard.categories.trash') }}" class="btn btn-outline-dark">المحذوفة</a>
            <a href="{{ route('dashboard.categories.create') }}" class="btn btn-success px-5">أضف جديد</a>
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
            'parent_id' => 'parent_id',
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
                <th>الصورة</th>
                <th>القسم الأب</th>
                <th>ملاحظات</th>
                <th>الحالة</th>
                <th>العمليات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td><img src="{{ asset('storage/' . $category->image) }}" alt="" height="50">
                        {{-- <td><img src="{{ asset($category->image) }}" alt="" height="50"> --}}
                        {{-- <img src="https://admin.mohakmh.com/storage/uploads/category-image/mony.jpg" alt="" height="50"> --}}
                        {{-- اشتغلت سيرفر --}}

                        {{--  public/storage/uploads/category-image/1696231321-8686-Flag_of_Palestine.png
                    http://127.0.0.1:8000/storage/uploads/category-image/1696377585-5269-stack-bills-money-cash-isolated-icon-free-vector.jpg
                    http://127.0.0.1:8000/storage/uploads/category-image/1696377585-5269-stack-bills-money-cash-isolated-icon-free-vector.jpg --}}
                    </td>
                    <td>{{ $category->parent->name }}</td>
                    <td>{{ $category->note }}</td>
                    <td>{{ $category->status }}</td>
                    <td>
                        <div class="row justify-content-around">
                            <a href="{{ route('dashboard.categories.edit', $category->id) }}"
                                class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('dashboard.categories.destroy', [$category->id]) }}" method="post">
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
                    <td colspan="7" class="text-center"> لا يوجد أقسام هنا .</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $categories->withQueryString()->links() }}

    {{-- @if ($show === 'yes') --}}
    <form action="{{ URL::current() }}" method="get" class="d-flex pb-5">
        <x-form.input type="hidden" name='name' :value="request('name')" />
        <x-form.input type="hidden" name='status' :value="request('status')" />
        <x-form.input type="hidden" name='orderBy' :value="request('orderBy')" />
        <x-form.input type="hidden" name='direction' :value="request('direction')" />
        <label for="" class="mr-2">عدد الأقسام لكل صفحة :</label>
        <x-form.select name="itemsPerPage" :options="['10' => '10', '20' => '20', '50' => '50']" array='yes' class="mr-2" style="width: 8ch"
            :oldvalue="request('itemsPerPage')" />
        <x-form.button btntype='info'>{{ 'Update' }}</x-form.button>
    </form>
    {{-- @endif --}}
@endsection

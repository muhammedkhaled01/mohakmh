@extends('master')
@section('title', 'الرسائل | ' . env('APP_NAME'))

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">الرسائل</h1>
        <div>
            <a href="{{ route('dashboard.categories.trash') }}" class="btn btn-outline-dark">المحذوفة</a>
        </div>
    </div>
    <x-alert type="danger" />
    <x-alert type="success" />
    <x-alert type="info" />

    <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
        <x-form.label id="firstName">{{ 'الاسم' }}</x-form.label>
        <x-form.input name='firstName' placeholder='الاسم' class="mx-2" :value="request('firstName')" />

        {{-- <x-form.label id="reply">{{ 'الحالة' }}</x-form.label>
        <x-form.select name='reply' class="mx-2" array="yes" :options="['all' => 'all', 'reply' => 'تم الرد', 'notreply' => 'قيد الانتظار']" :oldvalue="request('reply')" /> --}}

        {{-- <x-form.label id="orderBy" style="width: 25ch;">{{ 'ترتيب حسب' }}</x-form.label> --}}
        <x-form.select name="orderBy" :options="[
            'id' => 'id',
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
                <th>الاسم الأول</th>
                <th>الاسم الاخير</th>
                <th> الايميل</th>
                <th>الموضوع</th>
                <th>الهدف</th>
                <th>الرسالة</th>
                <th>الحالة</th>
                <th>ملاحظات</th>
                <th>العمليات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($forms as $form)
                <tr>
                    <td>{{ $form->id }}</td>
                    <td>{{ $form->firstName }}</td>
                    <td>{{ $form->lastName }}</td>
                    <td>{{ $form->email }}</td>
                    <td>{{ $form->subject }}</td>
                    <td>{{ $form->purpos }}</td>
                    <td>{{ $form->message }}</td>
                    <td style="{{ $form->reply == 'reply' ? 'color: green;' : 'color: red;' }}">
                        {{ $form->reply == 'reply' ? 'تم الرد ' : ' قيد الانتظار' }}</td>
                    <td>{{ $form->note }}</td>
                    <td>
                        <div class="row justify-content-around">
                            <a href="{{ route('dashboard.forms.edit', $form->id) }}" class="btn btn-sm btn-primary"><i
                                    class="fas fa-edit"></i></a>
                            <form action="{{ route('dashboard.forms.destroy', [$form->id]) }}" method="post">
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
                    <td colspan="10" class="text-center"> لا يوجد رسائل هنا </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $forms->withQueryString()->links() }}

    <form action="{{ URL::current() }}" method="get" class="d-flex pb-5">
        <x-form.input type="hidden" name='firstName' :value="request('firstName')" />
        {{-- <x-form.input type="hidden" name='reply' :value="request('reply')" /> --}}
        <x-form.input type="hidden" name='orderBy' :value="request('orderBy')" />
        <x-form.input type="hidden" name='direction' :value="request('direction')" />
        <label for="" class="mr-2">عدد الرسائل لكل صفحة :</label>
        <x-form.select name="itemsPerPage" :options="['10' => '10', '20' => '20', '50' => '50']" array='yes' class="mr-2" style="width: 8ch"
            :oldvalue="request('itemsPerPage')" />
        <x-form.button btntype='info'>{{ 'Update' }}</x-form.button>
    </form>
    {{-- @endif --}}
@endsection

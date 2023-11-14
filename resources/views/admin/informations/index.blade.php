@extends('master')
@section('title', 'معلومات التواصل | ' . env('APP_NAME'))

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">معلومات التواصل</h1>
        <div>
            <a href="{{ route('dashboard.informations.create') }}" class="btn btn-success px-5">أضف جديد</a>
        </div>
    </div>
    <x-alert type="danger" />
    <x-alert type="success" />
    <x-alert type="info" />

    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr class="bg-dark text-white">
                <th>ID</th>
                <th>مقولة</th>
                <th>العنوان</th>
                <th>المكان</th>
                <th>الايميل</th>
                <th>الهاتف</th>
                <th>التواصل الاجتماعي</th>
                <th>الملاحظات</th>
                <th>العمليات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($informations as $information)
                <tr>
                    <td>{{ $information->id }}</td>
                    <td>{{ $information->sentence }}</td>
                    <td>{{ $information->title }}</td>
                    <td>{{ $information->address }}</td>
                    <td>{{ $information->email }}</td>
                    <td>{{ $information->phone }}</td>
                    <td>{{ $information->facebook . ' ' . $information->instagram . ' ' . $information->x . ' ' . $information->linkedin }}
                    </td>
                    <td>{{ $information->note }}</td>
                    <td>
                        <div class="row justify-content-around">
                            <a href="{{ route('dashboard.informations.edit', $information->id) }}"
                                class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('dashboard.informations.destroy', [$information->id]) }}"
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
                    <td colspan="9" class="text-center"> لا يوجد معلومات هنا .</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

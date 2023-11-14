@extends('master')


@section('title', 'المستخدمين المحذوفين')

@section('pageName', 'صفحة المستخدمين المحذوفين')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800"> المستخدمين المحذوفين</h1>
        <div>
            <a href="{{ route('dashboard.users.index') }}" class="btn btn-sm btn-outline-primary">عودة</a>
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
                <th>الايميل</th>
                <th>رقم الهاتف</th>
                <th>الصورة</th>
                <th>الباقة</th>
                <th>الرتبة</th>
                <th>الملاحظات</th>
                <th>الحالة</th>
                <th>العمليات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td>{{ $user->image }}</td>
                    <td>{{ $user->package_id }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->note }}</td>
                    <td>{{ $user->status }}</td>
                    <td>
                        <div class="row justify-content-around">
                            <form action="{{ route('dashboard.users.restore', [$user->id]) }}" method="post">
                                @csrf
                                @method('put')
                                <button type="submit" class="btn btn-sm btn-outline-info">استعادة</button>
                            </form>
                            <form action="{{ route('dashboard.users.forceDelete', [$user->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">حذف نهائي</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center"> لا يوجد مستخدمين هنا .</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $users->withQueryString()->links() }}

@endsection

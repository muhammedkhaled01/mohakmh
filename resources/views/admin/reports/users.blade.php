<div style="float: right; text-align:right">
    <div style="width: 100%; height: 50%; background-color: white; display: flex; flex-direction: column;">
        <div style="text-align: center;">
            <div style="display: inline-block;">
                {{-- <h1>محاكمة</h1> --}}
                <img src="https://svgshare.com/i/yGb.svg" alt="محاكمة"
                    style="height: 100px; width: 200px; display: block" />
            </div>
        </div>
        <h1 style="font-weight: 600; font-size: 35px; font-family: 'Poppins', sans-serif; margin: 30px 0 20px 0;">
            التقرير الأسبوعي للمستخدمين
        </h1>
        <br>
        <div style="margin: 0 0 0 30px;">
            <h3>كل المستخدمين الفعالين </h3>
            <table style="border: 1px solid black; border-collapse: collapse; ">
                <thead>
                    <tr class="bg-dark text-white we">
                        <th style="border: 1px solid black; ">ID</th>
                        <th style="border: 1px solid black; ">الاسم</th>
                        <th style="border: 1px solid black; ">الايميل</th>
                        <th style="border: 1px solid black; ">رقم الهاتف</th>
                        <th style="border: 1px solid black; ">الباقة</th>
                        <th style="border: 1px solid black; ">الرتبة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $user->id }}</td>
                            <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $user->name }}</td>
                            <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $user->email }}</td>
                            <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $user->phone_number }}</td>
                            <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $user->package->name }}</td>
                            <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $user->role }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center"> لا يوجد مستخدمين</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <br>
            <h3>كل المستخدمين الذي تم حظرهم</h3>
            <table style="border: 1px solid black; border-collapse: collapse; ">
                <thead>
                    <tr class="bg-dark text-white we">
                        <th style="border: 1px solid black; padding: 0 0 0 10px;">ID</th>
                        <th style="border: 1px solid black; padding: 0 0 0 10px;">الاسم</th>
                        <th style="border: 1px solid black; padding: 0 0 0 10px;">الايميل</th>
                        <th style="border: 1px solid black; padding: 0 0 0 10px;">رقم الهاتف</th>
                        <th style="border: 1px solid black; padding: 0 0 0 10px;">الباقة</th>
                        <th style="border: 1px solid black; padding: 0 0 0 10px;">الرتبة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($deleted_users as $deleted_user)
                        <tr>
                            <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $deleted_user->id }}</td>
                            <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $deleted_user->name }}</td>
                            <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $deleted_user->email }}</td>
                            <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $deleted_user->phone_number }}
                            </td>
                            <td style="border: 1px solid black; padding: 0 0 0 10px;">
                                {{ $deleted_user->package->name }}</td>
                            <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $deleted_user->role }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center"> لا يوجد مستخدمين محظورين</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <br>
        </div>
        <p style="margin-bottom: 25px;">هذه التفاصيل مقدمة من موقع محاكمة</p>
    </div>
</div>

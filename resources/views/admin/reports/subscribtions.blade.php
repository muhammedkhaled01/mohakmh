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
            التقرير الأسبوعي للاشتراكات
        </h1>
        <br>
        {{--  
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>رقم المستخدم</th>
                    <th>اسم المستخدم</th>
                    <th>الباقة</th>
                    <th>بدأت في </th>
                    <th>تنتهي في</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($subscribtions as $subscribtion)
                    <tr>
                        <td>{{ $subscribtion->id }}</td>
                        <td>{{ $subscribtion->user_id }}</td>
                        <td>{{ $subscribtion->user->name }}</td>
                        <td>{{ $subscribtion->package->name }}</td>
                        <td>{{ $subscribtion->start_at }}</td>
                        <td>{{ $subscribtion->end_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center"> لا يوجد اشتراكات هنا </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        --}}
        <table style="border: 1px solid black; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 0 0 0 10px;">ID</th>
                    <th style="border: 1px solid black; padding: 0 0 0 10px;">رقم المستخدم</th>
                    <th style="border: 1px solid black; padding: 0 0 0 10px;">اسم المستخدم</th>
                    <th style="border: 1px solid black; padding: 0 0 0 10px;">الباقة</th>
                    <th style="border: 1px solid black; padding: 0 0 0 10px;">تبدأ في</th>
                    <th style="border: 1px solid black; padding: 0 0 0 10px;">تنتهي في</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($subscribtions as $subscribtion)
                    <tr>
                        <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $subscribtion->id }}</td>
                        <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $subscribtion->user_id }}</td>
                        <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $subscribtion->user->name }}
                        </td>
                        <td style="border: 1px solid black; padding: 0 0 0 10px;">
                            {{ $subscribtion->package->name }}</td>
                        <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $subscribtion->start_at }}
                        </td>
                        <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $subscribtion->end_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="border: 1px solid black; padding: 0 0 0 10px;" class="text-center">
                            لا يوجد اشتراكات هنا</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <br>
        <p style="margin-bottom: 25px;">هذه التفاصيل مقدمة من موقع محاكمة</p>
    </div>

</div>

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
            التقرير الأسبوعي للباقات
        </h1>
        <br>


        {{-- <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>الاسم</th>
                    <th>السعر</th>
                    <th>السعر الحديد</th>
                    <th>المدة / شهر</th>
                    <th>مدة الخصم</th>
                    <th>المزايا</th>
                    <th>عدد المشتركين</th>
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
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center"> لا يوجد باقات هنا .</td>
                    </tr>
                @endforelse
            </tbody>
        </table> --}}
        <table style="border: 1px solid black; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 0 0 0 10px;">ID</th>
                    <th style="border: 1px solid black; padding: 0 0 0 10px;">الاسم</th>
                    <th style="border: 1px solid black; padding: 0 0 0 10px;">السعر</th>
                    <th style="border: 1px solid black; padding: 0 0 0 10px;">السعر الحديد</th>
                    <th style="border: 1px solid black; padding: 0 0 0 10px;">المدة / شهر</th>
                    <th style="border: 1px solid black; padding: 0 0 0 10px;">مدة الخصم</th>
                    <th style="border: 1px solid black; padding: 0 0 0 10px;">المزايا</th>
                    <th style="border: 1px solid black; padding: 0 0 0 10px;">عدد المشتركين</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($packages as $package)
                    <tr>
                        <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $package->id }}</td>
                        <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $package->name }}</td>
                        <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $package->price }}</td>
                        <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $package->new_price }}</td>
                        <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $package->duration }}</td>
                        <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $package->free_duration }}
                        </td>
                        <td style="border: 1px solid black; padding: 0 0 0 10px;">
                            @foreach ($package->advantages as $advantages)
                                @if ($advantages->text)
                                    {{ $advantages->text }}
                                    <br>
                                @endif
                            @endforeach
                        </td>
                        <td style="border: 1px solid black; padding: 0 0 0 10px;">{{ $package->users()->count() }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" style="border: 1px solid black; padding: 0 0 0 10px;" class="text-center"> لا
                            يوجد
                            باقات هنا .</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <br>
        <p style="margin-bottom: 25px;">هذه التفاصيل مقدمة من موقع محاكمة</p>


        {{--
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr class="bg-dark text-white">
                    <th>ID</th>
                    <th>الاسم</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center"> لا يوجد مستخدمين جدد لهذا الأسبوع .</td>
        </tr>
        @endforelse
        </tbody>
        </table>
        --}}

    </div>

</div>

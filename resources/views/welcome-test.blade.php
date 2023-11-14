<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>منصة محاكمة</title>
    <style></style>
</head>

{{-- <body>
    <div>
        @if (Route::has('login'))
            <div>
                @auth
                    <a href="{{ url('/dashboard') }}">لوحة
                        التحكم</a>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit">تسجيل
                            الخروج</button>
                    </form>
                @else
                    <button>
                        <a href="{{ route('login') }}" style="text-decoration: none; color: inherit;">تسجيل دخول</a>
                    </button>

                    @if (Route::has('register'))
                        <button>
                            <a href="{{ route('register') }}" style="text-decoration: none; color: inherit;">انشاء حساب</a>
                        </button>
                    @endif
                @endauth

            </div>
        @endif

        <div class="">
            <img src="{{ asset('adminassets/img/mainPageImage.jpg') }}" alt="" srcset="">
        </div>
    </div>
</body> --}}

<body>
    <div class="container">
        <div class="background-image">
            <h1>Hello World</h1>
        </div>
    </div>
</body>

</html>

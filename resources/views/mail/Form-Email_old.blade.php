<!DOCTYPE html>
<html lang="ar" dir="rtl">

<body>

    <h1>
        مرحبا أنا {{ $user_firstName . ' ' . $user_lastName }} و لدي {{ $user_purpos }}
    </h1>
    <br>
    <h2>
        العنوان : {{ $user_subject }}
    </h2>
    <textarea name="" id="" cols="30" rows="10">
        {{ $user_message }}
    </textarea>
    <br>
    <p>
        ايميل المستخدم : {{ $user_email }}
    </p>
    <br>
    <p>منصة محاكمة</p>
</body>

</html>

<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>منصة محاكمة</title>
    <style>
        table,
        td,
        div,
        h1,
        p {
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body style="margin: 0; padding: 0">
    <table role="presentation"
        style=" width: 100%; border-collapse: collapse; border: 0; border-spacing: 0; background: #ffffff; ">
        <tr>
            <td align="center" style="padding: 0">
                <table role="presentation"
                    style=" width: 602px; border-collapse: collapse;border: 1px solid #cccccc; border-spacing: 0; text-align: left; ">
                    <tr>
                        <td align="center" style="padding: 40px 0 30px 0">
                            <img src="https://i.ibb.co/JsM7BnB/REPLACE-THIS-SCREEN1111211110111.jpg" alt="محاكمة"
                                style="height: auto; display: block" />
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 36px 30px 42px 30px">
                            <table
                                role="presentation"style="width: 100%;border-collapse: collapse;border: 0; border-spacing: 0;">
                                <tr>
                                    <td style="padding: 0 0 36px 0; color: #153643">
                                        <h1>
                                            مرحبا أنا {{ $user_firstName . ' ' . $user_lastName }} و لدي
                                            {{ $user_purpos }}
                                        </h1>
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
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px; background: #757575">
                            <table role="presentation"
                                style="
                    width: 100%;
                    border-collapse: collapse;
                    border: 0;
                    border-spacing: 0;
                    font-size: 9px;
                    font-family: Arial, sans-serif;
                  ">
                                <tr>
                                    <td style="padding: 0; width: 50%" align="center">
                                        <p
                                            style="
                          margin: 0;
                          font-size: 14px;
                          line-height: 16px;
                          font-family: Arial, sans-serif;
                          color: #ffffff;
                        ">
                                            &reg; منصة محاكمة<br />
                                        </p>
                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>

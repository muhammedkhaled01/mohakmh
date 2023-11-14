<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<section>
    <h3>Payment </h3>
    <form accept-charset="UTF-8" action="https://api.moyasar.com/v1/payments.html" method="POST">
        <input type="hidden" name="callback_url" value="{{url(route('payment.callback' ,$package->id))}}" />
        <input type="hidden" name="package_id" value="1">
        <input type="hidden" name="publishable_api_key" value="{{config('services.moyasar.key')}}" />
        <input type="hidden" name="amount" value="1000" />
        <input type="hidden" name="currency" value="SAR" />
        <input type="hidden" name="source[type]" value="creditcard" />


        <input type="text" name="source[name]" placeholder="name" />
        <input type="text" name="source[number]" placeholder="number" />
        <input type="text" name="source[month]" placeholder="month" />
        <input type="text" name="source[year]" placeholder="year" />
        <input type="text" name="source[cvc]" placeholder="cvc" />

        <button type="submit">Pay</button>
    </form>
</section>
</body>
</html>

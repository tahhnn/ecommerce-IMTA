<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Shop</title>
</head>
<body>
    <h1>{{ $mailData['title'] }}</h1>
    <p>Mã hóa đơn: {{ $mailData['bill_code'] }}</p>
    <p>Tên khách hàng: {{ $mailData['customer'] }}</p>
    <p>Số tiền thanh toán: $ {{ $mailData['total_bill'] }}</p>

    <p>Hóa đơn đã được thanh toán thành công. Trân thành cảm ơn quý khách đã đồng hành.</p>
</body>
</html>
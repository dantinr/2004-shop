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

<form action="/my/order/search" method="post">
    @csrf
    用户ID： <input type="text" name="uid"><br>
    订单号： <input type="text" name="oid"><br>
    Order_SN: <input type="text" name="order_sn"> <br>

    <input type="submit" value="Search">
</form>

</body>
</html>

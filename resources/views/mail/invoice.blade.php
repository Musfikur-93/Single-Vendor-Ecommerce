<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
		<h1>Successfully Order Placed on ABC Ecommerce</h1><br>
		<strong>Order Id (Traking Id): {{$order['order_id']}}</strong><br>
		<strong>Order Date: {{$order['date']}}</strong><br>
		<strong>Total: {{$order['total']}}</strong><br>
		<hr>
		<strong>Name:{{$order['c_name']}}</strong><br>
		<strong>Phone:{{$order['c_phone']}}</strong><br>
		<strong>Address:{{$order['c_address']}}</strong>

</body>
</html>
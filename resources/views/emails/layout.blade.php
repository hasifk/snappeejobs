<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>@yield('heading')</title>
</head>
<body>

	<table style="max-width: 700px; margin: 0 auto; padding:0; border:1px solid #1d366c; font-family: arial;" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<img src="{{ env('APP_URL') }}/images/bg.jpg" style="width: 100%" alt="">
			</td>
		</tr>
		<tr>
			<td>
				<h2 style="font-size: 18px; color: #666; padding:0 30px">
					@yield('heading')
				</h2>

				<p style="font-size: 14px; color: #666; padding:5px 30px">
					@yield('content')
				</p>
			</td>
		</tr>
		<tr>
			<td style="background: #1d366c; color: #fff; text-align: center; padding: 20px; font-size: 12px;">
				<a href="#" style="color: #fff; padding: 5px;">Link1</a> 
				<a href="#" style="color: #fff; padding: 5px;">Link2</a> 
				<a href="#" style="color: #fff; padding: 5px;">Link3</a> <br><br>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloremque eius placeat vitae blanditiis delectus consectetur, obcaecati voluptatem numquam voluptates.</p>
				<a href="#" style="color: #fff; padding: 5px;">Unsubscribe</a> <br><br>
				
			</td>
		</tr>
	</table>
	<div>
		

	</div>
	
</body>
</html>
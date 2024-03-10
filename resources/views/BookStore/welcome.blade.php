<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0"/>
	<title>BookShop</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet">
	<link rel="shortcut icon" href="{{ asset('images/SHOP.png') }}" type="image/x-icon" />
	@vite(['resources/css/app.css','resources/css/materialize.css','resources/js/app.js','resources/js/materialize.js','resources/js/init.js'])
</head>
<body>
<div id="app">

	<div class="container">
		<tool></tool>
	</div>
	
    @include('component.navigation')

	@include('component.serve.message')
	
    @include('component.banner')

    @include('component.form.login')

    @include('component.form.register')

	<br>
	
	<router-view></router-view>
	
	<br>
	
    @include('component.contact')
	
	<br>
	
    @include('component.footer')
	
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.7.14/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-router/3.0.1/vue-router.js"></script>
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.11"></script>
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript"></script>
</body>
</html>
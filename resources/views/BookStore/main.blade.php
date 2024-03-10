<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
	<title>BookShop</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	@vite(['resources/css/app.css','resources/css/materialize.css','resources/js/app.js','resources/js/materialize.js','resources/js/init.js'])
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet">
	<link rel="shortcut icon" href="{{ asset('images/THU-TITAN ICON.ico') }}" type="image/x-icon" />
</head>
<body>
<div id="app">
	
	@include('component.navigation')
	
    @include('component.serve.message')

    @include('component.logoutbanner')
	
	<br>

	<div class="container">
		<div class="row">
			<h3 class="center-align">所有商品</h3>
			<div class="row">
				<h4 class="center-align">目前沒有商品。</h4>
			</div>
			<div class="col s12 m4">
				<div class="card hoverable center">
					<div class="card-content">
						<h5>車牌號碼: </h5>
						<div class="row">
							<div class="chip left brown">
								<p class="white-text">#一號車位</p>
							</div>
						</div>
						<div class="row">
							<h5 class="left">車位狀態:</h5>
						</div>
						<a class="waves-effect waves-light btn right brown" href="">查看車輛資訊</a>
						<br><br>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<br>
	
	@include('component.contact')
	
	<br>
	
    @include('component.footer')
	
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.7.14/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-router/3.0.1/vue-router.js"></script>
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.11"></script>
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="{{ asset('js/materialize.min.js') }}"></script>
<script src="{{ asset('js/init.js') }}"></script>
<script type="text/javascript"></script>
</body>
</html>
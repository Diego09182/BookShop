<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
	<title>BookShop</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('css/materialize.min.css') }}">
	<link href="{{ asset('css/style.css') }}" type="text/css" rel="stylesheet" media="screen,projection"/>
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet">
	<link rel="shortcut icon" href="{{ asset('images/SHOP.png') }}" type="image/x-icon" />
</head>
<body>
<div id="app">
	
	@include('component.navigation')
	
    @include('component.serve.message')

    @include('component.logoutbanner')
	
	<div class="fixed-action-btn click-to-toggle">
		<a class="btn-floating btn-large red">
			<i class="large material-icons brown">menu</i>
		</a>
		<ul>
			<li>
				<a href="{{route('profile.index')}}" class="btn-floating green tooltipped modal-trigger" data-position="top" data-tooltip="個人資料">
					<i class="material-icons">perm_identity</i>
				</a>
			</li>
		</ul>
	</div>

	<div class="container">
		<div class="row">
			<div class="col m4">
				<div class="card blue-grey darken-1">
					<div class="card-content white-text">
						<h4 class="card-title">銷售數量</h4>
						<h4>總銷售數量：{{ $totalSalesQuantity }}</h4>
					</div>
				</div>
			</div>
			<div class="col m4">
				<div class="card blue-grey darken-1">
					<div class="card-content white-text">
						<h4 class="card-title">銷售額</h4>
						<h4>總銷售額：{{ $totalSalesAmount }}</h4>
					</div>
				</div>
			</div>
			<div class="col m4">
				<div class="card blue-grey darken-1">
					<div class="card-content white-text">
						<h4 class="card-title">使用者數量</h4>
						<h4>使用者數量：{{ $userCount }}</h4>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<ul class="tabs">
			<li class="tab col s6"><a href="#products">產品列表</a></li>
			<li class="tab col s6"><a href="#users">使用者列表</a></li>
		</ul>
	</div>

	<div id="products" class="container">
		<h4 class="center">使用者列表</h4>
		<ul class="pagination center">
			<li class="waves-effect {{ $users->currentPage() == 1 ? 'disabled' : '' }}">
				<a href="{{ $users->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a>
			</li>
			@for ($i = 1; $i <= $users->lastPage(); $i++)
				@if ($i == 1 || $i == $users->lastPage() || abs($users->currentPage() - $i) < 3 || $i == $users->currentPage())
					<li class="waves-effect {{ $i == $users->currentPage() ? 'active brown' : '' }}">
						<a href="{{ $users->url($i) }}">{{ $i }}</a>
					</li>
				@elseif (abs($users->currentPage() - $i) === 3)
					<li class="disabled">
						<span>...</span>
					</li>
				@endif
			@endfor
			<li class="waves-effect {{ $users->currentPage() == $users->lastPage() ? 'disabled' : '' }}">
				<a href="{{ $users->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a>
			</li>
		</ul>
		@if ($users->isEmpty())
			<h3 class="center-align">目前沒有使用者</h3>
		@else
			<table class="responsive-table">
				<thead>
					<tr>
						<th>帳號</th>
						<th>姓名</th>
						<th>信箱</th>
						<th>電話</th>
						<th>權限</th>
						<th>狀態</th>
						<th>創建日期</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $user)
					<tr>
						<td>{{ $user->account }}</td>
						<td>{{ $user->name }}</td>
						<td>{{ $user->email }}</td>
						<td>{{ $user->cellphone }}</td>
						<td>{{ $user->administration }}</td>
						<td>{{ $user->status }}</td>
						<td>{{ $user->created_at }}</td>
						<td>
							<form action="{{ route('management.update', ['user' => $user->id]) }}" method="POST">
								@csrf
								@method('PUT')
								<div class="row">
									<div class="input-field col m6">
										<select name="administration">
											<option value="1" {{ $user->administration == 1 ? 'selected' : '' }}>1</option>
											<option value="2" {{ $user->administration == 2 ? 'selected' : '' }}>2</option>
											<option value="3" {{ $user->administration == 3 ? 'selected' : '' }}>3</option>
											<option value="4" {{ $user->administration == 4 ? 'selected' : '' }}>4</option>
											<option value="5" {{ $user->administration == 5 ? 'selected' : '' }}>5</option>
										</select>
										<label>權限</label>
									</div>
									<div class="input-field col m6">
										<select name="status">
											<option value="0" {{ $user->status == 0 ? 'selected' : '' }}>0</option>
											<option value="1" {{ $user->status == 1 ? 'selected' : '' }}>1</option>
										</select>
										<label>狀態</label>
									</div>
								</div>
								<button class="waves-effect waves-light btn brown right" type="submit">更新</button>
							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		@endif
	</div>

	<div id="users" class="container">
		<h4 class="center">產品列表</h4>
		<ul class="pagination center">
			<li class="waves-effect {{ $products->currentPage() == 1 ? 'disabled' : '' }}">
				<a href="{{ $products->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a>
			</li>
			@for ($i = 1; $i <= $products->lastPage(); $i++)
				@if ($i == 1 || $i == $products->lastPage() || abs($products->currentPage() - $i) < 3 || $i == $products->currentPage())
					<li class="waves-effect {{ $i == $products->currentPage() ? 'active brown' : '' }}">
						<a href="{{ $products->url($i) }}">{{ $i }}</a>
					</li>
				@elseif (abs($products->currentPage() - $i) === 3)
					<li class="disabled">
						<span>...</span>
					</li>
				@endif
			@endfor
			<li class="waves-effect {{ $products->currentPage() == $products->lastPage() ? 'disabled' : '' }}">
				<a href="{{ $products->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a>
			</li>
		</ul>
		@if ($products->isEmpty())
			<h3 class="center-align">目前沒有產品</h3>
		@else
			<table class="responsive-table">
				<thead>
					<tr>
						<th>產品名稱</th>
						<th>價格</th>
						<th>數量</th>
						<th>品質</th>
						<th>描述</th>
						<th>圖片</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					@foreach($products as $product)
						<tr>
							<td>{{ $product->product }}</td>
							<td>{{ $product->price }}</td>
							<td>{{ $product->quantity }}</td>
							<td>{{ $product->quality }}</td>
							<td>{{ $product->description }}</td>
							<td><img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->image_name }}" style="max-width: 100px;"></td>
							<td>
								<form action="{{ route('product.destroy', ['product' => $product->id]) }}" method="POST" onsubmit="return confirm('確定刪除產品？');">
									@csrf
									@method('DELETE')
									<button class="waves-effect waves-light btn red" type="submit">刪除</button>
								</form>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@endif
	</div>

	<br>
	
    @include('component.footer')
	
</div>
<!--  Scripts-->
<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
<script src="https://unpkg.com/vue-router@4"></script>
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.11"></script>
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="{{ asset('js/materialize.min.js') }}"></script>
<script src="{{ asset('js/init.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('.fixed-action-btn').floatingActionButton({
			direction: 'left',
			hoverEnabled: false
		});
		$('.tabs').tabs();
		$('.parallax').parallax();
		$('.button-collapse').sidenav();
		$('.carousel.carousel-slider').carousel({ fullWidth: true });
		$('.modal').modal();
		$('.materialboxed').materialbox();
		$('.tooltipped').tooltip();
		$('.chips').chips();
		$('.collapsible').collapsible();
		$('.carousel').carousel();
		$('.slider').slider({ fullWidth: true });
		$('select').formSelect();
		$('.sidenav').sidenav();
	});
</script>
</body>
</html>
@extends('layouts.app')

@section('content')
	
	@include('component.navigation')
	
    @include('component.serve.message')

    @include('component.logoutbanner')
	
	<div class="fixed-action-btn click-to-toggle">
		<a class="btn-floating btn-large">
			<i class="large material-icons black">menu</i>
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
		<a href="{{ route('management.index') }}" class="btn black">管理後台</a>
		<a href="{{ route('management.orders') }}" class="btn black">訂單管理</a>
		<a href="{{ route('management.products') }}" class="btn black">產品列表</a>
		<a href="{{ route('management.users') }}" class="btn black">使用者列表</a>
	</div>

	<br>
	
    @include('component.footer')
	
@endsection
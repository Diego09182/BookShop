@extends('layouts.app')

@section('content')
	
	@include('component.navigation')
	
    @include('component.serve.message')

    @include('component.logoutbanner')
	
	<div class="fixed-action-btn click-to-toggle">
		<a class="btn-floating btn-large black">
			<i class="large material-icons">menu</i>
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
			<div class="row center">
				<a href="{{ route('product.create') }}" class="waves-effect waves-light btn black"><i class="material-icons left">mode_edit</i>商品發表</a>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="row center">
				<a href="{{ route('product.showCart') }}" class="waves-effect waves-light btn black">查看購物車</a>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col m8 offset-m2">
				<div class="card horizontal">
					<div class="card-image">
						@if ($user->avatar)
							<img src="{{ asset($user->avatar) }}" alt="User Avatar" class="responsive-img materialboxed">
						@else
							<img src="{{ asset('SHOP.png') }}" alt="Placeholder Image" class="responsive-img materialboxed">
						@endif
					</div>
					<div class="card-stacked">
						<div class="card-content">
							<h4>商家名稱:{{ $bookshop->business_name }}</h4>
							<h4>賣家名稱:{{ $bookshop->name }}</h4>
							<h4>商家介紹:{{ $bookshop->business_description }}</h4>
						</div>
						<div class="card-action">
							<a class="right" href="{{ $bookshop->business_website }}">官方網址</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<h3 class="center-align">商家產品</h3>
			<br>
			@if ($products->isEmpty())
				<h3 class="center-align">目前沒有商品</h3>
			@else
				<ul class="pagination center">
					@if ($products->lastPage() > 1)
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
					@endif
				</ul>
				@foreach ($products as $product)
					<div class="col s12 m4">
						<div class="card hoverable center">
							<div class="card-content">
								@if ($product->image_path)
									<img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->product }}" class="responsive-img materialboxed">
								@else
									<img src="{{ asset('SHOP.png') }}" alt="Placeholder Image" class="responsive-img materialboxed">
								@endif
								<h5 class="truncate"><b>商品名稱: {{ $product->product }}</b></h5>
								<br>
								<p class="left">價格: {{ $product->price }}</p>
								<p class="right">數量: {{ $product->quantity }}</p>
								<br>
								<p class="left">品質: {{ $product->quality }}</p>
								<br>
								<p class="left">描述: {{ $product->description }}</p>
								<br>
								<p class="right">商家: {{ $product->user->account }}</p>
								<br><br>
								<div class="row">
									<a class="waves-effect waves-light btn right black" href="{{ route('product.show', ['product' => $product->id]) }}">查看</a>
								</div>
								<br>
							</div>
						</div>
					</div>
				@endforeach
			@endif
		</div>
	</div>

	<br>
	
	@include('component.contact')
	
	<br>
	
    @include('component.footer')
	
@endsection
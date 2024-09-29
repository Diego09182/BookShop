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
				<a href="{{ route('product.showCart') }}" class="waves-effect waves-light btn black">查看購物車</a>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<form action="{{ route('product.search') }}" method="GET">
				<div class="input-field col m12">
					<i class="material-icons prefix">search</i>
					<input name="search" id="icon_prefix" type="text" class="validate">
					<label for="icon_prefix">Search</label>
				</div>
			</form>
		</div>
		<div class="row">
			<form action="{{ route('product.filter') }}" method="GET">
				<div class="input-field col m4">
					<select name="filter">
						<option value="" disabled selected>熱度篩選</option>
						<option value="觀看次數">觀看次數</option>
						<option value="喜歡次數">喜歡次數</option>
					</select>
					<label>產品篩選</label>
				</div>
				<div class="input-field">
					<button type="submit" class="btn waves-effect waves-light black right">產品篩選</button>
				</div>
			</form>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<h3 class="center-align">搜尋結果</h3>
			<br>
			<ul class="pagination center">
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
			</ul>
			@if(count($products) > 0)
				@foreach ($products as $product)
					<div class="col s12 m4">
						<div class="card hoverable center">
							<div class="card-content">
								@if ($product->image_path)
									<img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->product }}" class="responsive-img">
								@else
									<img src="{{ asset('placeholder_image.jpg') }}" alt="Placeholder Image" class="responsive-img">
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
			@else
				<h3 class="center-align">沒有搜尋到相關商品</h3>
			@endif
		</div>
	</div>
	
	<br>
	
	@include('component.contact')
	
	<br>
	
    @include('component.footer')
	
@endsection
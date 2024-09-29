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
		<a href="{{ route('management.index') }}" class="btn black">管理後台</a>
		<a href="{{ route('management.orders') }}" class="btn black">訂單管理</a>
		<a href="{{ route('management.products') }}" class="btn black">產品列表</a>
		<a href="{{ route('management.users') }}" class="btn black">使用者列表</a>
	</div>

	<div class="container">
		<h4 class="center">產品列表</h4>
		@if ($products->total() > 0)
			<ul class="pagination center">
				<li class="waves-effect {{ $products->currentPage() == 1 ? 'disabled' : '' }}">
					<a href="{{ $products->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a>
				</li>
				@for ($i = 1; $i <= $products->lastPage(); $i++)
					@if ($i == 1 || $i == $products->lastPage() || abs($products->currentPage() - $i) < 3 || $i == $products->currentPage())
						<li class="waves-effect {{ $i == $products->currentPage() ? 'active black' : '' }}">
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
		@endif
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
							@if ($product->image_path)
								<td><img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->image_name }}" style="max-width: 100px;"></td>
							@else
								<td><img src="{{ asset('SHOP.png') }}" alt="Placeholder Image" class="responsive-img" style="max-width: 100px;"></td>
							@endif
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
	
@endsection
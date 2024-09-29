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
				<a href="#modal1" class="btn-floating red tooltipped modal-trigger" data-position="top" data-tooltip="發布評論">
					<i class="material-icons">mode_edit</i>
				</a>
			</li>
		</ul>
	</div>

	@include('component.form.comment')
	
	<br>

	<div class="container">
		<div class="row">
			<div class="col s12 m3">
				<div class="card">
					<div class="card-image">
						@if ($product->user->avatar)
							<img src="{{ asset($product->user->avatar) }}" alt="User Avatar" class="responsive-img materialboxed">
						@else
							<img src="{{ asset('SHOP.png') }}" alt="Placeholder Image" class="responsive-img materialboxed">
						@endif
					</div>
					<div class="card-content">
						<div class="row">
							<a href="{{ route('shop.index', ['shop' => $product->user_id]) }}" class="modal-trigger btn-floating waves-effect waves-light black left tooltipped" data-delay="50" data-tooltip="個人賣場"><i class="material-icons">shopping_cart</i></a>
							<a href="#modal2" class="modal-trigger btn-floating waves-effect waves-light black right tooltipped" data-delay="50" data-tooltip="個人資料"><i class="material-icons">perm_identity</i></a>
						</div>
						<h5>商家:</h5>
						<h5 class="center">{{ $product->user->account }}</h5>
					</div>
				</div>
				<ul class="collapsible" data-collapsible="accordion">
					<li>
						<div class="collapsible-header"><i class="material-icons">info</i>商家簡介</div>
						<div class="collapsible-body center"><h4>{{ $product->description }}</h4></div>
					</li>
				</ul>
			</div>
			<div class="col s12 m9 right">
				<div class="card horizontal">
					<div class="card-image">
						@if ($product->image_path)
							<img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->product }}" class="responsive-img materialboxed">
						@else
							<img src="{{ asset('SHOP.png') }}" alt="Placeholder Image" class="responsive-img materialboxed">
						@endif
					</div>
					<div class="card-stacked">
						<div class="card-content">
							<div class="row">
								<h3 class="center">{{ $product->product }}</h3>
							</div>
							<h3><strong>價格:</strong> ${{ $product->price }}</h3>
							<h3><strong>品質:</strong> {{ $product->quality }}</h3>
							<h3><strong>描述:</strong> {!! $product->description !!}</h3>
							<br>
							<div class="row">
								<h3 class="right"><strong>庫存數量:</strong> {{ $product->quantity }}</h3>
							</div>
							<div class="row">
								<div class="chip left black">
									<p class="white-text">#{{ $product->tag }}</p>
								</div>
								<p class="right">觀看次數: {{ $product->view }}</p>
								<br>
								<p class="right">上架時間: {{ $product->created_at }}</p>
							</div>
							<div class="card-action">
								<div class="row">
									<p class="left">讚: {{ $product->like}} 噓: {{ $product->dislike }}</p>
									<form method="POST" action="{{ route('product.dislike', $product->id) }}">
										@csrf
										<button type="submit" class="btn-floating waves-effect waves-light black right tooltipped" data-delay="50" data-tooltip="噓他"><i class="material-icons">thumb_down</i></button>
									</form>
									<form method="POST" action="{{ route('product.like', $product->id) }}">
										@csrf
										<button type="submit" class="btn-floating waves-effect waves-light black right tooltipped" data-delay="50" data-tooltip="按讚"><i class="material-icons">thumb_up</i></button>
									</form>
								</div>
								<div class="row">
									<form method="GET" action="{{ route('product.edit', $product->id) }}">
										@csrf
										<button type="submit" class="btn waves-effect waves-light black right">編輯產品</button>
									</form>
									<form method="POST" action="{{ route('product.addToCart', ['product' => $product->id]) }}">
										@csrf
										<div class="input-field">
											<input id="quantity" name="quantity" type="number" value="1" min="1" max="{{ $product->quantity }}" required>
											<label for="quantity">購買數量</label>
										</div>
										<button type="submit" class="btn waves-effect waves-light black right">加入購物車</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="modal2" class="modal">
		<div class="modal-content">
			<h4 class="center-align">商家資料</h4>
			<div class="row">
				<div class="col s12 m4">
					<div class="card">
						<div class="card-image">
							<img src="{{ asset('storage/'.$product->image_path) }}">
						</div>
						<div class="card-content">
							<h5 class="center">{{ $product->user->account }}</h5>
						</div>
					</div>
				</div>
				<div class="col s12 m8">
					<div class="card">
						<div class="card-content">
							<h5>商家簡介:</h5>
							<h5>{{ $product->user->business_description }}</h5>
							<h5>商家地址: {{ $product->user->business_address }}</h5>
							<h5>商品數量: {{ $product->user->product_quantity }}</h5>
							<h5>上站次數: {{ $product->user->times }}</h5>
							<h5>商家網站:</h5>
							@if ($product->user->business_website)
								<h5>{{ $product->user->business_website }}</h5>
								<a href="{{ $product->user->business_website }}" class="modal-action modal-close waves-effect waves-green brown btn right">前往</a>
							@endif
							<h5>創建時間: {{ $product->user->created_at }}</h5>
							<br>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

    <br>

	@if ($comments->isEmpty())
        <h3 class="center-align">目前沒有評價</h3>
    @else
		<ul class="pagination center">
			@if ($comments->currentPage() > 1)
				<li class="waves-effect"><a href="{{ $comments->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a></li>
			@endif
			@for ($i = 1; $i <= $comments->lastPage(); $i++)
				@if ($i == 1 || $i == $comments->lastPage() || abs($comments->currentPage() - $i) < 3 || $i == $comments->currentPage())
					<li class="waves-effect {{ $i == $comments->currentPage() ? 'active black' : '' }}"><a href="{{ $comments->url($i) }}">{{ $i }}</a></li>
				@elseif (abs($comments->currentPage() - $i) === 3)
					<li class="disabled">
						<span>...</span>
					</li>
				@endif
			@endfor
			@if ($comments->hasMorePages())
				<li class="waves-effect"><a href="{{ $comments->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a></li>
			@endif
		</ul>
		@foreach ($comments as $comment)
			<div class="container">
				<ul class="collection">
					<li class="collection-item avatar">
						<br>
						<img src="{{ asset($comment->user->avatar) }}" alt="評論者頭像" class="circle">
						<span class="left">{{ $comment->title }}</span>
						<br>
						<span class="left">
							@for($i = 1; $i <= 5; $i++)
								@if($i <= $comment->star)
									<i class="material-icons">star</i>
								@else
									<i class="material-icons">star_border</i>
								@endif
							@endfor
						</span>
						<span class="right">回覆者:{{ $comment->user->account }}</span>
						<br>
						<p class="right">回覆時間:{{ $comment->created_at }}</p>
						<br>
						<form action="{{ route('comment.destroy', ['product' => $product->id, 'comment' => $comment->id]) }}" method="POST">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn-floating waves-effect waves-light black right tooltipped" data-delay="50" data-tooltip="刪除評論">
								<i class="material-icons">delete</i>
							</button>
						</form>
						<br><br>
						<hr>
						<p class="left">{{ $comment->content }}</p>
						<br><br><br>
					</li>
				</ul>
			</div>
		@endforeach
	@endif

	<br>
	
    @include('component.footer')
	
@endsection
@extends('layouts.app')

@section('content')
	
	@include('component.navigation')
	
    @include('component.serve.message')

    @include('component.logoutbanner')
	
	<div class="fixed-action-btn click-to-toggle">
		<a class="btn-floating btn-large red">
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
        @if(count($cart) > 0)
            <table class="striped">
                <thead>
                    <tr>
                        <th>商品名稱</th>
                        <th>價格</th>
                        <th>數量</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->product }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->quantity_in_cart }}</td>
                            <td>
                                <form action="{{ route('product.removeFromCart', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="waves-effect waves-light btn red">刪除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <h4 class="right">總價: {{ $totalPrice }}元</h4>
            <br><br><br><br>
            <form action="{{ route('product.purchase') }}" method="POST">
                @csrf
                <button type="submit" class="waves-effect waves-light btn black right">購買</button>
            </form>
        @else
            <h1 class="center">購物車是空的</h1>
        @endif
    </div>


	<br>
	
	@include('component.contact')
	
	<br>
	
    @include('component.footer')
	
@endsection

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
        <div class="card">
            <div class="card-content">
                <h4 class="center">帳單</h4>
                @if(count($cart) > 0)
                    <table class="striped">
                        <thead>
                            <tr>
                                <th>商品名稱</th>
                                <th>價格</th>
                                <th>數量</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $item)
                                <tr>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['price'] }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h4 class="right">總價:{{ $totalPrice }}元</h4>
                    <br><br><br><br>
                @else
                    <h1 class="center">購物車是空的</h1>
                @endif
                <span class="card-title">購買者資料</span>
                <p>帳號:{{ $user->account }}</p>
                <p>姓名：{{ $user->name }}</p>
                <p>Email：{{ $user->email }}</p>
            </div>
        </div>
    </div>

	<br>
	
	@include('component.contact')
	
	<br>
	
    @include('component.footer')

@endsection
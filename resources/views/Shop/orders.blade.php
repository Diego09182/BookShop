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
		<a href="{{ route('management.index') }}" class="btn black">管理後台</a>
		<a href="{{ route('management.orders') }}" class="btn black">訂單管理</a>
		<a href="{{ route('management.products') }}" class="btn black">產品列表</a>
		<a href="{{ route('management.users') }}" class="btn black">使用者列表</a>
	</div>

    @if ($orders->total() > 0)
		<ul class="pagination center">
			<li class="waves-effect {{ $orders->currentPage() == 1 ? 'disabled' : '' }}">
				<a href="{{ $orders->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a>
			</li>
			@for ($i = 1; $i <= $orders->lastPage(); $i++)
				@if ($i == 1 || $i == $orders->lastPage() || abs($orders->currentPage() - $i) < 3 || $i == $orders->currentPage())
					<li class="waves-effect {{ $i == $orders->currentPage() ? 'active black' : '' }}">
						<a href="{{ $orders->url($i) }}">{{ $i }}</a>
					</li>
				@elseif (abs($orders->currentPage() - $i) === 3)
					<li class="disabled">
						<span>...</span>
					</li>
				@endif
			@endfor
			<li class="waves-effect {{ $orders->currentPage() == $orders->lastPage() ? 'disabled' : '' }}">
				<a href="{{ $orders->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a>
			</li>
		</ul>
	@endif

	<div class="container">
        <h2>訂單列表</h2>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>產品名稱</th>
                    <th>數量</th>
                    <th>總價</th>
                    <th>狀態</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->product_name }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ $order->total_price }}</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            @if($order->status == '未出貨')
                                <form action="{{ route('orders.update', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn black">標記為已出貨</button>
                                </form>
                            @else
                                無法操作
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

	<br>
	
    @include('component.footer')
	
@endsection
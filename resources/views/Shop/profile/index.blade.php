@extends('layouts.app')

@section('content')
	
	@include('component.navigation')
	
    @include('component.serve.message')

    @include('component.logoutbanner')
	
	<br>
	
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
						<h4 class="card-title">商品種類</h4>
						<h4>總種類數：{{ $productClass }}</h4>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<h3 class="center-align">購買紀錄</h3>
		<div class="row">
			<div class="col s12">
				<div class="card">
					<div class="card-content">
						<table class="striped">
							<thead>
								<tr>
									<th>商品名稱</th>
									<th>數量</th>
									<th>總價</th>
								</tr>
							</thead>
							<tbody>
								@foreach($purchaseRecords as $record)
								<tr>
									<td>{{ $record->product_name }}</td>
									<td>{{ $record->quantity }}</td>
									<td>{{ $record->total_price }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<ul class="pagination center">
					@if ($purchaseRecords->lastPage() > 1)
						<li class="waves-effect {{ $purchaseRecords->currentPage() == 1 ? 'disabled' : '' }}">
							<a href="{{ $purchaseRecords->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a>
						</li>
						@for ($i = 1; $i <= $purchaseRecords->lastPage(); $i++)
							@if ($i == 1 || $i == $purchaseRecords->lastPage() || abs($purchaseRecords->currentPage() - $i) < 3 || $i == $purchaseRecords->currentPage())
								<li class="waves-effect {{ $i == $purchaseRecords->currentPage() ? 'active brown' : '' }}">
									<a href="{{ $purchaseRecords->url($i) }}">{{ $i }}</a>
								</li>
							@elseif (abs($purchaseRecords->currentPage() - $i) === 3)
								<li class="disabled">
									<span>...</span>
								</li>
							@endif
						@endfor
						<li class="waves-effect {{ $purchaseRecords->currentPage() == $purchaseRecords->lastPage() ? 'disabled' : '' }}">
							<a href="{{ $purchaseRecords->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</div>

	<div class="container">
		<h3 class="center-align">使用者資料</h3>
		<div class="card">
			<form name="ProfileForm" method="post" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="card blue-grey">
					<div class="card-content white-text">
						<span class="card-title">使用者資料(標示「*」欄位請務必填寫)</span>
						<div class="input-field col s6">
							<p>*使用者帳號:</p>
							<br>
							<p>{{ $user->account }}</p>
						</div>
						<div class="row">
							<div class="input-field col m6">
								*使用者密碼：
								<input name="password" type="password" class="validate" value="">
								(請使用英文或數字鍵，勿使用特殊字元)
							</div>
							<div class="input-field col m6">
								*密碼更新：
								<input name="new_password" type="password" class="validate" value="">
								(再輸入一次密碼，並記下您的使用者名稱與密碼)
							</div>
						</div>
						<div class="row">
							<div class="input-field col m6">
								*使用者姓名：
								<input name="name" id="name" type="text" class="validate" value="{{ $user->name }}">
							</div>
							<div class="input-field col m6 black-text">
								*生日:
								<input name="birthday" value="{{ $user->birthday }}" type="text" class="datepicker">
							</div>
						</div>
						<div class="row">
							<div class="input-field col m12">
								*E-mail
								<input name="email" type="text" value="{{ $user->email }}">
							</div> 
						</div>
						<div class="row">
							<div class="input-field col m12">
								*行動電話：
								<input name="cellphone" type="text" value="{{ $user->cellphone }}">
							</div>
						</div>
						<div class="row">
							<div class="input-field col m6">
								業務名稱：
								<input name="business_name" type="text" value="{{ $user->business_name }}">
							</div>
							<div class="input-field col m6">
								業務地址：
								<input name="business_address" type="text" value="{{ $user->business_address }}">
							</div>
						</div>
						<div class="row">
							<div class="input-field col m12">
								業務網站：
								<input name="business_website" type="text" value="{{ $user->business_website }}">
							</div>
						</div>
						<div class="row">
							<div class="input-field col m12">
								業務描述：
								<textarea name="business_description" id="textarea1" class="materialize-textarea">{{ $user->business_description }}</textarea>
							</div>
						</div>
						<div class="row">
							<div class="file-field input-field m12">
								<div class="btn">
									<span>頭像上傳</span>
									<input name="avatar" type="file">
								</div>
								<div class="file-path-wrapper">
									<input class="file-path validate" type="text">
								</div>
							</div>
						</div>
						<br>
						<div class="card-action center-align">
							<button type="submit" class="waves-effect waves-light btn brown">確定</button>
							<br><br>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>


	<br>
	
    @include('component.footer')
	
@endsection
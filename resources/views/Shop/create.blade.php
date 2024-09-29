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
        <div class="card blue-grey darken-1">
            <form name="ProductForm" method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-content white-text">
                    <span class="card-title">發表商品</span>
                    <div class="row">
                        <div class="input-field col m6">
                            <i class="material-icons prefix">mode_edit</i>
                            <input class="validate" name="product" type="text">
                            <label for="icon_prefix2">商品名稱</label>
                        </div>
                        <div class="input-field col m6">
                            <i class="material-icons prefix">attach_money</i>
                            <input class="validate" name="price" type="number">
                            <label for="icon_prefix2">價格</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m6">
                            <i class="material-icons prefix">list</i>
                            <input class="validate" name="quantity" type="number">
                            <label for="icon_prefix2">數量</label>
                        </div>
                        <div class="input-field col m6">
                            <i class="material-icons prefix">grade</i>
                            <input class="validate" name="quality" type="text">
                            <label for="icon_prefix2">品質</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m12">
                            <i class="material-icons prefix">mode_edit</i>
                            <textarea class="materialize-textarea" name="description"></textarea>
                            <label for="icon_prefix2">商品描述</label>
                        </div>
                    </div>
                    <div class="file-field input-field">
                        <div class="btn brown">
                            <span>上傳圖片</span>
                            <input type="file" name="product_image">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                    <button class="waves-effect waves-light btn brown right" type="submit">發布商品</button>
                    <br>
                </div>
            </form>
        </div>
    </div>

	<br>
	
	@include('component.contact')
	
	<br>
	
    @include('component.footer')
	
@endsection
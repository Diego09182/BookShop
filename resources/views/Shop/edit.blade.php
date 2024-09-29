@extends('layouts.app')

@section('content')
	
	@include('component.navigation')
	
    @include('component.serve.message')

    @include('component.logoutbanner')

	<div class="container">
        <div class="card blue-grey darken-1">
            <form name="ProductForm" method="post" action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-content white-text">
                    <span class="card-title">更新商品</span>
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
                        <div class="btn black">
                            <span>上傳圖片</span>
                            <input type="file" name="product_image">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                    <button class="waves-effect waves-light btn black right" type="submit">更新商品</button>
                    <br><br>
                </div>
            </form>
        </div>
    </div>

	<br>
	
	@include('component.contact')
	
	<br>
	
    @include('component.footer')
	
@endsection
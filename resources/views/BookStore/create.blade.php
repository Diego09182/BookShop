<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
	<title>BookShop</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('css/materialize.min.css') }}">
	<link href="{{ asset('css/style.css') }}" type="text/css" rel="stylesheet" media="screen,projection"/>
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet">
	<link rel="shortcut icon" href="{{ asset('images/SHOP.png') }}" type="image/x-icon" />
</head>
<body>
<div id="app">
	
	@include('component.navigation')
	
    @include('component.serve.message')

    @include('component.logoutbanner')

	<div class="container">
    <div class="card blue-grey darken-1">
        <form name="PostForm" method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
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
	
</div>
<!--  Scripts-->
<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
<script src="https://unpkg.com/vue-router@4"></script>
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.11"></script>
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="{{ asset('js/materialize.min.js') }}"></script>
<script src="{{ asset('js/init.js') }}"></script>
<script type="text/javascript"></script>
</body>
</html>
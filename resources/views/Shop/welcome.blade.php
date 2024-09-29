@extends('layouts.app')

@section('content')

<div id="app">

	<div class="container">
		<tool></tool>
	</div>
	
    @include('component.navigation')

	@include('component.serve.message')
	
    @include('component.banner')

    @include('component.form.login')

    @include('component.form.register')

	<br>
	
	<router-view></router-view>
	
	<br>
	
    @include('component.contact')
	
	<br>
	
    @include('component.footer')
	
</div>

@endsection